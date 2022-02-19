@extends('layouts.master')
@extends('layouts.head')
@section('title')
الفواتير
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
		{{--  <!-- Basic modal -->  --}}
		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Basic Modal</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h6>Modal Body</h6>
						<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" type="button">Save changes</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
					</div>
				</div>
			</div>
		</div>
		{{--  <!-- End Basic modal -->  --}}

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير</span>
						</div>
					</div>
				</div>
                @can("create")
                <div>
                    test permision
                </div>
                @endcan
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                @if(session("success"))
                        <div class="alert alert-success">{{ session("success") }}</div>
                @endif
				<div class="row">
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
												<th class="wd-10p border-bottom-0">رقم الفاتوره</th>
												<th class="wd-20p border-bottom-0">تاريخ الفاتوره</th>
                                                <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
												<th class="wd-10p border-bottom-0">المنتج</th>
												<th class="wd-10p border-bottom-0">القسم</th>
												<th class="wd-5p border-bottom-0">الخصم</th>
												<th class="wd-25p border-bottom-0">نسبه الضريبه</th>

												<th class="wd-25p border-bottom-0">   قيمه الضريبه </th>
                                                <th class="wd-25p border-bottom-0">   الاجمالي   </th>

                                                <th class="wd-30p border-bottom-0">   الحاله    </th>
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
                                                style="color:red;  font-size:16px; "
                                                @else
                                                style="color:blue; font-size:16px;  "
                                                @endif
                                                >
                                                    {{$invoice->Status}}</td>
                                                </div>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true"  style="font-size: 16px; padding:5px;" class="btn ripple btn-info"
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
