<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HoTroController extends Controller
{
    public function huongDan()
    {
        return view('hotro.huongdan');
    }

    public function faq()
    {
        return view('hotro.faq');
    }
}