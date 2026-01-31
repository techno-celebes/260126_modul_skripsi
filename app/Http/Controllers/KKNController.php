<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class KKNController extends Controller
{
    //
    public function indexx (){
        return Inertia::render('kkn');
    }
}
