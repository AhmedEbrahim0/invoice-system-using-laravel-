@extends('layouts.master')
@section('title')
    المنتجات
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
{{-- <!-- Basic modal --> --}}
<div class="modal" id="modaldemo1">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div>
                    adas
                </div>

                <form action="{{ route('product.store') }}" method="post" autocomplete="off">
                    @csrf
                    <div>
                        <input type="text" name="product_name" placeholder="-- name">
                    </div>
                    <div>
                        <select name="section_id" id="">
                            <option value="" disabled selected>القسم</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="text" name="description">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn ripple btn-primary" type="button">اضافه منتج</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
            </div>
            </form>

        </div>
    </div>
</div>
<div class="modal" id="modaldemo2">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل منتج</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <form action="{{ route('product.update', 0) }}" method="post" autocomplete="off" >
                    @csrf
                    @method("PUT")
                    <div>
                        <input class="product-name" type="text" name="product_name" placeholder="-- name">
                    </div>
                    <div>
                        <select name="section" id="">
                            <option value="" disabled selected>القسم</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <textarea class="description"  name="description" id="" cols="30" rows="3"></textarea>
                    </div>
                    <div>
                        <input type="hidden" name="product_id"  class="product-id" >
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn ripple btn-primary" type="button">تعديل منتج</button>
                <button type="button" class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
            </div>
            </form>


        </div>
    </div>
</div>

{{-- <!-- End Basic modal --> --}}
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif
    @if (session('success'))
        <div class="alert alert-secondary">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        {{-- for button of modal --}}
        <a class=" mx-3 btn ripple btn-primary" data-target="#modaldemo1" data-toggle="modal" href=""> اضافه منتج </a>
        {{-- end of  for button of modal --}}


        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">  #    </th>
                                    <th class="wd-15p border-bottom-0" اسم المنتج</th>
                                    <th class="wd-15p border-bottom-0"> اسم القسم</th>
                                    <th class="wd-20p border-bottom-0">ملاحظات </th>
                                    <th class="wd-10p border-bottom-0">التاريخ</th>
                                    <th class="wd-20p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($products as $product)
                                <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $product->Product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->created_at->diffForhumans()}}</td>
                                        <td>
                                            <form action="{{ route('product.destroy',$product->id) }}" class="d-inline-block" style="display: inline-block;" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"> حذف المنتج </button>
                                            </form>

                                            <a
                                            data-name="{{ $product->product_name }}"
                                            data-id="{{ $product->id }}"
                                            data-description="{{ $product->description }}"
                                            style="display: inline-block"
                                            class="btn-edit mx-2 btn ripple btn-warning" data-target="#modaldemo2" data-toggle="modal" href=""> تعديل منتج </a>
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

    <script>
        var editName=document.querySelector(".product-name");
        var editDescription=document.querySelector(".description");
        var editId=document.querySelector(".product-id");

        let btnEdit1=document.querySelectorAll(".btn-edit");
        Array.from(btnEdit1).forEach(item=>{
            item.addEventListener("click",function(){
                const name=item.getAttribute("data-name")
                const id=item.getAttribute("data-id")
                const description=item.getAttribute("data-description")
                editName.value=name;
                editDescription=description;
                editId.value=id;
            })
        })
    </script>
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
@endsection
