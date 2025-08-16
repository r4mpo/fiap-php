<?php

namespace Src\Controllers;

use Src\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', []);
    }
}
