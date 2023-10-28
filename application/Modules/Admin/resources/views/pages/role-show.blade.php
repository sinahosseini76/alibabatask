@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">نقش ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ساخت نقش</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6" style="text-align: left; padding-left: 50px;"><a class="btn btn-secondary mb-5" style="text-align: left;" href="{{route('roles.index')}}">بازگشت</a></div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{--        <h6 class="card-title">Inputs</h6>--}}
                        <div class="row">
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">عنوان نقش</label>
                                <input type="text" class="form-control" id="exampleInputText1" name="name"
                                       value="{{$role->name}}" placeholder="عنوان نقش" disabled>
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <div class="form-check form-check-inline form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" @if(in_array($permission->id,$rolePermissions)) checked @endif
                                               id="formSwitch{{$permission->id}}" name="permissions[]"
                                               value="{{$permission->id}}" disabled>
                                        <label class="form-check-label" for="formSwitch1">{{$permission->name}}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection
