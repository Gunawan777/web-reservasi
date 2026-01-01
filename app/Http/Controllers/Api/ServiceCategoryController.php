<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the service categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = ServiceCategory::all();
        return response()->json($categories, Response::HTTP_OK);
    }
}
