<?php

namespace Tests\Unit;

use App\Contracts\Feature2RepositoryInterface;
use App\Services\VehicleRemovalService;
use Tests\TestCase;

class VehicleRemovalServiceTest extends TestCase
{
    public function test_remove_from_instructor_returns_success_message(): void
    {
        $repository = new FakeFeature2Repository();
        $repository->unassignResult = true;

        $service = new VehicleRemovalService($repository);

        $result = $service->removeFromInstructor(1, 2);

        $this->assertTrue($result['success']);
        $this->assertSame('Het door u geselecteerde voertuig is verwijderd', $result['message']);
        $this->assertStringContainsString('/instructeurs/1/voertuigen', (string) $result['redirect_to']);
    }

    public function test_remove_from_all_vehicles_marks_not_assigned_vehicle_inactive(): void
    {
        $repository = new FakeFeature2Repository();
        $repository->vehicleState = [
            'id' => 9,
            'is_active' => true,
            'is_assigned' => false,
        ];

        $service = new VehicleRemovalService($repository);

        $result = $service->removeFromAllVehicles(9);

        $this->assertFalse($result['success']);
        $this->assertSame(
            'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd',
            $result['message']
        );
        $this->assertNull($result['redirect_to']);
        $this->assertTrue($repository->setInactiveCalled);
    }
}

class FakeFeature2Repository implements Feature2RepositoryInterface
{
    public bool $unassignResult = false;

    public ?array $vehicleState = null;

    public bool $setInactiveCalled = false;

    public function getInstructorsPaginated(int $page, int $perPage): array
    {
        return [];
    }

    public function getInstructorById(int $instructorId): ?array
    {
        return null;
    }

    public function getInstructorVehiclesPaginated(int $instructorId, int $page, int $perPage): array
    {
        return [];
    }

    public function unassignVehicleFromInstructor(int $instructorId, int $vehicleId): bool
    {
        return $this->unassignResult;
    }

    public function getAllVehiclesPaginated(int $page, int $perPage): array
    {
        return [];
    }

    public function getVehicleAssignmentState(int $vehicleId): ?array
    {
        return $this->vehicleState;
    }

    public function deleteAssignedVehicle(int $vehicleId): bool
    {
        return true;
    }

    public function setVehicleInactive(int $vehicleId): bool
    {
        $this->setInactiveCalled = true;
        return true;
    }
}
