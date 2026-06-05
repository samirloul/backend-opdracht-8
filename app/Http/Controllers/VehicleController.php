<?php

namespace App\Http\Controllers;

use App\Contracts\Feature2RepositoryInterface;
use App\Services\VehicleRemovalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(
        private readonly Feature2RepositoryInterface $repository,
        private readonly VehicleRemovalService $removalService
    ) {
    }

    public function index(Request $request)
    {
        $page = max(1, (int) $request->query('page', 1));
        $vehicles = $this->repository->getAllVehiclesPaginated($page, 4);

        return view('vehicles.index', [
            'vehicles' => $vehicles,
        ]);
    }

    public function remove(int $vehicle): RedirectResponse
    {
        $result = $this->removalService->removeFromAllVehicles($vehicle);

        return redirect()
            ->route('vehicles.index')
            ->with('flash', [
                'type' => $result['success'] ? 'success' : 'warning',
                'message' => $result['message'],
                'redirect_to' => $result['redirect_to'],
            ]);
    }
}
