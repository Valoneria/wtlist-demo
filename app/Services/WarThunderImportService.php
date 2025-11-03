<?php
namespace App\Services;


use App\Models\Vehicle;
use App\Models\VehicleCountry;
use App\Models\VehicleType;
use Exception;
use Illuminate\Support\Facades\Http;

class WarThunderImportService
{

    private int $limit = 50;

    /**
     *
     * @param int $limit
     * @return array
     *
     * @throws Exception
     */
    public function import(int $limit = 0) : array
    {

        // Overwrite default if a new value has been sent.
        $this->limit = $limit > 0 ? $limit : $this->limit;

        // Damned hacky, but we're running into a time limit here.
        set_time_limit(3000);

        try{
            $vehicles = [];
            $this->fetchAllVehicles($vehicles);
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }

        // Counters for the operation
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $failed = 0;

        if(!empty($vehicles)){
            // Pluck the vehicle types and countries, so we can save the correct ID values based on the slugs.
            $types = VehicleType::pluck('id', 'slug')->toArray();
            $countries = VehicleCountry::pluck('id', 'slug')->toArray();

            foreach($vehicles as $vehicle){
                // Construct the data
                $data = [
                    "name" => $vehicle["identifier"],
                    "rank" => $vehicle["era"],
                    "arcade_battle_rating" => $vehicle["arcade_br"],
                    "realistic_battle_rating" => $vehicle["realistic_br"],
                    "simulator_battle_rating" => $vehicle["simulator_br"],
                    "sl_price" => $vehicle["value"] ,
                    "ge_price" => $vehicle["ge_cost"],
                    "is_premium" => $vehicle["is_premium"] ?: 0,
                    "research_points_requirement" => $vehicle["req_exp"],
                    "vehicle_type_id" => $types[$vehicle["vehicle_type"]] ?? 0, // Directly use the ID
                    "vehicle_country_id" => $countries[$vehicle["country"]] ?? 0, // Directly use the ID
                ];

                $handledVehicle = $this->saveVehicle($data,$vehicle["identifier"]);
                if(!$handledVehicle){
                    $failed++;
                    continue;
                }

                if($handledVehicle->wasRecentlyCreated || $handledVehicle->wasChanged()){
                    $this->handleImage($vehicle);
                }

                $created += $handledVehicle->wasRecentlyCreated ? 1 : 0;
                $updated += $handledVehicle->wasChanged() ? 1 : 0;
                $skipped += !$handledVehicle->wasRecentlyCreated && !$handledVehicle->wasChanged() ? 1 : 0;
            }
        }

        return [
            "created" => $created,
            "updated" => $updated,
            "skipped" => $skipped,
            "failed" => $failed,
        ];
    }

    /**
     * @param array $data
     * @param string $vehicleId
     * @return Vehicle|false
     */
    private function saveVehicle(array $data, string $vehicleId) : Vehicle | false
    {
        try {
            $handledVehicle = Vehicle::updateOrCreate(
                ["api_identifier" => $vehicleId], // Use "identifier" as the unique identifier
                $data
            );
        } catch (\Exception $e) {
            // Log the error and vehicle data for debugging
            \Log::error("Failed to update or create vehicle: " . $e->getMessage(), [
                'vehicle' => $data,
            ]);
            return false;
        }
        return $handledVehicle;
    }

    /**
     * @param array $vehicle
     * @return void
     */
    private function handleImage(array $vehicle) : void
    {

        // Image handling - First get the image URL and body with help from laravel HTTP client methods.
        $imageUrl = $vehicle['images']['image']; // Replace with the actual key from your API

        // Construct the path
        $imagePath = "vehicles/{$vehicle["country"]}/{$vehicle['identifier']}.png";

        // Get the full image path
        $fullPath = public_path($imagePath);
        $directory = dirname($fullPath);

        // Create the directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // If the file already exists we just return, for now we aren't bothered with checking if there's any actual differences (should probably save the checksum or something to see if the file was updated?)
        if(file_exists($fullPath)){
            return;
        }

        // Save the image
        $imageContent = Http::get($imageUrl)->body();
        file_put_contents($fullPath, $imageContent);

        // Construct the $data array for saving the vehicle with the new data.
        $data = [
            "image_path" => $imagePath,
        ];

        $this->saveVehicle($data,$vehicle["identifier"]);
    }

    /**
     * Fetch the vehicles from the API.
     *
     * @param array $allVehicles
     * @param int $page
     * @return array
     * @throws Exception
     */
    private function fetchAllVehicles (array &$allVehicles = [], int $page = 0) : array
    {
        $response = Http::get(
            $this->buildUrl($page)
        );

        if (!$response->successful()) {
            throw new Exception("Failed to fetch data from API.");
        }
        // Collect the newest data, and merge it with the existing array of data.
        $data = $response->json();
        $allVehicles = array_merge($allVehicles, $data);

        // For no particular reason besides not wanting to spam the opensource API, we set a limit of 12 pages.
        if($page > 10){
            return $allVehicles;
        }
        // if the result set count matches the limit, we run again, due to a lack of indicators in the API on whether we've reached the max or not.
        if (count($data) === $this->limit) {
            // Recursively fetch the next page
            return $this->fetchAllVehicles( $allVehicles,$page + 1);
        }

        return $allVehicles;
    }

    /**
     * @param int $page
     * @param array $additionalQuery - Not currently used, but can be used to further indicate inclusion of eventvehicles, only premiums, etc.
     * @return string
     */
    private function buildUrl(int $page = 0,  $additionalQuery = []) : string
    {
        /**
         * @see https://wtvehiclesapi.sgambe.serv00.net/docs/#/default/get_vehicles for the source
         */
        $baseUrl = "https://www.wtvehiclesapi.sgambe.serv00.net/api/vehicles";
        $baseImportQuery = [
            "limit" => $this->limit,
            "type" => [
                "tank",
                "light_tank",
                "medium_tank",
                "heavy_tank",
                "tank_destroyer",
                "spaa",
            ],
            "page" => $page,
        ];
        // Merge the additional queries into the baseimport query, this is useful for when we want to query both premiums, event vehicles, etc.
        $importQuery = array_merge($baseImportQuery,$additionalQuery);

        return $baseUrl . "?" . http_build_query($importQuery);
    }
}
