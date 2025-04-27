<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function list()
    {
        return view('assets.index');
    }

    public function create()
    {
        return view('assets.create');
    }
}
