<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard', compact('user'));
    }
}
