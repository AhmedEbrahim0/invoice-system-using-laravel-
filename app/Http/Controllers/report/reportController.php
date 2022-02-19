<?php

namespace App\Http\Controllers\report;

use App\Models\invoices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class reportController extends Controller
{

    public function index()
    {
        return view("reports.reports");

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        if($request->search_by==2){

            $invoice=invoices::where("invoice_number","=",$request->search_number)->get();
            return view("reports.reports")
            ->with("invoices",$invoice);

        }else{
            $type=$request->date_type;


            if($type=="all"){
                $invoices=invoices::all();
                return view("reports.reports")
                ->with("invoices",$invoices)
                ;
            }else{
                $start =$request->start_at;
                $end =$request->end_at;
                $invoices=invoices::whereBetween("invoice_Date",[$start,$end])->where("Value_Status",$type)
                ->get();
                return view("reports.reports")
                ->with("invoices",$invoices);
            }

            
        }

    }
}

