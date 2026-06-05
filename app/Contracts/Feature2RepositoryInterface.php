<?php

namespace App\Contracts;

interface Feature2RepositoryInterface
{
    public function getInstructorsPaginated(int $page, int $perPage): array;

    public function getInstructorById(int $instructorId): ?array;

    public function getInstructorVehiclesPaginated(int $instructorId, int $page, int $perPage): array;

    public function unassignVehicleFromInstructor(int $instructorId, int $vehicleId): bool;

    public function getAllVehiclesPaginated(int $page, int $perPage): array;

    public function getVehicleAssignmentState(int $vehicleId): ?array;

    public function deleteAssignedVehicle(int $vehicleId): bool;

    public function setVehicleInactive(int $vehicleId): bool;
}
