@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
						</div>
					</div>
                </div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                @if(session("success"))
                    <div class="alert alert-primary">
                        {{ session("success") }}
                    </div>
                @endif
				<div class="row">
                    <div class="col-12">
                        <h3>اسم المستخدم: {{ $user->name }}</h3>
                        <h3>ايميل المستخدم: {{ $user->email}}</h3>

                        <form  class="my-5"  action="{{ route('users.update',$user->id) }}" method="POST" >
                            @csrf
                            @method('PUT')
                            <select class="my-5" name="status" id="">
                                <option disabled selected> -- الحاله -- </option>
                                <option value="0">غير مفعل</option>
                                <option value="1">مفعل</option>
                            </select> <br>

                            
                            @foreach ($permissions as $permission )
                            <label for="{{ $permission->name }}">{{ $permission->name }}</label>

                            <input
                            @for ($i=0;$i<count($user_permissions);$i++)

                                @if($user_permissions[$i]["name"]==$permission->name)
                                    checked
                                @endif
                            @endfor
                            id="{{ $permission->name }}" type="checkbox" name="permissions[]"  value="{{ $permission->name }}">
                            @endforeach



                            <br>
                            <button type="submit"  class="btn btn-danger" > حفظ  التغيرات   </button>
                        </form>
                    </div>
				</div>
				<!-- row closed -->
			<!-- Container closed -->
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
