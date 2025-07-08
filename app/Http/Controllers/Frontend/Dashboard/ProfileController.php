<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('frontend.dashboard.profile');
    }




}
