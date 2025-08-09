<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    public function index()
    {
        return view('admin.sliders.index');
    }
}
