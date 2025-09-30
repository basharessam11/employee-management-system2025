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
                    <h5 class="card-title"> {!! __('admin.Reports') !!}</h5>
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










                            </div>


                        </div>
                        <table id="products-table"
                            class="datatables-products table border-top dataTable no-footer dtr-column">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin.Employees') }}</th>

                                    <th>{{ __('admin.Departments') }}</th>
                                    <th>{{ __('admin.Units') }}</th>
                                    <th>{{ __('admin.Score') }}</th>
                                    <th>{{ __('admin.Date') }}</th>
                                    <th>{{ __('admin.Status') }}</th>


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

                                @foreach ($results as $key => $result)
                                    <tr class="odd">

                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        {{-- @dd($result->manager) --}}
                                        @if (App::isLocale('en'))
                                            <td> {{ $result->user->name_en }}</td>
                                        @else
                                            <td> {{ $result->user->name_ar }}</td>
                                        @endif
                                        {{-- @dd($result->user->department_user  ) --}}
                                        <td> {{ $result->user->department_user->first()->department->name }}</td>

                                        <td> {{ $result->user->department_user->first()->unit->name }}</td>
                                        <td> {{ $result->score }}</td>
                                        <td> {{ $result->year }}</td>
                                        <td>
                                            @if ($result->status == 0)
                                                <span
                                                    class="badge bg-label-danger true{{ $result->id }}"> <i class="bx bxs-circle fs-tiny me-2"></i>{{ __('admin.Disapproved') }}</span>
                                            @elseif ($result->status == 1)
                                                <span
                                                    class="badge bg-label-success true{{ $result->id }}"> <i class="bx bxs-circle fs-tiny me-2"></i>{{ __('admin.Approved') }}</span>
                                            @endif
                                        @if ($result->status == 2)
                                            <span
                                                class="badge bg-label-success true{{ $result->id }}"> <i class="bx bxs-circle fs-tiny me-2"></i>{{ __('admin.Publish') }}</span>
                                @endif
                                </td>


                                <td>





                                    <div class="d-inline-block text-nowrap">

                                        <a href="{{ route('result.edit', $result->id) }}">
                                            <button class="btn btn-sm btn-icon">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </a>

                                        <a href="{{ route('result.show', $result->id) }}">
                                            <button class="btn btn-sm btn-icon">
                                                <i class='bx bxs-show'></i>
                                            </button>
                                        </a>
                                        <button
                                            class="btn btn-{{ $result->status == 2 ? 'success' : 'danger' }} toggle-status-btn ms-2"
                                            data-id="{{ $result->id }}">
                                            <i class='bx bxs-{{ $result->status == 2 ? 'check-circle' : 'x-circle' }}'></i>
                                        </button>


                                        <!-- الزرار -->
                                        <button type="button" class="btn btn-primary ms-2 model" data-bs-toggle="modal"
                                            i="{{ $result->id }}" data-bs-target="#commentModal ">
                                            <i class="bx bxs-message "></i>

                                        </button>



                                    </div>



                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row mx-2">
                            {{ $results->links('vendor.pagination.bootstrap-5') }}
                        </div>




                        <!-- المودال -->
                        <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('hr.approved') }}">
                                    @csrf
                                    <input type="hidden" name="transfer_id" value="{{ $result->id }}">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="commentModalLabel{{ $result->id }}">إضافة
                                                تعليق</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea name="comment3" class="form-control" placeholder="اكتب تعليقك هنا..." required></textarea>
                                            <input type="hidden" name="id" class="result_id">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>











                        <script>
                            $(document).ready(function() {



                                $('.model').click(function() {
                                    let id = $(this).attr('i');
                                    $('.result_id').val(id);
                                });







                                $('.toggle-status-btn').click(function() {
                                    let button = $(this);
                                    let id = button.data('id');
                                    // console.log(id)
                                    $.ajax({
                                        url: '{{ route('hr.toggleStatus') }}',
                                        type: 'POST',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            id: id
                                        },
                                        success: function(response) {
                                            // console.log(response)
                                            if (response.success) {
                                                // أولًا، إحذف الكلاسات السابقة
                                                button.removeClass('btn-success btn-danger toggle-status-btn');

                                                // أضف الكلاس الجديد بناءً على الاستجابة
                                                button.addClass(response.new_status ?
                                                    'btn btn-success toggle-status-btn' :
                                                    'btn btn-danger toggle-status-btn');

                                                // تغيير الأيقونة بناءً على الحالة الجديدة
                                                button.html(response.new_status ?
                                                    `<i class="bx bxs-check-circle"></i>` :
                                                    `<i class="bx bxs-x-circle"></i>`);
                                                // تغيير الأيقونة بناءً على الحالة الجديدة
                                                $('.true' + id).html(response.new_status ?
                                                        ` <i class="bx bxs-circle fs-tiny me-2"></i>{{ __('admin.Publish') }}` :
                                                        `<i class="bx bxs-circle fs-tiny me-2"></i>{{ __('admin.Disapproved') }}`
                                                    )
                                                    .removeClass('bg-label-danger bg-label-success ').addClass(
                                                        response
                                                        .new_status ?
                                                        'bg-label-success' :
                                                        'bg-label-danger');
                                            }

                                        }

                                    });
                                });


















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
