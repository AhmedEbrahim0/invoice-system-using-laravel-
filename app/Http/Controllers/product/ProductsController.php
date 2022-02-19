<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\product;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{


    public function index()
    {
        $sections=sections::all();
        $products=products::all();
        return view('product.products')
        ->with("sections",$sections)
        ->with("products",$products)
        ;
    }

    public function store(Request $request)
    {
        $request->validate([
            "product_name"=>"required",
            "section_id"=>"required",
            "description"=>"required"
        ],[
            "required"=>"هذا الحقل مطلوب"
        ]);
        $products=products::create([
            "product_name"=>$request->product_name,
            "description"=>$request->description,
            "section_id"=>$request->section_id
        ]);
        session()->flash("success","تم اضافه المنتج بنجاح");
        return redirect("/product");
    }

    public function update(Request $request)
    {
        $request->validate([
            "product_name"=>"required",
            "section"=>"required"
        ],[
            "required"=>"هذا الحقل مطلوب"
        ]);
        products::where("id","=",$request->product_id)->update([
            "product_name"=>$request->product_name,
            "section_id"=>$request->section,
            "description"=>$request->description
        ]);
        session()->flash("success"," تم التعديل المنتج بنجاح");
        return redirect("/product");
    }

    public function destroy( $id)
    {
        products::destroy($id);
        session()->flash("success","تم الحذف بي نجاح");
        return redirect("/product");
    }

    public function product($id){
        $products=DB::table('products')->where("section_id",$id)->get();
        return json_encode($products);
    }

}
