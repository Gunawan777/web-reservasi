<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerTechnicianController extends Controller
{
    /**
     * Display a listing of technicians with their owned services.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $technicians = User::where('role', 'teknisi')
                            ->with('ownedServices.category') // Eager load category for each owned service
                            ->get();

        return response()->json($technicians, Response::HTTP_OK);
    }
}
