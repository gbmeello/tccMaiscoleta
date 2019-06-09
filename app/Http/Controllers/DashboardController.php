<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index() {

        // $obj

        return view('dashboard.index');
    }

}
