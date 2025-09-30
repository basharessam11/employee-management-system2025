@extends('admin.layout.app')

@section('page', 'Order List')


@section('contant')




    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">



            <!-- Product List Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> {!! __('admin.Department User') !!}</h5>
                    <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">


                        {{-- --------------------------------------------------------------Alert-------------------------------------------------------------------- --}}


                        @if (session('success'))
                            <div id="success-message" class="alert alert-success alert-dismissible fade show text-center"
                                role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div id="danger-message" class="alert alert-danger alert-dismissible fade show text-center"
                                role="alert">
                                {{ session('error') }}
                            </div>
                        @endif



                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    {{-- @dd($errors) --}}
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- --------------------------------------------------------------End Alert-------------------------------------------------------------------- --}}


                    </div>

                </div>

                <!-- customers List Table -->
                <div class="card">

                    <div class="card-datatable table-responsive">
                        <div id="products-table_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="card-header d-flex border-top rounded-0 flex-wrap py-md-0 ">


                                {{-- -------------------------------------------------------------- Filter-------------------------------------------------------------------- --}}



                                <form method="GET" action="{{ route('department_user.show', $id) }}"
                                    class="col-12 col-md-6 col-lg-8   ">
                                    <div class="row g-2 mb-4"> <!-- أضف g-2 لزيادة المسافات -->

                                        <!-- البحث -->
                                        <div class="col-12 col-md-6 col-lg-6  align-items-end">


                                            <label class="form-label">{!! __('admin.User') !!}</label>
                                            <select name="user_id" class="form-select  select2" required>
                                                <option value="">اختر</option>
                                                <option value="all"
                                                    {{ old('user_id', request('user_id', 'all' ?? null)) == 'all' ? 'selected' : '' }}>
                                                    All</option>


                                                @foreach ($users as $user)
                                                    <option value="{{ $user->user->id }}"
                                                        {{ old('user_id', request('user_id', $selectedUserId ?? null)) == $user->id ? 'selected' : '' }}>

                                                        @if (App::isLocale('en'))
                                                            {{ $user->user->name_en }}
                                                        @else
                                                            {{ $user->user->name_ar }}
                                                        @endif

                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>



                                        <!-- زر البحث -->
                                        <div class="col-12 col-md-6 col-lg-4 d-flex align-items-end">
                                            <button type="submit"
                                                class="btn btn-primary w-100 mt-4">{!! __('admin.Search') !!}</button>
                                        </div>

                                    </div>
                                </form>

                                {{-- --------------------------------------------------------------End Filter-------------------------------------------------------------------- --}}







                                {{-- --------------------------------------------------------------End button-------------------------------------------------------------------- --}}



                                <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                    <div
                                        class="dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center mb-3 mb-sm-0">

                                        <div class="dt-buttons btn-group flex-wrap"> <button
                                                class="btn btn-secondary add-new btn-danger de me-3" tabindex="0"
                                                aria-controls="products-table" type="button" data-bs-toggle="modal"
                                                data-bs-target="#basicModal2" style="display:none"><span><i
                                                        class="bx bx-trash"></i><span
                                                        class="d-none d-sm-inline-block">{{ __('admin.Delete') }}
                                                    </span></span></button>
                                            @can('add department_user')
                                                <a href="{{ route('department_user.create', $id) }}">
                                                    <button class="btn btn-secondary add-new btn-primary ms-2" tabindex="0"
                                                        aria-controls="products-table" type="button" data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasEcommerceCategoryList"><span><i
                                                                class="bx bx-plus me-0 me-sm-1"></i>{!! __('admin.Add') !!}
                                                            {!! __('admin.Departments') !!}</span></button>

                                                </a>
                                            @endcan

                                        </div>
                                    </div>
                                </div>
                                {{-- --------------------------------------------------------------End button-------------------------------------------------------------------- --}}


                            </div>


                        </div>
                        <table id="products-table"
                            class="datatables-products table border-top dataTable no-footer dtr-column">
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>{{ __('admin.Department User') }}</th>
                                    <th>{{ __('admin.Departments') }}</th>
                                    <th>{{ __('admin.Units') }}</th>


                                    <th>{{ __('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($expenses) --}}
                                {{-- @if ($expenses->isEmpty())
                                <tr class="odd">
                                    <td valign="top" colspan="6" class="dataTables_empty">لا توجد سجلات مطابقة</td>
                                </tr>
                            @endif --}}

                                @foreach ($departments as $key => $department)
                                    <tr class="odd">
                                        <td>
                                            {{ $key + 1 }}

                                        </td>

                                        {{-- @dd($department->manager) --}}
                                        @if (App::isLocale('en'))
                                            <td> {{ $department->user->name_en }}</td>
                                        @else
                                            <td> {{ $department->user->name_ar }}</td>
                                        @endif
                                        <td> {{ $department->department->name }}</td>
                                        <td> {{ $department->unit->name }}</td>




                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                @can('edit department_user')
                                                    <a href="{{ route('department_user.edit', $department->id) }}">
                                                        <button class="btn btn-sm btn-icon">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </a>
                                                @endcan
                                                <a href="{{ route('result.index', $department->user->id) }}">
                                                    <button class="btn btn-sm btn-icon">
                                                        <i class='bx bxs-show'></i>
                                                    </button>
                                                </a>
                                            </div>



                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mx-2">
                            {{ $departments->links('vendor.pagination.bootstrap-5') }}
                        </div>
                        <script>
                            $(document).ready(function() {
                                var table = $('#products-table').DataTable({



                                    responsive: {
                                        details: {
                                            display: $.fn.dataTable.Responsive.display.modal({
                                                header: function(row) {
                                                    return 'تفاصيل ' + row.data()[
                                                        1]; // عرض اسم العميل في عنوان المودال
                                                }
                                            }),
                                            type: "column",
                                            renderer: function(api, rowIdx, columns) {
                                                var data = $.map(columns, function(col, i) {
                                                    return col.title ?
                                                        `<tr><td><strong>${col.title}:</strong></td><td>${col.data}</td></tr>` :
                                                        '';
                                                }).join('');
                                                return data ? $('<table class="table"/>').append('<tbody>' + data +
                                                    '</tbody>') : false;
                                            }
                                        }
                                    },
                                    paging: false, // 🚫 إيقاف الباجيناشن
                                    info: false, // 🚫 إخفاء "Showing X to Y of Z entries"
                                    ordering: true,
                                    searching: false
                                });
                            });
                        </script>

                    </div>
                    <br>
                    <br>
                </div>

            </div>
        </div>
        <!-- / Content -->


        {{-- -------------------------------------------------------------- Delete-------------------------------------------------------------------- --}}

        <div class="modal fade" id="basicModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1 " data-i18n="{{ __('admin.Delete') }}">
                            {{ __('admin.Delete') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form method="POST" action="{{ route('department_user.destroy', 0) }}">
                                @method('delete')
                                @csrf
                                <div id="name" class=" col mb-3">

                                    ﻫﻞ اﻧﺖ ﻣﺘﺄﻛﺪ ﻣﻦ اﻧﻚ ﺗﺮﻳﺪ اﻟﺤﺬﻑ؟

                                </div>
                                <input class="val" type="hidden" name="id">


                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            data-i18n="{{ __('admin.Close') }}">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-danger"
                            data-i18n="{{ __('admin.Delete') }}">{{ __('admin.Delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- --------------------------------------------------------------end Delete-------------------------------------------------------------------- --}}



    @endsection
