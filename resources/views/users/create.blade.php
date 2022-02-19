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
                @if (session('success'))
                <div class="alert alert-primary">
                        {{ session("success") }}
                </div>
                @endif
				<div class="row">
                    <form method="post" action="{{ route('users.store') }}">
                        @csrf
                        <div class="col-12 my-2">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" name="name" id="name" placeholder="--الاسم --">
                                    @error("name")
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="email" name="email" id="email" placeholder="--الايميل --">
                                        @error("email")
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 my-2">


                                    <div class="row">
                                        <div class="col-6">
                                            <input type="password" name="password" id="password" placeholder="   --رقم السري--">
                                            @error("password")
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror

                                                /div>
                                            </div>

                                            <div class="col-6">
                                                <select style="width: 171px ;"  name="role" id="">
                                                    <option value="" disabled selected>  --  Role -- </option>
                                                    @foreach ($roles as $role )
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                        </div>

                                </div>

                                <div class="col-12">
                                    <select name="status" id="">
                                        <option disabled selected> -- الحاله -- </option>
                                        <option value="0">غير مفعل</option>
                                        <option value="1">مفعل</option>
                                    </select>
                                </div>



                        <div class="col-12">
                            @foreach ($permissions as $permission )
                                <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                                <input  id="{{ $permission->name }}" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                            @endforeach
                        </div>

                        <div class="col-12 text-center">
                            <button class="btn btn-primary">  اضافه مستخدم </button>
                        </div>
                    </form>
				</div>
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
