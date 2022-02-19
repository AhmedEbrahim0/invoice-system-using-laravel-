<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\invoice;
use App\Models\invoices;

use App\Models\products;
use App\Models\sections;
use Maatwebsite\Excel\Excel;
use App\Exports\InvoiceExport;
use App\Models\invoiceDetails;
use App\Models\invoiceAttachment;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\addNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;


class InvoicesController extends Controller
{

    public function index()
    {

        $invoices=invoices::all();
        return view('invoice.invoice')
        ->with("invoices",$invoices)
        ;
    }

    public function create()
    {
        $sections=sections::all();
        return view('invoice.create')
        ->with("sections",$sections)
        ;
    }

    public function store(Request $request)
    {

        $request->validate([
            "attach"=>"mimes:png,jpg",
        ],
        [
            "mimes"=>"هذا الملف غير مدعوم"
        ]);

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_date,
            'Due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'Amount_collection' => $request->amount_collection,
            'Amount_Commission' => $request->amount_commission,
            'Discount' => $request->descount,
            'Value_VAT' => $request->Rat_value,
            'Rate_VAT' => $request->rat,
            'Total' => $request->total,
            'Status' => 'غير مدفوعه',
            'Value_Status' => 0,
            'note' => $request->note,
        ]);
        $invoice_id=invoices::latest()->first()->id;
        invoiceDetails::create([
            "id_Invoice"=>$invoice_id,
            "invoice_number"=>$request->invoice_number,
            "product"=>$request->product,
            "Section"=>$request->section_id,
            "Status"=>"غير مدفوعه",
            "Value_Status"=>0,
            "note"=>$request->note,
            "user"=>Auth::user()->name,

        ]);
        if($request->has("attach")){
            $request->validate(["attach"=>"mimes:png,jpg,pdf"],["mimes"=>" هذا الملف غير مدعوم"]);
            $invoice_number=$request->invoice_number;
            Storage::makeDirectory("attach/".$invoice_number);
            $name=$request->attach;
            $extension=$name->extension();
            $attachName=time().".".$extension;
            $request->attach->move(public_path('attach/'.$invoice_number),$attachName);
            invoiceAttachment::create([
                "file_name"=>$attachName,
                "invoice_number"=>$request->invoice_number,
                "Created_by"=>Auth::user()->name,
                "invoice_id"=>$invoice_id,
            ]);


        }


        session()->flash("success","تم اضافه فاتوره بنجاح");
        return redirect('/invoice');
    }

    public function show($id)
    {
        $attachment=invoiceAttachment::where("invoice_id","=",$id)->get();
        $details=invoiceDetails::where("id_Invoice","=",$id)->get();
        $invoices=invoices::where("id","=",$id)->get();
        return view("invoice.show")
        ->with("attachments",$attachment)
        ->with("details",$details)
        ->with("invoices",$invoices)
        ;

    }

    public function edit($id)
    {
        $invoice=invoices::find($id);
        $sections=sections::all();
        $image=invoiceAttachment::where("invoice_number",$invoice->invoice_number)->get();
        return view('invoice.edit')
        ->with("sections",$sections)
        ->with("invoice",$invoice)
        ->with("attach",$image)
        ;
    }

    public function update(Request $request,$id)
    {

        invoices::find($id)->update([
            "invoice_number"=>$request->invoice_number,
            "invoice_Date"=>$request->invoice_Date,
            "Due_date"=>$request->Due_date,
            "product"=>$request->product,
            "section_id"=>$request->section_id,
            "Amount_collection"=>$request->Amount_collection,
            "Amount_Commission"=>$request->Amount_Commission,
            "Discount"=>$request->Discount,
            "Value_VAT"=>$request->Rate_VAT,
            "Rate_VAT"=>$request->Rate_VAT,
            "Total"=>$request->Total,
            "Status"=>"غير مدفوعه",
            "Value_Status"=>0,
            "note"=>$request->note
        ]);
        invoiceDetails::where("invoice_number","=",$request->invoice_number)->update([
            "product"=>$request->product,
            "Section"=>$request->section_id,
            "Status"=>"غير مدفوعه",
            "Value_Status"=>2,
            "note"=>$request->note,
            "user"=>Auth::user()->name,
        ]);
        $attachs=invoiceAttachment::where("invoice_number","=",$request->invoice_number)->first()->get();
        foreach($attachs as $y){
            $attach=$y;
        }
        if($request->has('attach')){
            File::delete("attach/".$request->invoice_number."/".$attach->file_name);
            $name=$request->attach;
            $extension=$name->extension();
            $attachName=time().".". $extension;
            $name->move(public_path('attach/'.$request->invoice_number),$attachName);
            $attach->update([
                "file_name"=>$attachName,
                "invoice_number"=>$request->invoice_number,
                "Created_by"=>Auth::user()->name,
                ]);
            } else{
            $attach->update([
                "invoice_number"=>$request->invoice_number,
                "Created_by"=>Auth::user()->name,
                ]);
        }
        session()->flash("success","تم حفظ التعديلات بنجاح");
        return back();
    }

    public function destroy($id)
    {
        invoices::destroy($id);
        session()->flash("success","تم الحذف الفاتوره بنجاح  ");

        return redirect("/invoice");
    }


    public function download($folder_name,$file_name)

    {
        return response()->download(public_path('attach/'.$folder_name."/".$file_name));
    }


    public function showAttach($folder_name,$file_name)
    {

        return response()->file(public_path('attach/'.$folder_name."/".$file_name));
    }

    public function deleteAttach($folder_name,$file_name,$id)
    {
        invoiceAttachment::destroy($id);
        File::delete('attach/'.$folder_name."/". $file_name);

        return back();

    }

    public function addAttach(Request $request)
    {
        $invoice_id=$request->invoice_id;
        $invoice_number=$request->invoice_number;

        $name=$request->attach;
        $extension=$name->extension();
        $file_name=time()."." . $extension;
        $name->move(public_path('attach/'.$invoice_number),$file_name);
        invoiceAttachment::create([
            "file_name"=>$file_name,
            "invoice_number"=>$invoice_number,
            "invoice_id"=>$invoice_id,
            "Created_by"=>Auth::user()->name,
        ]);
        return back();
    }

    public function copy(){
        File::copy(public_path("attach/4145/1644359061.jpg"),public_path("attach/100/copy1.jpg"));
    }
    public function status($id){
        $invoice=invoices::find($id);
        $sections=sections::all();
        $image=invoiceAttachment::where("invoice_number",$invoice->invoice_number)->get();
        return view('invoice.status')
        ->with("sections",$sections)
        ->with("invoice",$invoice)
        ->with("attach",$image)
        ;
    }
    public function updateStatus($id,  Request $request){

        $details=invoiceDetails::where("invoice_number","=",$id)->first();
        $invoice=invoices::where("invoice_number","=",$id)->first();

        if($request->Status==0){
            $details->update([
                "Status"=>"غير مدفوعه",
                "Value_Status"=>0,
                "Payment_Date"=>$request->Payment_Date
            ]);
            $invoice->update([
                "Status"=>"غير مدفوعه",
                "Value_Status"=>0,
                "Payment_Date"=>$request->Payment_Date
            ]);
        }else{
            $details->update([
                "Status"=>" مدفوعه",
                "Value_Status"=>1,
                "Payment_Date"=>$request->Payment_Date
            ]);
            $invoice->update([
                "Status"=>" مدفوعه",
                "Value_Status"=>1,
                "Payment_Date"=>$request->Payment_Date
            ]);

        }
        session()->flash("success","تم تغير حاله الفاتوره");
        return back();


    }

    public function invoicePaid(){
        $invoices_paid=invoices::where("Value_Status","=",1)->get();
        return view('invoice.invoice_paid')
        ->with("invoices",$invoices_paid)
        ;
    }

    public function invoiceNonPaid(){
        $invoices_paid=invoices::where("Value_Status","=",0)->get();
        return view('invoice.invoice_non_paid')
        ->with("invoices",$invoices_paid)
        ;
    }

    public function archive(){
        $archive=invoices::onlyTrashed()->get();
        return view('invoice.archive')
        ->with("archives",$archive)
        ;
    }
    public function archive_update($id){
        invoices::withTrashed()->where("id",$id)->restore();
        session()->flash("success","تم اعاده الفاتوره من الارشيف");
        return redirect('invoice');
    }

    public function print($id){
        $invoices=invoices::find($id);
        return view("invoice.print")
        ->with("invoice",$invoices)
        ;
    }

    public function export()
    {
        $excel = App::make('excel');
        return $excel->download(new InvoiceExport, 'invoices.xlsx');
    }


}
