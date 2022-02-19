@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقاري الفواتير</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">



                    <div class="col-12">
                        <form action="{{ route('search') }}" method="post">
                            @csrf
                            <div>
                                <p>
                                    <input checked class="in-date" type="radio" name="search_by"  value="1" id="1">
                                    <label  style="font-size: 13px ; font-weight:bold;" for="1"> بحث بنوع الفاتوره </label>
                                </p>
                                <p>
                                    <input type="radio" name="search_by" value="2"  class="in-number"  id="2">
                                    <label style="font-size: 13px ; font-weight:bold;"  for="2"> بحث  رقم الفاتوره  </label>
                                </p>
                            </div>

                            <div class="col-12" id="number">
                                <label for="5">ادخل رقم الفاتوره</label>
                                <input type="number" name="search_number"  id="5">
                            </div>
                            <div class="col-12" id="date" >
                                <div class="row">
                                    <div class="col-4">
                                        <h3>تحديد نوع الفاتوره</h3>
                                        <div>
                                            <select  name="date_type" id="">
                                                <option value="" selected disabled>  تحديد نوع الفاتوره</option>
                                                <option value="all">الكل</option>
                                                <option value="1">المدفوعه</option>
                                                <option value="0">الغير المدفوعه</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <h3>من تاريخ</h3>
                                        <div>
                                            <input  type="date"  name="start_at"  >
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <h3>الي تاريخ</h3>
                                        <div>
                                            <input type="date"  name="end_at"  >
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <div>
                                    <button class="btn btn-primary ">بحث</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    @if(isset($invoices))

                    @if(count($invoices)>0 )

					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">الفواتير </h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
                            <div>
                                <a href="{{ route('invoice.create') }}" class="btn btn-primary">  اضافه فاتوره </a>
                                <a href="{{ route('export') }}" class="btn btn-primary">   تحويل الي ملف اكسيل </a>
                            </div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
                                                <th># </th>
												<th class="wd-15p border-bottom-0">رقم الفاتوره</th>
												<th class="wd-20p border-bottom-0">تاريخ الفاتوره</th>
                                                <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
												<th class="wd-10p border-bottom-0">المنتج</th>
												<th class="wd-10p border-bottom-0">القسم</th>
												<th class="wd-10p border-bottom-0">الخصم</th>
												<th class="wd-25p border-bottom-0">نسبه الضريبه</th>

												<th class="wd-25p border-bottom-0">   قيمه الضريبه </th>
                                                <th class="wd-25p border-bottom-0">   الاجمالي   </th>

                                                <th class="wd-25p border-bottom-0">   الحاله    </th>
												<th class="wd-25p border-bottom-0"> العمليات   </th>
											</tr>
										</thead>
										<tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($invoices as $invoice )
											<tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{$invoice->invoice_number}}</td>
                                                <td>{{$invoice->invoice_Date}}</td>
                                                <td>{{$invoice->Due_date}}</td>
                                                <td>{{$invoice->product}}</td>
                                                <td><a href="{{ route('invoice.show', $invoice->id ) }}">{{  $invoice->section->section_name }}</a></td>
                                                <td>{{$invoice->Discount}}</td>
                                                <td>{{$invoice->Value_VAT}}</td>
                                                <td>{{$invoice->Value_VAT}}</td>

                                                <td>{{$invoice->Total}}</td>
                                                <td
                                                >
                                                <div
                                                @if ($invoice->Value_Status==0)
                                                style="color:red;  font-size:20px; "
                                                @else
                                                style="color:blue; font-size:20px;  "
                                                @endif
                                                >
                                                    {{$invoice->Status}}</td>
                                                </div>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-info"
                                                        data-toggle="dropdown" type="button"> العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                        <div class="dropdown-menu tx-13">

                                                            <form class="dropdown-item" action="{{ route('invoice.edit',$invoice->id) }} " method="get">
                                                                <button class="w-100 btn  font-bold" type="submit">  تعديل  </button>
                                                            </form>

                                                            <form class="dropdown-item"   action="{{ route('invoice.destroy',$invoice->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="w-100 btn font-bold" type="submit">
                                                                        حذف
                                                                    </button>
                                                                </form>

                                                                <form class="dropdown-item" action="{{ route('invoice.status',$invoice->id) }} " method="get">
                                                                    <button class="w-100 btn  font-bold" type="submit">  تغير حاله الفاتوره  </button>
                                                                </form>
                                                                <form class="dropdown-item" action="{{ route('invoice.print',$invoice->id) }} " method="get">
                                                                    <button class="w-100 btn  font-bold" type="submit">   طباعه الفاتوره   </button>
                                                                </form>

                                                        </div>
                                                    </div>
                                                </td>

											</tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    @else
                    <div class="alert alert-danger text-center">
                        لا يوجد فواتير لعرضها
                    </div>
                    @endif
                    @else
                    <div class="col-12 alert alert-danger text-center">
                        لا يوجد فواتير لعرضها
                    </div>

                    @endif



				</div>
                <script>
                    var inputDate=document.querySelector("input[class='in-date']");
                    var inputNumber=document.querySelector("input[class='in-number']");
                    var section1=document.getElementById("date");
                    var section2=document.getElementById("number");
                    section2.style.display="none";
                    inputNumber.addEventListener("change",function(){
                        section1.style.display="none";
                        section1.removeAttribute("name");
                        section2.style.display="block";
                    })
                    inputDate.addEventListener("change",function(){
                        section1.style.display="block";
                        section2.style.display="none";
                    })
                </script>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
