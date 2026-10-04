<?php

namespace App\Controllers;

class CitoyenController extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url('citoyen/requests'));
    }
}