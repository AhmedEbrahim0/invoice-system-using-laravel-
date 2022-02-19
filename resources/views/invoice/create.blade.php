@extends('layouts.master')
@section('css')
<style>
    input,select{
        padding: 5px;
        background-color: transparent;
        border: 1px solid blue;
        width: 100%;
    }
</style>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">قائمه الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                @if($errors->any())
                    @foreach ($errors->all() as $error )
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
				<div class="row">
                    <div class="col">
                        <form action="{{ route('invoice.store') }}"  enctype="multipart/form-data" method="post">
                            @csrf


                            <div class="row my-5">
                                <div class="col-4">
                                    <h3 class="fs-3 font-bold">رقم الفاتوره</h3>
                                    <input name="invoice_number" class="w-100"  type="number" placeholder=" -- رقم الفاتوره" >
                                </div>
                                <div class="col-4">
                                    <h3 class="fs-3 font-bold">تاريخ  الفاتوره</h3>
                                    <input name="invoice_date"  class="w-100" type="date" value="{{ date('Y-m-d') }}" >
                                </div>
                                <div class="col-4">
                                    <h3 class="fs-3 font-bold"> تاريخ الاستحقاق</h3>
                                    <input name="due_date" class="w-100"  type="date" >
                                </div>
                            </div>


                            <div class="row my-5">
                                <div class="col-4">
                                    <h3 class="fs-3 font-bold"> القسم </h3>
                                    <select class="w-100"  name="section_id" id="">
                                        <option selected disabled> القسم </option>
                                        @foreach ($sections as $section )
                                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <h3 class="fs-3 font-bold">  المنتج  </h3>
                                    <select name="product"  class="w-100" name="product" id="select">
                                        <option selected disabled> المنتج </option>

                                    </select>
                                </div>
                                <div class="col-4">
                                    <h3 class="fs-3 font-bold">  مبلغ التحصيل </h3>
                                    <input name="amount_collection"   class="w-100"  type="text" >
                                </div>
                            </div>



                            <div class="row my-5">
                                <div class="col-4">
                                    <h3 class="  fs-3 font-bold"> مبلغ العموله </h3>
                                    <input name="amount_commission" class="w-100 all-money"  type="text" >
                                </div>
                                <div class="col-4">
                                    <h3 class=" fs-3 font-bold">  الخصم  </h3>
                                    <input  name="descount" class="w-100  tax" type="number"  value="0" >
                                </div>
                                <div class="col-4">
                                    <h3 class="   fs-3 font-bold">   نسبه القيمه المضافه </h3>
                                    <select  name="rat" class="tax-100"  name="" id="" onchange="sum()">
                                        <option value="" disabled selected> القيمه المضافه</option>
                                        <option value="5">5%</option>
                                        <option value="10">10%</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row my-5">
                                <div class="col-6">
                                <h3>قيمه ضريبه القيمه المضافه</h3>
                                    <input class="tax-100-equal" type="text" readonly name="Rat_value">
                                </div>
                                <div class="col-6">
                                    <h3>الاجمالي  </h3>
                                    <input readonly  class="own-money" style="padding:20px;background:#ddd;" name="total">
                                </div>
                            </div>
                            <div class="col-12" >
                                <h3>
                                    الملاحظات
                                </h3>
                                <textarea style="width: 100%;" name="note" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-12 text-center" >
                                <label style="color: red ; border:solid 1px; padding:5px; font-size:18px;"  for="attach"> قم بوضع مرفق </label>
                                <input type="file" hidden name="attach" id="attach" accept=".png,.jpg,.pdf">
                            </div>
                            <div class="text-center col-12">
                                <button type="submit" class="btn btn-warning text-black">  اضافه </button>
                            </div>
                            <a href="/copy">  copy </a>
                            <script>

                            </script>

                            </form>
                    </div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
        <!-- ajax code -->
        <script>
            $(document).ready(function(){

                $("select[name='section_id']").on("change",function(){
                    var sectionID=$("select[name='section_id']").val();
                    $.ajax({
                        url:"{{ URL::to('ajax') }}/"+sectionID,
                        type:"GET",
                        dataType:"json",
                        success:function(data){
                            var text="";
                            for(const x of data){
                                text +=`<option value="${x.Product_name}">${x.Product_name}</option>`
                            }
                            $("select[name='product']").html(text);

                        }
                    })
                })



            })
        </script>
        <!-- end of ajax code -->

        <!-- sum code -->
        <script>
            function sum(){
                var allMony=document.querySelector(".all-money").value;
                var tax=document.querySelector(".tax").value;
                var tax100=document.querySelector(".tax-100").value;
                let taxEqual=document.querySelector(".tax-100-equal");
                let ownMoney=document.querySelector(".own-money");
                    const beforeTax=allMony-tax;
                    taxEqual.value=Math.abs(parseFloat(tax100*beforeTax).toFixed(2));
                    ownMoney.value= Math.abs(parseFloat( parseInt(taxEqual.value)+beforeTax).toFixed(2));


            }
        </script>
        <!-- end of sum code -->
        @endsection
        <script src="{{ asset('assets/jquery-3.6.0.min.js') }}"></script>
        @section('js')
        @endsection
    </body>
    </html>
