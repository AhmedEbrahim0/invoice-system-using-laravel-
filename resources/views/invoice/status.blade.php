@extends('layouts.master')
@section('css')
@endsection
<style>
    input,select{
        padding: 5px;
        background-color: transparent;
        border: 1px solid blue;
        width: 100%;
    }
</style>
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل</span>
						</div>
					</div>

@section('content')

                    @if($errors->any())
                        @foreach ($errors->all() as $error )
                            <div class="alert alert-danger">  {{ $error }} </div>
                        @endforeach
                    @endif

                    @if(session('success'))
                        <div class="alert alert-primary">
                            {{ session('success') }}
                        </div>
                    @endif
				<!-- row -->
            <div class="row">
                <div class="col">
                    <div class="row">

                        <input  readonly type="hidden" name="invoice_number" value="{{ $invoice->invoice_number }}">

                        <div class="col-12">
                            <div class="row">


                                <div class="col-6">
                                    <h3>
                                        تاريخ الفاتوره
                                    </h3>
                                <input  readonly type="date" name="invoice_Date" value="{{ $invoice->invoice_Date }}" id="">
                            </div>


                            <div class="col-6">
                                <h3>
                                    تاريخ الاستحقاق
                                </h3>
                                <input  readonly type="date" name="Due_date" value="{{ $invoice->Due_date }}" id="">
                            </div>

                        </div>
                        </div>

                        <div class="col-12">
                            <div class="row">

                                <div class="col-4">
                                    <h3>القسم</h1>
                                    <select name="section_id" >
                                        @foreach ($sections as $section )
                                    <option
                                        @if($invoice->section->id==$section->id)
                                            selected
                                        @endif
                                    value="{{ $section->id }}">{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <h3>المنتج</h3>
                                <select name="product" >
                                    <option value="{{ $invoice->product }}" >{{ $invoice->product }} </option>
                                </select>
                            </div>
                            <div class="col-4">
                                <h3> التحصيل </h3>
                                <input  readonly type="Amount_collection" class="all-money"  value="{{ $invoice->Amount_collection }}">
                            </div>




                        </div>
                    </div>

                    <div class="col-12">
                    <div class="row">
                            <div class="col-4">
                                <h3>مبلغ العموله</h3>
                                <input  readonly type="number" name="Amount_Commission" value="{{ $invoice->Amount_Commission }}">
                            </div>
                            <div class="col-4">
                                <h3> الخصم </h3>
                                <input  readonly type="number" name="Discount" class="tax" value="{{ $invoice->Discount }}">
                            </div>
                            <div class="col-4">
                                <h3>  قيمه الضريبخ المضافه  </h3>
                                <select name="Rate_VAT" class="tax-100" id="" onchange="sum()">
                                    @if($invoice->Rate_VAT == 5)
                                    <option  selected value="{{ $invoice->Rate_VAT }}">{{ $invoice->Rate_VAT }}%</option>
                                    <option value="10">10%</option>
                                    @else
                                    <option  selected value="{{ $invoice->Rate_VAT }}">{{ $invoice->Rate_VAT }}%</option>
                                    <option value="5">5%</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <h3>قيمه الضريبه المضافه </h3>
                                <input  readonly class="tax-100-equal" type="text" name="rate_value" >
                            </div>
                            <div class="col-6">
                                <h3>  Total </h3>
                                <input  readonly class="own-money"  type="text" name="Total" value="{{ $invoice->Total }}" >
                            </div>
                        </div>
                    </div>

                    <div class="col-12">

                            <h3>الملاحظات</h3>
                            <input name="note" value="{{ $invoice->note }}" readonly />
                    </div>
                    <div class="col-12">
                        <div class="row text-center">
                            <div class="col-12">
                                @foreach ($attach as $x )
                                <img style="width: 100px; height:100px; border-radius:5px;" src="{{   asset('attach/'.$invoice->invoice_number).'/'.$x->file_name}}" alt="">
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <div class="col-12">

                        <form action="{{ route('invoice.status.update',$invoice->invoice_number) }}" method="get">
                            <div class="row">

                                <div class="col-3">
                                    <h3>حاله الدفع </h3>
                                    <select name="Status" id="">
                                        <option disabled selected>  -- حاله -- </option>
                                        <option value="0">غير مدفوعه</option>
                                        <option value="1"> مدفوعه</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <h3>يوم الدفع</h3>
                                    <input type="date" name="Payment_Date" value="{{ date('Y-m-d') }}" id="">
                                </div>
                                <div class="col-12 text-center my-2">
                                    <button class="btn btn-primary" type="submit "> تغير الحاله فاتوره   </button>
                                </div>
                            </div>
                        </form>
                    </div>



                </div>
 


                    </div>

                </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
        <script>
            function sum(){
                var allMony=document.querySelector(".all-money").value;
                var tax=document.querySelector(".tax").value;
                var tax100=document.querySelector(".tax-100").value;
                let taxEqual=document.querySelector(".tax-100-equal");
                let ownMoney=document.querySelector(".own-money");
                    const beforeTax=allMony-tax;
                    taxEqual.value=parseFloat(tax100*beforeTax).toFixed(2);
                    ownMoney.value= parseFloat( parseInt(taxEqual.value)+beforeTax).toFixed(2);


            }
        </script>
        <script src="{{ asset('assets/jquery-3.6.0.min.js') }}"></script>
        <script>
            $(document).ready(function(){

                $("select[name='section_id']").on("change",function(){
                    var id=$("select[name='section_id']").val();
                    $.ajax({
                        url:"{{ URL::to('ajax') }}/"+id,
                        dataType:"JSON",
                    type:"GET",
                    success:function(data){
                        text =" ";
                        for( const x of data){
                            text += `<option value="${x.Product_name}">${x.Product_name}</option> `
                        }
            $("select[name='product']").html(text);
                    }
                })
            })
        })
        </script>
		<!-- main-content closed -->
@endsection
@section('js')

@endsection
