<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ModulController extends Controller
{
    //
    public function indexx (){
        return Inertia::render('Modul');
    }
}
