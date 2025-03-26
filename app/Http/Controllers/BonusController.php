<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function show()
    {
        return view('bonus');
    }
}