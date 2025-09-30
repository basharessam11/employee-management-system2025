@extends('admin.layout.app')

@section('page', __('admin.DepartmentUser_Management'))

@section('contant')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4">
                <div class="col-12 col-lg-12 pt-4 pt-lg-0">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">{!! __('admin.Add') !!} {!! __('admin.Department User') !!}</h5>
                        </div>
                        <div class="card-body">

                            {{-- ✅ Alerts --}}
                            @if (session('success'))
                                <div class="alert alert-success text-center">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger text-center">{{ session('error') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- ✅ Form --}}
                            <form action="{{ route('department_user.store',$id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3 g-3">



                                    {{-- User --}}
                                    <div class="col-12 col-md-12">
                                        <label class="form-label">{!! __('admin.User') !!}</label>
                                        <select name="user_id" class="form-select  select2" required>
                                            <option value="">اختر</option>

                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>





                                    <div class="d-flex justify-content-end gap-3">

                                        <button type="submit" class="btn btn-primary">{!! __('admin.Save') !!}</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
