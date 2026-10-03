<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CitoyenController extends BaseController
{
    public function index()
    {
        return view('citizen/dashboard', ['title' => 'Mon espace']);
    }
}
