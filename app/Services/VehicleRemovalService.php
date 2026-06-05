<?php

namespace App\Services;

use App\Contracts\Feature2RepositoryInterface;

class VehicleRemovalService
{
    public function __construct(
        private readonly Feature2RepositoryInterface $repository
    ) {
    }

    public function removeFromInstructor(int $instructorId, int $vehicleId): array
    {
        $removed = $this->repository->unassignVehicleFromInstructor($instructorId, $vehicleId);

        if (! $removed) {
            return [
                'success' => false,
                'message' => 'Het verwijderen is mislukt. Probeer het opnieuw.',
                'redirect_to' => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Het door u geselecteerde voertuig is verwijderd',
            'redirect_to' => route('instructors.vehicles', ['instructor' => $instructorId]),
        ];
    }

    public function removeFromAllVehicles(int $vehicleId): array
    {
        $state = $this->repository->getVehicleAssignmentState($vehicleId);

        if (! $state || ! $state['is_active']) {
            return [
                'success' => false,
                'message' => 'Het gekozen voertuig bestaat niet of is al niet actief.',
                'redirect_to' => null,
            ];
        }

        if (! $state['is_assigned']) {
            $this->repository->setVehicleInactive($vehicleId);

            return [
                'success' => false,
                'message' => 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd',
                'redirect_to' => null,
            ];
        }

        $removed = $this->repository->deleteAssignedVehicle($vehicleId);

        if (! $removed) {
            return [
                'success' => false,
                'message' => 'Het verwijderen is mislukt. Probeer het opnieuw.',
                'redirect_to' => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Het door u geselecteerde voertuig is verwijderd',
            'redirect_to' => route('vehicles.index'),
        ];
    }
}
