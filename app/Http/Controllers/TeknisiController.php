<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    /**
     * Display the main technician dashboard with navigation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teknisi.dashboard');
    }

    /**
     * Display a listing of active bookings for the authenticated technician.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeBookings()
    {
        $activeBookings = Booking::where('technician_id', Auth::id())
                                ->whereIn('status', ['pending', 'accepted', 'in_progress'])
                                ->with(['customer', 'service'])
                                ->orderBy('created_at', 'desc')
                                ->get();
                                
        return view('teknisi.bookings.active', compact('activeBookings'));
    }

    /**
     * Display a listing of historical bookings for the authenticated technician.
     *
     * @return \Illuminate\Http\Response
     */
    public function historyBookings()
    {
        $historyBookings = Booking::where('technician_id', Auth::id())
                                ->whereIn('status', ['completed', 'cancelled', 'rejected'])
                                ->with(['customer', 'service', 'review'])
                                ->orderBy('created_at', 'desc')
                                ->get();
                                
        return view('teknisi.bookings.history', compact('historyBookings'));
    }
}
