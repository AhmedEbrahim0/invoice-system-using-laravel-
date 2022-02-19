<?php

namespace App\Http\Controllers\sections;

use App\Models\sections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionsController extends Controller
{

    public function index()
    {
        $sections=sections::all();
        return view('sections.section')
        ->with("sections",$sections)
        ;
    }



    public function store(Request $request)
    {
        $request->validate([
            "section_name"=>"required",
            "description"=>"required"
        ],[
            "required"=>"هذا القل يجب ادخاله"
        ]);
        $exist=sections::where("section_name",'=',$request->section_name)->exists();

        if($exist){
            session()->flash('errors',"اسم القسم موجود بالفعل");
            return redirect("/section");

        }else{

            sections::create([
                "section_name"=>$request->section_name,
                "description"=>$request->description,
                "created_by"=>$request->created_by
            ]);
            session()->flash("success","تم الاضافه القسم بنجاح");
            return redirect("/section");
        }
}

    public function show(sections $sections)
    {
        //
    }



    public function update(Request $request)
    {
        $request->validate([
            "section_name"=>"required",
            "description"=>"required"
        ],[
            "required"=>"هذا القل يجب ادخاله"
        ]);
        session()->flash("success","تم حفظ التعديلات") ;
        sections::find($request->id)->update($request->all());
        return back();
    }

    public function destroy( $id)
    {
        $section=sections::find($id);
        $section->delete();
        session()->flash("success","تم الحذف بي نجاح");
        return redirect("/section");
    }
}
