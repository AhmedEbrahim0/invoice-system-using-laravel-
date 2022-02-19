@extends('layouts.master')
@section('title')
الاقسام
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
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  الاقسام </span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->

                {{--  <!-- model for add section -->  --}}
                <div class="modal " id="modaldemo1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">اضافه قسم </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>


                            <form action="{{ route('section.store') }}" method="post" autocomplete="off">
                            <div class="modal-body">

                                    @csrf
                                    <div>
                                        <p>
                                            <label for="name-section"> اسم القسم </label>
                                        </p>
                                        <input type="text" name="section_name" id="name-section" placeholder=" -- name" >
                                    </div>
                                    <div>
                                        <p>
                                            <label for="description-section"> ملاحظات  </label>
                                        </p>
                                        <input type="text" name="description" id="description-section" placeholder=" -- name" >
                                    </div>
                                    <div>

                                        <input type="hidden"  value="{{ Auth::user()->name }}"  name="created_by"placeholder=" -- name" >
                                    </div>

                                </div>



                                <div class="modal-footer">
                                    <button type="submit" class="btn ripple btn-primary" type="button"> حفظ  </button>
                                    <button  type="button" class="btn ripple btn-secondary" data-dismiss="modal" type="button">  اغلاق </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal " id="modaldemo2">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">تعديل  قسم </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>


            <form action="{{ route('section.update',0) }}" method="post" autocomplete="off">
            <div class="modal-body">
                    @method('PUT')
                    @csrf
                    <div>
                        <p>
                            <label for="name-section"> اسم القسم </label>
                        </p>
                        <input  class="section-name" type="text" name="section_name" id="name-section" placeholder=" -- name" >
                    </div>
                    <div>
                        <p>
                            <label for="description-section"> ملاحظات  </label>
                        </p>
                        <input  class="section-description" type="text" name="description" id="description-section" placeholder=" -- name" >
                    </div>
                    <div>
                        <input type="hidden"  value="{{ Auth::user()->name }}" name="created_by">
                    </div>
                    <div>

                        <input class="section-id" type="hidden"   name="id" >
                    </div>

                </div>



                                <div class="modal-footer">
                                    <button type="submit" class="btn ripple btn-primary" type="button"> حفظ التعديلات  </button>
                                    <button  type="button" class="btn ripple btn-secondary" data-dismiss="modal" type="button">  اغلاق </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{--  <!-- End add section -->  --}}

				<div class="row">
                    @if (session("errors"))
                        <div class="alert alert-danger">
                            {{ session("errors")  }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif


                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
								<div class="d-flex justify-content-between">
                                    <h4 class="card-title mg-b-0">الاقسام </h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
                            <div class="row">

                                <a class="btn ripple btn-primary mx-3  "  data-target="#modaldemo1" data-toggle="modal" href=""> اضافه قسم </a>
                            </div>

							<div class="card-body">
                                <div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
                                        <thead>

                                            <tr>
                                                <th class="wd-5p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0"> اسم قسم </th>
												<th class="wd-20p border-bottom-0"> الوصف </th>
                                                <th class="wd-15p border-bottom-0">تاريخ </th>
                                                <th class="wd-15p border-bottom-0">العمليات  </th>

											</tr>
										</thead>
										<tbody>
                                            @php
                                            $i=1;
                                            @endphp
                                            @foreach ($sections as $section )
											<tr>
                                                <td>{{ $i++  }}</td>
												<td>{{ $section->section_name }}</td>
												<td>{{ $section->description }}</td>
												<td>{{ $section->created_at->diffForhumans() }}</td>

    <td>
        <form  class="d-inline-block" action="{{  route('section.destroy',$section->id)  }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-delete"> حذف </button>
        </form>
        {{--  this for edit   --}}
        <a
        data-id="{{ $section->id }}"
        data-name="{{ $section->section_name }}"
        data-description="{{ $section->description }}"
        class="btn ripple btn-primary mx-3  btn-edit1"  data-target="#modaldemo2" data-toggle="modal" href=""> تعديل قسم
        </a>
    {{--  this for edit   --}}

    </td>

											</tr>
                                            @endforeach
                                            <script>
                                    
                                                var btnEdit=document.querySelectorAll(".btn-edit1");
                                    
                                                
                                                let formName=document.querySelector(".section-name")
                                                let formDescription=document.querySelector(".section-description")
                                                let formId=document.querySelector(".section-id")
                                                Array.from(btnEdit).forEach(btn=>{
                                                    console.log(btn);
                                                    btn.onclick=()=>{
                                    
                                                        var sectionName=btn.getAttribute("data-name");
                                                        var sectionDescription=btn.getAttribute("data-description");
                                                        var sectionId=btn.getAttribute("data-id");
                                                        formName.value=sectionName;
                                                        formDescription.value=sectionDescription;
                                                        formId.value=sectionId;
                                                    }
                                                    
                                                })
                                            </script>
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

