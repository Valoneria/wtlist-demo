<?php

namespace App\Http\Controllers;

use App\Models\ImportHistory;
use App\Models\Vehicle;
use App\Models\VehicleCountry;
use App\Models\VehicleType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\WarThunderImportService;
class VehicleController extends Controller
{

    /**
     * Call the import service, and run the necessary imports for the vehicles.
     *
     * @return JsonResponse
     */
    public function import(Request $request) : JsonResponse
    {
        $import = new WarThunderImportService();
        $limit = (int)$request->input('limit') ?? 0;

        try {
            $importResult = $import->import($limit);
        } catch(\Exception $e) {
            ImportHistoryController::createRecord("failure");

            return response()->json([
                "The operation failed entirely - ". $e->getMessage(),
            ], 400);
        }

        ImportHistoryController::createRecord("success", $importResult);

        return response()->json(
            [
                "The import was ran successfully. The operation results: " . "\n\n".
                "Created: " . $importResult["created"] . "\n".
                "Updated: " . $importResult["updated"] . "\n".
                "Skipped: " . $importResult["skipped"] . "\n".
                "Failed: " . $importResult["failed"]
            ]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request): Factory|View
    {
        // Create the query builder
        /** @see https://laravel.com/docs/12.x/queries */
        $query = Vehicle::query();

        // Apply filters from query parameters
        if ($request->has('vehicle_type') && $request->get('vehicle_type')) {
            $query->where('vehicle_type_id', $request->input('vehicle_type'));
        }

        if ($request->has('country') && $request->get('country')) {
            $query->where('vehicle_country_id', $request->input('country'));
        }

        if ($request->has('min_rank') && $request->get('min_rank')) {
            $query->where('rank', '>=', $request->input('min_rank'));
        }

        if ($request->has('max_rank') && $request->get('max_rank')) {
            $query->where('rank', '<=', $request->input('max_rank'));
        }

        // Eager load relationships
        $vehicles = $query->with(['type', 'country'])
            ->orderBy('rank', 'asc')
            ->orderBy('arcade_battle_rating', 'asc')
            ->get();


        // Group vehicles by country
        $groupedVehicles = $vehicles->groupBy('vehicle_country_id');

        // Sort the grouped vehicles by country name
        $groupedVehicles = $groupedVehicles->sortBy(function ($vehicles, $countryId) {
            return VehicleCountry::find($countryId)->name;
        });

        // Load all countries and types for the filter form
        $countries = VehicleCountry::orderBy('name', 'asc')->get();
        $types = VehicleType::all();

        return view('vehicle.index', compact('groupedVehicles', 'countries', 'types'));
    }

    /**
     * @return View
     */
    public function importForm(): View
    {
        $importHistory = ImportHistory::all();

        return view('vehicle.import-form', compact('importHistory'));
    }
}
