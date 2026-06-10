<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Página inicial (landing page).
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Página da loja.
     */
    public function loja()
    {
        return view('loja');
    }
}
