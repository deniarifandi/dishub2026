<?php

namespace App\Controllers;

use App\Libraries\DataTable;


class Home extends BaseController
{
    public function index(): string
    {
        return view('dashboard');
    }

    public function commandcenter(): string
    {
        return view('commandcenter');
    }
}
