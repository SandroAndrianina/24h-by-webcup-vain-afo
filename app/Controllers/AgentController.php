<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AgentController extends BaseController
{
    public function index()
    {
        return "Dashboard Agent";
    }
}
