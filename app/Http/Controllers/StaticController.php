<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function privacyPolicy() {
        return view('static.privacy-policy');
    }

    public function termOfServices() {
        return view('static.term-of-service');
    }
}
