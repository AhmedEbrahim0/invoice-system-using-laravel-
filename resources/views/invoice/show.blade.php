@extends('layouts.master')
@section('css')
<!---Internal Owl Carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
<!---Internal  Multislider css-->
<link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
<!--- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

{{--  <!-- Basic modal -->  --}}
<div class="modal" id="modaldemo1">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice.destroy',0) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <h6>هل انت متاكد لحذف هذه الفاتوره </h6>
                    <input class="input-remove" type="hidden" name="id"  >
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn ripple btn-primary" type="button">حذف</button>
                </form>
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
							<h4 class="content-title mb-0 my-auto">فاتوره</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
 
                    @foreach ( $attachments as $y )

                    <div class="col-6">
                        <div>
                                <strong class="fs-6" style="font-size: 25px !important">   تم انشاء الفاتوره بواسطه</strong> : {{ $y->Created_by }}
                        </div>
                        <div>
                            <strong> تم الانشاء  </strong>  : {{ $y->created_at->diffForhumans() }}
                        </div>
                        <div>
                            <strong>بتاريخ  </strong>  :  {{ $y->created_at }}
                        </div>

                    </div>
                    @endforeach

                    @foreach ($invoices as $f )

                    <form action="{{ route('attach.add') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="invoice_number" value="{{ $f->invoice_number }}">
                        <input type="hidden" name="invoice_id" value="{{ $f->id }}">
                        <input type="file" name="attach" > <br>
                        <button type="submit">add</button>
                    </form>
                    @endforeach


                    <table border="1" style="width:100% ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الفاتوره </th>
                                <th>التاريخ الاصدار</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $count=1;
                            $check=count($attachments);
                            @endphp

                            @foreach ( $attachments as $attach )

                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $attach->invoice_number }}</td>
                                    <td>{{ $attach->created_at->diffForhumans() }}</td>
                                    <td>
                                        <a href="{{ route('show.attach',[$attach->invoice_number,$attach->file_name]) }}">  show </a>
                                        <a href="{{ route('download',[$attach->invoice_number,$attach->file_name]) }}"> download</a>
                                        @if($check>1)

                                        <a href="{{ route('attach.delete',[$attach->invoice_number,$attach->file_name,$attach->id]) }}"> delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="col-6">
                        @foreach ( $details as $x )

                        <div class="row">
                            <div class="col-6 my-5">
                                <strong style="font-size: 25px !important">نوع الفاتوره </strong> : {{ $x->product }}
                            </div>
                            <div class="col-6 my-5">
                                <strong style="font-size: 25px !important"> الحاله  </strong> : {{ $x->Status }}
                            </div>
                        </div>
                        <div>
                            <h3>الملاحظات</h3>
                            {{ $x->note }}
                        </div>
                        @endforeach

                    </div>

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
