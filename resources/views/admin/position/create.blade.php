@extends('admin.layout.app')

@section('page', __('admin.Position_Management'))

@section('contant')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4">
                <div class="col-12 col-lg-12 pt-4 pt-lg-0">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">{!! __('admin.Add') !!} {!! __('admin.Position') !!}</h5>
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
                            <form action="{{ route('position.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3 g-3">

                                    {{-- Name Arabic --}}
                                    <div class="col-12 col-md-12">
                                        <label class="form-label">{!! __('admin.Name') !!}</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" required>
                                        <br>
                                    </div>


                                    {{-- Jobs --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Jobs') !!}</label>
                                        <select name="jop_id" class="form-select  select2" required>
                                            <option value="">اختر</option>

                                            @foreach ($jops as $jop)
                                                <option value="{{ $jop->id }}">{{ $jop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- Grades --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Grades') !!}</label>
                                        <select name="grade_id" class="form-select  select2" required>
                                            <option value="">اختر</option>

                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
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
