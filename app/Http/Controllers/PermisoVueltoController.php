<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermisoVueltoController extends Controller
{
    public function index()
    {
        return view('modules.permiso-vuelto.index');
    }
}
