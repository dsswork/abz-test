<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }



}
