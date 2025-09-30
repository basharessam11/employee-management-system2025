@extends('admin.layout.app')

@section('page', __('admin.Users_Management'))

@section('contant')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4">
                <div class="col-12 col-lg-12 pt-4 pt-lg-0">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title m-0">{!! __('admin.Add Employees') !!}</h5>
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
                            <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3 g-3">

                                    {{-- Name Arabic --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Name_ar') !!}</label>
                                        <input type="text" class="form-control" name="name_ar"
                                            value="{{ old('name_ar') }}" required>
                                    </div>

                                    {{-- Name English --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Name_en') !!}</label>
                                        <input type="text" class="form-control" name="name_en"
                                            value="{{ old('name_en') }}" required>
                                    </div>

                                    {{-- Location --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Location') !!}</label>
                                        <select name="location_id" class="form-select">
                                            @foreach ($locations as $loc)
                                                <option value="{{ $loc->id }}">{{ $loc->location }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Married --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Married') !!}</label>
                                        <select name="married" class="form-select">
                                            <option value="1">{!! __('admin.Married_yes') !!}</option>
                                            <option value="0">{!! __('admin.Married_no') !!}</option>
                                        </select>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Phone') !!}</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone') }}">
                                    </div>

                                    {{-- Country --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Country') !!}</label>
                                        <select name="country_id" class="form-select">
                                            @foreach ($countries as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Iqama --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Iqama') !!}</label>
                                        <input type="text" class="form-control" name="iqama"
                                            value="{{ old('iqama') }}">
                                    </div>

                                    {{-- Iqama Expiry --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Ex_date_iqama') !!}</label>
                                        <input type="date" class="form-control" name="ex_date_iqama"
                                            value="{{ old('ex_date_iqama') }}">
                                    </div>

                                    {{-- Payment Method --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Payment_Method') !!}</label>
                                        <select name="paymant_method" class="form-select">
                                            <option value="0">{!! __('admin.Cash') !!}</option>
                                            <option value="1">{!! __('admin.Bank_Transfer') !!}</option>
                                        </select>
                                    </div>

                                    {{-- Position --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Position') !!}</label>
                                        <select name="position_id" class="form-select">
                                            @foreach ($positions as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Birthday --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Birthday') !!}</label>
                                        <input type="date" class="form-control" name="birthday"
                                            value="{{ old('birthday') }}">
                                    </div>

                                    {{-- Join Date --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Join_Date') !!}</label>
                                        <input type="date" class="form-control" name="join_date"
                                            value="{{ old('join_date') }}">
                                    </div>

                                    {{-- Qualification --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Qualification') !!}</label>
                                        <input type="text" class="form-control" name="qualification"
                                            value="{{ old('qualification') }}">
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Status') !!}</label>
                                        <select name="status" class="form-select">
                                            <option value="1">{!! __('admin.Active') !!}</option>
                                            <option value="0">{!! __('admin.Inactive') !!}</option>
                                        </select>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Email') !!}</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}">
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{!! __('admin.Password') !!}</label>
                                        <input type="password" class="form-control" name="password" value="12345678">
                                    </div>


                                    {{-- Role --}}
                                    <div class="col-12 col-md-12">
                                        <label class="form-label">{!! __('admin.Roles') !!}</label>
                                        <select name="role" class="form-select select2">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>




                                    {{-- Photo --}}
                                    <div class="col-12">
                                        <label class="form-label">{!! __('admin.Photo') !!}</label>
                                        <input type="file" class="form-control" name="photo">
                                    </div>
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
