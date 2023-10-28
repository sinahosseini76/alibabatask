@extends('layout.master')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">مقاله ها</a></li>
            <li class="breadcrumb-item active" aria-current="page">ویرایش مقاله</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6" style="text-align: left; padding-left: 50px;"><a class="btn btn-secondary mb-5" style="text-align: left;" href="{{route('article.index')}}">بازگشت</a></div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{--        <h6 class="card-title">Inputs</h6>--}}
                    <form action="{{route('article.update', ['article' => $article])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام فارسی</label>
                                <input type="text" class="form-control @error('title_fa') is-invalid @enderror" id="exampleInputText1" name="title_fa"
                                       value="{{$article->title_fa}}" >
                                @error('title_fa')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-5">
                                <label for="exampleInputText1" class="form-label">نام انگلیسی</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputText1" name="title"
                                       value="{{$article->title}}" >
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-5">
                                <label for="exampleInputText1" class="form-label">وضعیت</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option value="">انتخاب کنید</option>
                                    @foreach(\Modules\Article\Models\Article::STATUS as $status)
                                        @php
                                            switch ($status){
                                                case \Modules\Article\Models\Article::STATUS_PENDING:
                                                    $status_fa = 'در انتظار تایید';
                                                    break;
                                                case \Modules\Article\Models\Article::STATUS_PUBLISHED:
                                                    $status_fa = 'منتشر شده';
                                                    break;
                                                case \Modules\Article\Models\Article::STATUS_DRAFT:
                                                    $status_fa = 'پیش نویس';
                                                    break;
                                            }
                                        @endphp
                                        <option value="{{$status}}" @if($article->status == $status) selected @endif>{{$status_fa}}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-5">
                                <label for="exampleInputText1" class="form-label">دسته بندی</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($article->category->id == $category->id) selected @endif>{{$category->name}} ({{$category->name_fa}})</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <label for="exampleInputText1" class="form-label">توضیحات فارسی</label>
                                <textarea type="text" class="form-control @error('body_fa') is-invalid @enderror" id="exampleInputText1" name="body_fa" rows="8">{{$article->body_fa}}</textarea>
                                @error('body_fa')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-5">
                                <label for="exampleInputText1" class="form-label">توضیحات انگلیسی</label>
                                <textarea type="text" class="form-control @error('body') is-invalid @enderror" id="exampleInputText1" name="body" rows="8">{{$article->body}}</textarea>
                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-5">
                                <label for="exampleInputText1" class="form-label">نام مستعار نویسنده</label>
                                <input type="text" class="form-control @error('author_name') is-invalid @enderror" id="exampleInputText1" name="author_name"
                                       value="{{$article->author_name}}" >
                                @error('author_name')
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-5">
                                <label for="exampleInputText1" class="form-label">تاریخ انتشار</label>
                                <input type="date" class="form-control @error('publish_at') is-invalid @enderror" id="exampleInputText1" name="publish_at"
                                       value="{{\Carbon\Carbon::make($article->publish_at)->toDateString()}}" >
                                @error('publish_at')
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
