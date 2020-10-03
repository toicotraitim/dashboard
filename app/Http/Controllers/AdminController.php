<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function __invoke() {
        return redirect()->route("admin.dashboard");
    }
    public function dashboard() {
        return view("dashboard");
    }
}
