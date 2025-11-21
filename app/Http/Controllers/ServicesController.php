<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }
}