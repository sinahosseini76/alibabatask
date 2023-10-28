@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">ادمین ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش ادمین</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6" style="text-align: left; padding-left: 50px;"><a class="btn btn-secondary mb-5" style="text-align: left;" href="{{route('admins.index')}}">بازگشت</a></div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{--        <h6 class="card-title">Inputs</h6>--}}
                    <form action="{{route('admins.update', ['admin' => $admin])}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleInputText1" name="first_name"
                                       value="{{$admin->first_name}}" >
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام خانوادگی</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleInputText1" name="last_name"
                                       value="{{$admin->last_name}}" >
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">ایمیل</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputText1" name="email"
                                       value="{{$admin->email}}" >
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام کاربری</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="exampleInputText1" name="username"
                                       value="{{$admin->username}}" >
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">شماره تماس</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputText1" name="phone"
                                       value="{{$admin->phone}}" >
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نقش</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if($admin->roles->first()->id == $role->id) selected @endif>{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">پسورد جدید</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror" id="exampleInputText1" name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary mt-5" type="submit">ثبت</button>
                    </form>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <span class="badge bg-danger mt-3">{{$error}}</span>
                            <br>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
