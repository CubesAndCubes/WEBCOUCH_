<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview(Request $request) {
        $user = auth()->user();

        return view('app.dashboard', [
            'user' => $user,
        ]);
    }
}
