<?php

namespace App\Http\Controllers;

use App\Models\ImportHistory;
use Illuminate\Http\Request;

class ImportHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param $status
     * @param $results
     * @return void
     */
    public static function createRecord(string $status,array $results = []) : void
    {
        ImportHistory::create([
            "status" => $status,
            "imported" => $results["created"] ?? 0,
            "updated" =>  $results["updated"] ?? 0,
            "failed" => $results["failed"] ?? 0,
            "skipped" => $results["skipped"] ?? 0,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
