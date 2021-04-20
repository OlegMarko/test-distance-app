<?php

namespace App\Http\Controllers;

use App\Http\Resources\RouteGraphResource;
use App\Models\Route;

class RouteController extends Controller
{
    /**
     * Get routes graph.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGraph()
    {
        $routes = Route::with('distances', 'distances.route')->get()->toArray();
        $data = new RouteGraphResource($routes);

        return response()->json($data, 200);
    }
}
