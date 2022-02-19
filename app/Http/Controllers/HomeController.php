<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\invoices;
use Illuminate\Http\Request;

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
        $invoices=invoices::all();
        $total =0;
        foreach($invoices as $invoice){
            $total +=$invoice->Total;
        }

        $total_paid=0;
        $invoices_paid=invoices::where("Value_Status","=",1)->get();
        foreach($invoices_paid as $invoice){
            $total_paid +=$invoice->Total;
        }

        $total_non_paid=0;
        $invoices_non_paid=invoices::where("Value_Status","=",0)->get();
        foreach($invoices_non_paid as $invoice){
            $total_non_paid +=$invoice->Total;
        }


        return view('home')
        ->with("total",$total)
        ->with("total_paid",$total_paid)
        ->with("total_non_paid",$total_non_paid)
        ;
    }
}
