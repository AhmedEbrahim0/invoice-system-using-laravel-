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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير  الغير مدفوعه </span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
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
												<td>{{ $invoice->invoice_number }}</td>
												<td> {{ $invoice->invoice_Date }} </td>
												<td>{{ $invoice->Due_date }}</td>
												<td>{{ $invoice->product }}</td>
												<td >
                                                    <a href="{{ route('invoice.show',$invoice->id) }}">
                                                        {{ $invoice->section->section_name }}</td>
                                                    </a>
                                                <td>{{ $invoice->Discount }}</td>
                                                <td>{{ $invoice->Rate_VAT }}%</td>
                                                <td>{{ $invoice->Total }}</td>
                                                <td  style="color: red; font-size:20px;">{{ $invoice->Status }}</td>
                                                <td>{{ $invoice->Status }}</td>
											</tr>
                                            @endforeach

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
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
