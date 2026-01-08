<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $kode = $request->input('kode');

        if (!$kode) {
            // If no institution code, redirect to home page
            return redirect('/');
        }

        $data = $this->dashboardService->getDashboardData($kode);

        return view('dashboard', compact('data'));
    }
}
