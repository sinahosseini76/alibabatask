@extends('Core::layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
{{--          <div class="col-md-4 pe-md-0">--}}
{{--            <div class="auth-side-wrapper" style="background-image: url({{ asset('assets/images/Logo.svg')}});background-size: contain;background-repeat: no-repeat;" >--}}

{{--            </div>--}}
{{--          </div>--}}
          <div class="col-md-12 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
                <div style="text-align: center;">
                    <img class="mb-5" src="{{asset('assets/images/Logo.svg')}}" width="250px"/>
                </div>
{{--              <a href="#" class="noble-ui-logo d-block mb-2">Article<span> Alibaba</span></a>--}}
              <h5 class="text-muted fw-normal mb-4" style="text-align: center">خوش آمدید! پنل ادمین</h5>
              <form class="forms-sample" action="{{route('adminLoginPost')}}" method="POST">
                  @csrf

                <div class="mb-3">
                  <label for="userEmail" class="form-label">نام کاربری</label>
                  <input type="text" class="form-control" id="username" name="username" value="{{old('username') }}" placeholder="نام کاربری">
{{--                    @if ($errors->has('email'))--}}
{{--                        <span class="help-block font-red-mint">--}}
{{--                                <strong>{{ $errors->first('email') }}</strong>--}}
{{--                            </span>--}}
{{--                    @endif--}}
                </div>
                <div class="mb-6">
                  <label for="userPassword" class="form-label">پسورد</label>
                  <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="پسورد">

                    {{--                    @if ($errors->has('password'))--}}
{{--                        <span class="help-block font-red-mint">--}}
{{--                                <strong>{{ $errors->first('password') }}</strong>--}}
{{--                            </span>--}}
{{--                    @endif--}}
                </div>

                <div style="text-align: center;">
                  <button  type="submit" class="btn btn-primary me-2 mb-2 mb-md-0" style="width: 250px;">ورود</button>
{{--                  <a type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0" href="{{route('adminLoginOtp')}}">--}}
{{--                    <i class="btn-icon-prepend" data-feather="log-in"></i>--}}
{{--                    ورود با رمز یکبار مصرف--}}
{{--                  </a>--}}
                </div>
{{--                <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>--}}
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
