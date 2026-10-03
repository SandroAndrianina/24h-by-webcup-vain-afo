<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CitoyenController extends BaseController
{
    public function index()
    {
        return "Accueil Citoyen";
    }
}
