<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class TeknisiListController extends Controller
{
    public function index()
    {
        $teknisi = User::where('role', 'teknisi')->get();
        return view('teknisi.index', compact('teknisi'));
    }

    public function show(User $id)
    {
        $services = Service::all();
        $teknisi = $id; // Assign the bound User model to $teknisi for the view
        return view('teknisi.show', compact('teknisi', 'services'));
    }
}
