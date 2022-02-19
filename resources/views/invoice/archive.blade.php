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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ارشيف  الفواتير  </span>
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
                                            @foreach ($archives as $archive )
											<tr>
                                                <td>{{ $i++ }}</td>
												<td>{{ $archive->invoice_number }}</td>
												<td> {{ $archive->invoice_Date }} </td>
												<td>{{ $archive->Due_date }}</td>
												<td>{{ $archive->product }}</td>
												<td >
                                                    <a href="{{ route('invoice.show',$archive->id) }}">
                                                        {{ $archive->section->section_name }}</td>
                                                    </a>
                                                <td>{{ $archive->Discount }}</td>
                                                <td>{{ $archive->Rate_VAT }}%</td>
                                                <td>{{ $archive->Total }}</td>
                                                <td
                                                @if($archive->Value_Status==0)
                                                style="color: red; font-size:20px;"
                                                @else
                                                style="color: blue; font-size:20px;"

                                                @endif
                                                >{{ $archive->Status }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-info"
                                                        data-toggle="dropdown" type="button"> العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                        <div class="dropdown-menu tx-13">
                                                            <a class="dropdown-item" href="{{ route('invoice.archive.update',$archive->id) }}">الغاء الارشيف</a>

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
