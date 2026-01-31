<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DTAController extends Controller
{
    //
    public function indexxxx (){
        return Inertia::render('daftar-ta');
    }
}
