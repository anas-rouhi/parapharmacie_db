<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // صفحة À Propos
    public function apropos()
    {
        return view('pages.apropos');
    }

    // صفحة Service SAV
    public function sav()
    {
        return view('pages.sav');
    }

    // صفحة Contact (عرض الصفحة)
    public function contact()
    {
        return view('pages.contact');
    }
}
