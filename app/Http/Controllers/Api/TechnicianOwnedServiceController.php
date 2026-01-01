<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory; // Added for validation check
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Added for HTTP status codes

class TechnicianOwnedServiceController extends Controller
{
    /**
     * Display a listing of the services owned by the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $technician = $request->user();
        return response()->json($technician->ownedServices()->with('category')->get(), Response::HTTP_OK);
    }

    /**
     * Store a newly created service for the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $technician = $request->user();

        $service = $technician->ownedServices()->create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json($service, Response::HTTP_CREATED);
    }

    /**
     * Display the specified service owned by the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $owned_service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Service $owned_service)
    {
        if ($request->user()->id != $owned_service->user_id) {
            return response()->json(['message' => 'Unauthorized to view this service.'], Response::HTTP_FORBIDDEN);
        }
        return response()->json($owned_service, Response::HTTP_OK);
    }

    /**
     * Update the specified service owned by the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $owned_service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Service $owned_service)
    {
        if ($request->user()->id != $owned_service->user_id) {
            return response()->json(['message' => 'Unauthorized to update this service.'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'category_id' => 'sometimes|required|exists:service_categories,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $owned_service->update($request->all());

        return response()->json($owned_service, Response::HTTP_OK);
    }

    /**
     * Remove the specified service owned by the authenticated technician.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $owned_service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Service $owned_service)
    {
        if ($request->user()->id != $owned_service->user_id) {
            return response()->json(['message' => 'Unauthorized to delete this service.'], Response::HTTP_FORBIDDEN);
        }

        $owned_service->delete();

        return response()->json(['message' => 'Service deleted successfully.'], Response::HTTP_NO_CONTENT);
    }
}