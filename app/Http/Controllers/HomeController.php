<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        \Meta::set('title', 'Administração de Eventos');

        return View('home.index');
    }
}
