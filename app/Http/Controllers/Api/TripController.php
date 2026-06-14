<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Http\Resources\TripResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $trips = Trip::with(['vehicle', 'driver'])->get();

        return TripResource::collection($trips);
    }
}
