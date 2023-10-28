@extends('Core::layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">اصلی</a></li>
    <li class="breadcrumb-item active" aria-current="page">لیست ادمین ها</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">لیست ادمین ها</h6>
          <div class="row">
              <div class="col md3" style="text-align: end; float: left;">
                  <a href="{{route('admins.create')}}" class="btn btn-primary btn-icon-text">
                      ایجاد ادمین
                      <i class="btn-icon-append" data-feather="check-square"></i>
                  </a>
              </div>
          </div>
          <div class="row mb-2">
              @include('Core::components.filter',[])
          </div>
          {{--        <p class="text-muted mb-3">Read the <a href="https://datatables.net/" target="_blank"> Official DataTables Documentation </a>for a full list of instructions and other options.</p>--}}
        <div class="table-responsive">
          <table  class="table" style="text-align: center">
            <thead>
              <tr>
                <th>شمارنده</th>
                <th>نام و نام خانوادگی</th>
                <th>نام کاربری</th>
                <th>ایمیل</th>
                <th>شماره تماس</th>
                <th>نقش</th>
                <th>آخرین ورود</th>
                <th>عملیات</th>
              </tr>
            </thead>
            <tbody>
            @foreach($admins as $key => $admin)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$admin->first_name}} {{$admin->last_name}}</td>
                    <td>{{$admin->username}}</td>
                    <td>{{$admin->email}}</td>
                    <td>{{$admin->phone}}</td>
                    <td><span class="badge bg-primary">{{$admin->getRoleNames()->first()}}</span></td>
                    <td>{{$admin->last_login != '0 ثانیه پیش'  ? $admin->last_login :  'کاربر هنوز لاگین نکرده'}}</td>
                    <td>
                        <a href="{{route('admins.edit', ['admin' => $admin])}}"><span
                                class="badge bg-warning">ویرایش</span></a>
                        <a onclick="loadDeleteModal({{ $admin->id }}, `{{ $admin->first_name.' '.$admin->last_name }}`)" style="cursor: pointer;"><span
                                class="badge bg-danger">حذف</span></a>

                        <div class="modal fade" id="deleteUser" data-backdrop="static" tabindex="-1" role="dialog"
                             aria-labelledby="deleteUser" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">هشدار</h5>
                                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close" onclick="$('#deleteUser').modal('hide')">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        آیا می‌خواهید حذف صورت گیرد؟ <br><br><span id="modal-delete"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="$('#deleteUser').modal('hide')">بستن</button>
                                        <button type="button" class="btn btn-danger" id="modal-confirm_delete">قبول</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
          </table>
            <div  class="mt-5 justify-content-center " >
                @if(count($admins))
                    @include('Core::components.paginate',['paginator'=>$admins])
                @endif
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session()->has('error-message'))
        Swal.fire({
            icon: 'error',
            title: '{{session()->get('error-message')}}',
            showConfirmButton: false,
            timer: 1500
        })
        @endif
        @if(session()->has('success-message'))
        Swal.fire({
            icon: 'success',
            title: '{{session()->get('success-message')}}',
            showConfirmButton: false,
            timer: 1500
        })
        @endif
        function loadDeleteModal(id, name) {
            $('#modal-delete').html(' کاربر : '+name);
            $('#modal-confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteUser').modal('show');
        }
        function confirmDelete(user) {
            $.ajax({
                url: '/admin/admins/' + user +'/delete',
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'get',
                },
                success: function (data) {
                    // Success logic goes here..!
                    $('#deleteUser').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })

                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    //
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            });
        }
    </script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
