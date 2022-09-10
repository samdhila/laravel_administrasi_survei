<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['users'] = User::role('user')->get(["id", "name"]);
        if (Auth::user()->hasRole('admin')) {
            return view('admin-page', $data);
        } else {
            return view('surveyor-page', $data);
        }
        //return view('home');
    }
}
