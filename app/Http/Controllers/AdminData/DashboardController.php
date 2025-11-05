<?php

namespace App\Http\Controllers\AdminData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin-data.dashboard');
    }
}