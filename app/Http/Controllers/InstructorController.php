<?php

namespace App\Http\Controllers;

use App\Contracts\Feature2RepositoryInterface;
use App\Services\VehicleRemovalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function __construct(
        private readonly Feature2RepositoryInterface $repository,
        private readonly VehicleRemovalService $removalService
    ) {
    }

    public function index(Request $request)
    {
        $page = max(1, (int) $request->query('page', 1));
        $instructors = $this->repository->getInstructorsPaginated($page, 4);

        return view('instructors.index', [
            'instructors' => $instructors,
        ]);
    }

    public function vehicles(Request $request, int $instructor)
    {
        $instructorData = $this->repository->getInstructorById($instructor);

        abort_if(! $instructorData, 404);

        $page = max(1, (int) $request->query('page', 1));
        $vehicles = $this->repository->getInstructorVehiclesPaginated($instructor, $page, 4);

        return view('instructors.vehicles', [
            'instructor' => $instructorData,
            'vehicles' => $vehicles,
        ]);
    }

    public function removeVehicle(int $instructor, int $vehicle): RedirectResponse
    {
        $result = $this->removalService->removeFromInstructor($instructor, $vehicle);

        return redirect()
            ->route('instructors.vehicles', ['instructor' => $instructor])
            ->with('flash', [
                'type' => $result['success'] ? 'success' : 'error',
                'message' => $result['message'],
                'redirect_to' => $result['redirect_to'],
            ]);
    }
}
