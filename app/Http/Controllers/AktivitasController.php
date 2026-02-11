<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AktivitasController extends Controller
{
    public function show($id)
    {
        return Inertia::render('aktivitasd', [
            'id' => $id,
        ]);
    }
}
