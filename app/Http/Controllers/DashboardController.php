<?php

namespace App\Http\Controllers;

use App\Models\Pendataan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
     public function index() : View
    {
        //get all products
        $pendataans = Pendataan::latest()->paginate(10);

        //render view with products
        return view('pendataans.index', compact('pendataans'));
    }
}
