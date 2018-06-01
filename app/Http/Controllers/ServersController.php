<?php

namespace App\Http\Controllers;

use App\Servers;

class ServersController extends Controller
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
     * Show the servers list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get all servers
        $servers = Servers::all();

        return view('servers')->with('servers', $servers);
    }
}
