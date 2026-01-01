<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // Import Booking model
use App\Models\ServiceCategory; // Import ServiceCategory for potential future use or form data

class TechnicianServiceWebController extends Controller
{
    /**
     * Display a listing of services for the authenticated technician.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teknisi.services.index');
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Optionally pass service categories if needed for server-side rendering
        $categories = ServiceCategory::all();
        return view('teknisi.services.create', compact('categories'));
    }
}
