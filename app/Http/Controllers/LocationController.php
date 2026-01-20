<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)
                      ->orderBy('name')
                      ->get(['id', 'name']);

        return response()->json($cities);
    }
}
