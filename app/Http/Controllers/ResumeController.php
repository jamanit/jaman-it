<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index($name = null, $lang = null)
    {
        $lang = $lang ?? 'id';

        return view('resume.index', compact('name', 'lang'));
    }
}
