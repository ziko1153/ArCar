<?php

namespace App\Http\Controllers;

class CustomerController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    public function index() {
        if (request()->ajax()) {
            $i = 0;
            $hire = Hire::orderBy('id', 'desc')->get();
            return $this->getDataTablesView($hire);
        }
        return view('pages.customer.index');
    }
}