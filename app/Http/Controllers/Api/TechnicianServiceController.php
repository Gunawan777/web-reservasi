<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TechnicianServiceController extends Controller
{
    /**
     * Display a listing of the services offered by the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $technician = $request->user();
        return response()->json($technician->services);
    }

    /**
     * Attach one or more services to the authenticated technician, replacing existing ones.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $technician = $request->user();
        $technician->services()->sync($request->service_ids);

        return response()->json(['message' => 'Services updated successfully.'], Response::HTTP_OK);
    }

    /**
     * Detach a specific service from the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Service $service)
    {
        $technician = $request->user();

        if (!$technician->services->contains($service->id)) {
            return response()->json(['message' => 'Service not found for this technician.'], Response::HTTP_NOT_FOUND);
        }

        $technician->services()->detach($service->id);

        return response()->json(['message' => 'Service detached successfully.'], Response::HTTP_OK);
    }
}
