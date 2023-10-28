@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">دسته بندی ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ساخت دسته بندی</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6" style="text-align: left; padding-left: 50px;"><a class="btn btn-secondary mb-5" style="text-align: left;" href="{{route('category.index')}}">بازگشت</a></div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{--        <h6 class="card-title">Inputs</h6>--}}
                    <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام فارسی</label>
                                <input type="text" class="form-control @error('name_fa') is-invalid @enderror" id="exampleInputText1" name="name_fa"
                                       value="{{old('name_fa')}}" >
                                @error('name_fa')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام انگلیسی</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputText1" name="name"
                                       value="{{old('name')}}" >
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-5">
                                <label for="exampleInputText1" class="form-label">اولویت نمایش</label>
                                <input type="number" class="form-control @error('priority') is-invalid @enderror" id="exampleInputText1" name="priority"
                                       value="{{old('priority')}}" >
                                @error('priority')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-5">
                                <label for="exampleInputText1" class="form-label">دسته بندی مادر</label>
                                <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}} ({{$category->name_fa}})</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-5">
                                <label for="exampleInputText1" class="form-label">توضیحات فارسی</label>
                                <input type="text" class="form-control @error('description_fa') is-invalid @enderror" id="exampleInputText1" name="description_fa"
                                       value="{{old('description_fa')}}" >
                                @error('description_fa')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-5">
                                <label for="exampleInputText1" class="form-label">توضیحات انگلیسی</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="exampleInputText1" name="description" value="{{old('description')}}">
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-5">
                                <div class="form-group  @error('attachment') has-error @enderror">
                                    <label class="form-label" for="attachment">عکس دسته بندی</label>
                                    <input id="attachment-2" name="attachment" type="file" class="form-control"  data-show-upload="false" data-show-caption="true">
                                    @error('attachment')<span class="help-block">{{$message}}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-5">
                                <div class="form-check form-switch mb-2">
                                    <input type="checkbox" style="cursor: pointer;" class="form-check-input"
                                    id="formSwitch" name="status"
                                           value="active">
                                    <label class="form-check-label" for="formSwitch1">وضعیت نمایش</label>
                                </div>
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
