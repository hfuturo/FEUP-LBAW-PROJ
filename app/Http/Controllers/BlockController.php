<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function blockPage()
    {
        return view('pages.block');
    }
}
