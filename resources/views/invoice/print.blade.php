@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعه الفاتوره</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row" id="print">


                    <div class="col-12">
                        <div class="row">

                            <div class="col-9">
                                <div> cash pay company </div>
                                <div> company@gmail.com</div>
                                <div> 20060</div>
                                <div> 0123567890</div>
                            </div>
                            <div class="col-3" style="color: #cdbfbf; font-size:35px; opacity:0.9;">
                                فاتوره التحصيل
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <h4 style="color: #cdbfbf; font-size:35px; opacity:0.9;">معلومات الفاتوره</h4>

                            <p class="col-10 " style="font-size: 18px  ; border-bottom:0.5px  solid; ">رقم الفاتوره</p>   <span  style="font-size: 18px;"  class="col-2" >{{ $invoice->invoice_number }}</span>
                            <p class="col-10 " style="font-size: 18px  ; border-bottom:0.5px  solid; ">تاريخ الاصدار </p>   <span style="font-size: 18px;"   class="col-2" >{{ $invoice->invoice_Date }}</span>
                            <p class="col-10 " style="font-size: 18px  ; border-bottom:0.5px  solid; ">تاريخ الاستحقاق  </p>   <span   style="font-size: 18px;" class="col-2" >{{ $invoice->Due_date }}</span>
                            <p class="col-10 " style="font-size: 18px  ; border-bottom:0.5px  solid; "> القسم</p>   <span   style="font-size: 18px;" class="col-2" >{{$invoice->section->section_name }}</span>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <h5>مبلغ التحصيل </h5>
                                <span>{{ $invoice->Amount_collection }}</span>
                            </div>
                            <div class="col-4">
                                <h5>مبلغ العموله </h5>
                                <span>{{ $invoice->Amount_Commission }}</span>
                            </div>
                            <div class="col-4">
                                <h5> الاجمالي  </h5>
                                <span>{{ $invoice->Amount_collection+ $invoice->Amount_Commission}}</span>
                            </div>


                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <div class="row">

                                    <div class="col-6">
                                        الاجمالي
                                    </div>
                                    <div class="col-6">
                                        {{ $invoice->Amount_collection+ $invoice->Amount_Commission}}
                                    </div>

                                    <div class="col-6">
                                    الضريبه
                                    </div>
                                    <div class="col-6">
                                        {{ $invoice->Value_VAT }}
                                    </div>

                                    <div class="col-6">
                                        الخصم
                                    </div>
                                    <div class="col-6">
                                        {{ $invoice->Discount }}
                                    </div>


                                    <div class="col-6">
                                        الاجمالي شامل الضريبه
                                    </div>
                                    <div class="col-6" style="color: red; font-size:20px;">
                                        {{ $invoice->Total }}
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="row">
                            <div class="col-9"></div>
                            <div class="col-3">
                                <button  class="btn btn-danger btn-print">طباعه </button>
                            </div>
                        </div>
                    </div>


				</div>

                <script>
                    var btnPrint=document.querySelector(".btn-print");
                    btnPrint.addEventListener("click",function(){
                        var print=document.getElementById("print");
                        var originalPage=document.body.innerHTML;
                        document.body.innerHTML=print.innerHTML;
                        window.print();
                        document.body.innerHTML=originalPage;
                        location.reload();
                    })
                </script>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
