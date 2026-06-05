<?php

namespace App\Services;

use App\Contracts\Feature2RepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;

class PdoFeature2Repository implements Feature2RepositoryInterface
{
    public function getInstructorsPaginated(int $page, int $perPage): array
    {
        $pdo = DB::connection()->getPdo();
        $offset = ($page - 1) * $perPage;

        $countStmt = $pdo->prepare('SELECT COUNT(*) FROM instructeurs WHERE IsActief = 1');
        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        $stmt = $pdo->prepare(
            'SELECT Id,
                    Voornaam,
                    Tussenvoegsel,
                    Achternaam,
                    Mobiel,
                    DatumInDienst,
                    AantalSterren
             FROM instructeurs
             WHERE IsActief = 1
             ORDER BY AantalSterren DESC, Achternaam ASC
             LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => max(1, (int) ceil($total / max(1, $perPage))),
        ];
    }

    public function getInstructorById(int $instructorId): ?array
    {
        $pdo = DB::connection()->getPdo();

        $stmt = $pdo->prepare(
            'SELECT Id, Voornaam, Tussenvoegsel, Achternaam, AantalSterren
             FROM instructeurs
             WHERE Id = :id AND IsActief = 1
             LIMIT 1'
        );
        $stmt->bindValue(':id', $instructorId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public function getInstructorVehiclesPaginated(int $instructorId, int $page, int $perPage): array
    {
        $pdo = DB::connection()->getPdo();
        $offset = ($page - 1) * $perPage;

        $countStmt = $pdo->prepare(
            'SELECT COUNT(*)
             FROM instructeur_voertuigen iv
             INNER JOIN voertuigen v ON v.Id = iv.VoertuigId
             WHERE iv.InstructeurId = :instructorId
               AND iv.IsActief = 1
               AND v.IsActief = 1'
        );
        $countStmt->bindValue(':instructorId', $instructorId, PDO::PARAM_INT);
        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        $stmt = $pdo->prepare(
            'SELECT iv.Id AS InstructeurVoertuigId,
                    v.Id AS VoertuigId,
                    tv.TypeVoertuig,
                    v.Kenteken,
                    v.Bouwjaar,
                    tv.Rijbewijscategorie,
                    v.BrandstofType
             FROM instructeur_voertuigen iv
             INNER JOIN voertuigen v ON v.Id = iv.VoertuigId
             INNER JOIN type_voertuigen tv ON tv.Id = v.TypeVoertuigId
             WHERE iv.InstructeurId = :instructorId
               AND iv.IsActief = 1
               AND v.IsActief = 1
             ORDER BY tv.Rijbewijscategorie DESC
             LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue(':instructorId', $instructorId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => max(1, (int) ceil($total / max(1, $perPage))),
        ];
    }

    public function unassignVehicleFromInstructor(int $instructorId, int $vehicleId): bool
    {
        $pdo = DB::connection()->getPdo();

        try {
            $pdo->beginTransaction();

            try {
                $callStmt = $pdo->prepare('CALL sp_unassign_vehicle_from_instructeur(:instructeur_id, :voertuig_id)');
                $callStmt->bindValue(':instructeur_id', $instructorId, PDO::PARAM_INT);
                $callStmt->bindValue(':voertuig_id', $vehicleId, PDO::PARAM_INT);
                $callStmt->execute();

                while ($callStmt->nextRowset()) {
                    // Leeg eventuele extra resultsets van de procedure.
                }
            } catch (PDOException) {
                $fallbackStmt = $pdo->prepare(
                    'UPDATE instructeur_voertuigen
                     SET IsActief = 0,
                         DatumGewijzigd = CURRENT_TIMESTAMP(6),
                         Opmerking = :opmerking
                     WHERE InstructeurId = :instructorId
                       AND VoertuigId = :vehicleId
                       AND IsActief = 1'
                );
                $fallbackStmt->bindValue(':opmerking', 'Toewijzing verwijderd via fallback zonder stored procedure.');
                $fallbackStmt->bindValue(':instructorId', $instructorId, PDO::PARAM_INT);
                $fallbackStmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_INT);
                $fallbackStmt->execute();

                if ($fallbackStmt->rowCount() < 1) {
                    $pdo->rollBack();
                    return false;
                }
            }

            $pdo->commit();
            return true;
        } catch (PDOException $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            Log::error('Kon voertuig niet loskoppelen van instructeur.', [
                'exception' => $exception->getMessage(),
                'instructor_id' => $instructorId,
                'vehicle_id' => $vehicleId,
            ]);

            return false;
        }
    }

    public function getAllVehiclesPaginated(int $page, int $perPage): array
    {
        $pdo = DB::connection()->getPdo();
        $offset = ($page - 1) * $perPage;

        $countStmt = $pdo->prepare('SELECT COUNT(*) FROM voertuigen WHERE IsActief = 1');
        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        $stmt = $pdo->prepare(
            'SELECT v.Id AS VoertuigId,
                    tv.TypeVoertuig,
                    v.Kenteken,
                    v.Bouwjaar,
                    tv.Rijbewijscategorie,
                    v.BrandstofType,
                    i.Id AS InstructeurId,
                    i.Achternaam AS InstructeurAchternaam
             FROM voertuigen v
             INNER JOIN type_voertuigen tv ON tv.Id = v.TypeVoertuigId
             LEFT JOIN instructeur_voertuigen iv
                    ON iv.VoertuigId = v.Id
                   AND iv.IsActief = 1
             LEFT JOIN instructeurs i
                    ON i.Id = iv.InstructeurId
                   AND i.IsActief = 1
             WHERE v.IsActief = 1
               ORDER BY v.Bouwjaar DESC, COALESCE(i.Achternaam, \'\') DESC
             LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => max(1, (int) ceil($total / max(1, $perPage))),
        ];
    }

    public function getVehicleAssignmentState(int $vehicleId): ?array
    {
        $pdo = DB::connection()->getPdo();

        $stmt = $pdo->prepare(
            'SELECT v.Id,
                    v.IsActief,
                    iv.InstructeurId
             FROM voertuigen v
             LEFT JOIN instructeur_voertuigen iv
                    ON iv.VoertuigId = v.Id
                   AND iv.IsActief = 1
             WHERE v.Id = :vehicleId
             LIMIT 1'
        );
        $stmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return [
            'id' => (int) $row['Id'],
            'is_active' => (int) $row['IsActief'] === 1,
            'is_assigned' => ! empty($row['InstructeurId']),
        ];
    }

    public function deleteAssignedVehicle(int $vehicleId): bool
    {
        $pdo = DB::connection()->getPdo();

        try {
            $pdo->beginTransaction();

            $deleteAssignmentStmt = $pdo->prepare(
                'DELETE FROM instructeur_voertuigen
                 WHERE VoertuigId = :vehicleId'
            );
            $deleteAssignmentStmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_INT);
            $deleteAssignmentStmt->execute();

            $deleteVehicleStmt = $pdo->prepare(
                'DELETE FROM voertuigen
                 WHERE Id = :vehicleId'
            );
            $deleteVehicleStmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_INT);
            $deleteVehicleStmt->execute();

            if ($deleteVehicleStmt->rowCount() < 1) {
                $pdo->rollBack();
                return false;
            }

            $pdo->commit();
            return true;
        } catch (PDOException $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            Log::error('Kon toegewezen voertuig niet verwijderen.', [
                'exception' => $exception->getMessage(),
                'vehicle_id' => $vehicleId,
            ]);

            return false;
        }
    }

    public function setVehicleInactive(int $vehicleId): bool
    {
        $pdo = DB::connection()->getPdo();

        $stmt = $pdo->prepare(
            'UPDATE voertuigen
             SET IsActief = 0,
                 Opmerking = :opmerking,
                 DatumGewijzigd = CURRENT_TIMESTAMP(6)
             WHERE Id = :vehicleId
               AND IsActief = 1'
        );
        $stmt->bindValue(':opmerking', 'Niet toegewezen voertuig op non-actief gezet.');
        $stmt->bindValue(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
