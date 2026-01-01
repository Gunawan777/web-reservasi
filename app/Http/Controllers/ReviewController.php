<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->customer_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        if ($booking->status !== 'completed' || $booking->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan ulasan untuk layanan yang sudah selesai dan dibayar.');
        }

        if ($booking->review) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk booking ini.');
        }

        Review::create([
            'booking_id' => $booking->id,
            'customer_id' => Auth::id(),
            'technician_id' => $booking->technician_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan!');
    }
}
