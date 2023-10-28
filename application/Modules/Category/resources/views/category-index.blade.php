@extends('Core::layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">اصلی</a></li>
    <li class="breadcrumb-item active" aria-current="page">لیست دسته بندی ها</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">لیست دسته بندی ها</h6>
          <div class="row">
              <div class="col md3" style="text-align: end; float: left;">
                  <a href="{{route('category.create')}}" class="btn btn-primary btn-icon-text">
افزودن
                      <i class="btn-icon-append" data-feather="plus-square"></i>
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
                <th>عکس</th>
                <th>نام فارسی</th>
                <th>نام انگلیسی</th>
                  <th>توضیحات فارسی</th>
                <th>توضیحات انگلیسی</th>
                <th>وضعیت</th>
                <th>اولویت</th>
                <th>بازدید</th>
                <th>دسته بندی مادر</th>
                <th>عملیات</th>
              </tr>
            </thead>
            <tbody>
            @foreach($categories as $key => $category)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td class="text-center"><a href="{{$category->attachment ?? asset('assets/images/sample.jpg')}}" target="_blank"><img src="{{$category->attachment ?? asset('assets/images/avatar.png')}}" width="75px" height="75px"></a></td>
                    <td>{{$category->name_fa}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->description_fa}}</td>
                    <td>{{$category->description}}</td>
                    @if($category->status == \Modules\Category\Models\Category::STATUS_ACTIVE)
                        <td><a href="{{route('category.changeStatus', ['category' => $category])}}"><span
                                    class="badge bg-success">فعال</span></a></td>
                    @else
                        <td><a href="{{route('category.changeStatus', ['category' => $category])}}"><span
                                    class="badge bg-danger">غیر فعال</span></a></td>
                    @endif
                    <td>{{$category->priority}}</td>
                    <td><span class="badge bg-primary">{{$category->view}}</span></td>
                    <td style="cursor: pointer;"><span onclick="loadInfoModal({{ $category->parent_id }}, `{{\Modules\Category\Models\Category::find($category->parent_id)}}`)">{{is_null($category->parent_id)  ? 'دسته بندی مادر' :  $category->parent_id}}</span></td>
                    <td>
                        <a href="{{route('category.edit', ['category' => $category])}}"><span
                                class="badge bg-warning">ویرایش</span></a>
                        <a onclick="loadDeleteModal({{ $category->id }}, `{{ $category->name. ' ('.$category->name_fa.') ' }}`)" style="cursor: pointer;"><span
                                class="badge bg-danger">حذف</span></a>

                        <div class="modal fade" id="infoModal" data-backdrop="static" tabindex="-1" role="dialog"
                             aria-labelledby="infoModal" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">جزئیات</h5>
                                        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close" onclick="$('#infoModal').modal('hide')">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                       <span id="modal-info"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                @if(count($categories))
                    @include('Core::components.paginate',['paginator'=>$categories])
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
            $('#modal-delete').html(' دسته بندی : '+ name);
            $('#modal-confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteUser').modal('show');
        }

        function loadInfoModal(id,text) {
            // show text in the modal the text is json
            // json to text
            var obj = JSON.parse(text);
            // create small table info
            var table = '<table class="table table-bordered table-striped">';
            table += '<tr><td>نام</td><td>'+obj.name+'</td></tr>';
            table += '<tr><td>نام فارسی</td><td>'+obj.name_fa+'</td></tr>';
            table += '<tr><td>توضیحات</td><td>'+obj.description+'</td></tr>';
            table += '<tr><td>توضیحات فارسی</td><td>'+obj.description_fa+'</td></tr>';
            table += '</table>';
            $('#modal-info').html(table);
            $('#infoModal').modal('show');
        }
        function confirmDelete(category) {
            $.ajax({
                url: '/admin/category/' + category +'/delete',
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
