<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Display the customer dashboard with summary counts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch counts for dashboard summary
        $totalTechnicians = User::where('role', 'teknisi')->count();
        $totalServices = Service::count();
        
        return view('pelanggan.dashboard', compact('totalTechnicians', 'totalServices'));
    }

    /**
     * Display a listing of bookings for the authenticated customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookings()
    {
        $bookings = Booking::where('customer_id', Auth::id())
                            ->with(['technician', 'service'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('pelanggan.bookings.index', compact('bookings'));
    }
}
