<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Actividad_economica;
use BolsaTrabajo\Tipo_persona;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function  index()
    {
        return view('auth.home.index', ['tipo_persona' => Tipo_persona::all()]);
    }
}
