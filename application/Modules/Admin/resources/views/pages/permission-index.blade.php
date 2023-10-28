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
        <h6 class="card-title">دسترسی ها</h6>
{{--        <p class="text-muted mb-3">Read the <a href="https://datatables.net/" target="_blank"> Official DataTables Documentation </a>for a full list of instructions and other options.</p>--}}
        <div class="table-responsive">
          <table  class="table" style="text-align: center">
            <thead>
              <tr>
                <th>شمارنده</th>
                <th>عنوان دسترسی</th>
                <th>توضیح</th>
                <th>تاریخ ساخت</th>
              </tr>
            </thead>
            <tbody>
            @foreach($permissions as $key => $permission)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$permission->name}}</td>
                    <td>{{$permission->description ?? '-'}}</td>
                    <td>{{$permission->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
          </table>
            <div  class="mt-5 justify-content-center " >
                @if(count($permissions))
                    @include('Core::components.paginate',['paginator'=>$permissions])
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
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
