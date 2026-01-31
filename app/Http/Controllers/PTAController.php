<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PTAController extends Controller
{
    //
    public function indexxx (){
        return Inertia::render('pengaturan-ta');
    }
}
