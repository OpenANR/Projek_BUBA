<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClockController extends Controller
{
    public function clock() {
        return view('admin.clock');
    }
}