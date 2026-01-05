<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;

class AdminController extends Controller
{
    public function index()
    {
        // Cek apakah sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek role user
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Delegate ke DashboardController
        $dashboardController = new DashboardController();
        return $dashboardController->index();
    }
}
