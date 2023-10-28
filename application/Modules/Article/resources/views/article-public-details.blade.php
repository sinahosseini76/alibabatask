@extends('Core::layout.master-public')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6" style="text-align: left; padding-left: 50px;"><a class="btn btn-secondary mb-5" style="text-align: left;" href="{{route('article.public.index')}}">بازگشت</a></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <div class="card mb-5" style="border-radius: 15px">
                <div class="card-body">
                    <h4 class="card-title">{{$article->title_fa}}</h4>
                    <h4 class="card-title" style="text-align: left">{{$article->title}}</h4>
                    <h5 class="card-subtitle mb-2 text-muted mt-1" style="text-align: right">دسته بندی : <span class="badge bg-info">{{$article->category->name}}</span></h5>
                    <hr>
                    <div class="row mb-5">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <img src="{{$article->attachment ?? asset('assets/images/sample.jpg')}}" alt="" style="width:100%; max-height: 350px; border-radius: 15px; text-align: center;">
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <p class="card-text mb-5">
                        {{$article->body_fa}}
                    </p>
                    <p class="card-text mb-5" style="text-align: left">
                        {{$article->body}}
                    </p>
                    <hr>
                    <h6 class="card-subtitle mb-2 text-muted mt-1" style="text-align: left">{{jdate($article->publish_at)->format('%A, %d %B %Y')}}</h6>
                    <h5 class="card-subtitle mb-2 text-muted mt-1" style="text-align: left">نویسنده : <span class="badge bg-warning">{{$article->author_name}}</span></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{route('article.public.show', ['article' => $article])}}" class="btn btn-primary">ادامه مطلب</a>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-subtitle text-muted mt-3" style="text-align: left">بازدید : <span class="badge bg-success">{{$article->view}}</span></h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection



