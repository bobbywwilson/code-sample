<?php

namespace App\Http\Controllers;

class DisclosureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('tablet/disclosures/privacy');
    }
}
