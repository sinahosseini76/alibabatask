@extends('Core::layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-color: #01899f; background-image: url({{ asset('assets/images/Logo.jpg')}});background-size: contain;background-repeat: no-repeat;" >

            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2">Article<span> Alibaba</span></a>
              <h5 class="text-muted fw-normal mb-4">خوش آمدید! پنل ادمین</h5>


                <div class="mb-3" id="phone">
                  <label for="userEmail" class="form-label">شماره تماس</label>
                  <input type="text" class="form-control" id="phoneInput" name="phone" value="{{old('phone') }}" placeholder="شماره تماس">

                    {{--                    @if ($errors->has('email'))--}}
{{--                        <span class="help-block font-red-mint">--}}
{{--                                <strong>{{ $errors->first('email') }}</strong>--}}
{{--                            </span>--}}
{{--                    @endif--}}
                </div>


                <div class="mb-3" id="otpCode" style="display: none">
                    <label for="userEmail" class="form-label">کد دریافتی</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{old('code') }}" placeholder="کد دریافتی">
                </div>

                <div class="mb-3" id="counter" style="display: none">

                </div>

                <div>
                  <a  onclick="sendOtp()" id="send-otp" class="btn btn-primary me-2 mb-2 mb-md-0">ارسال کد یکبار مصرف</a>
                  <a  onclick="login()" id="login" class="btn btn-primary me-2 mb-2 mb-md-0" style="display: none;">ورود</a>
                  <a   class="btn btn-secondary me-2 mb-2 mb-md-0" href="{{route('adminLogin')}}">بازگشت</a>
{{--                  <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">--}}
{{--                    <i class="btn-icon-prepend" data-feather="twitter"></i>--}}
{{--                    Login with twitter--}}
{{--                  </button>--}}
                </div>
{{--                <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>--}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection


@push('plugin-scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function sendOtp(){

            var phone = $('#phoneInput').val();

            if(phone == ''){
                console.log(phone)
                Swal.fire({
                    icon: 'error',
                    title: 'شماره تماس را وارد کنید',
                    showConfirmButton: false,
                    timer: 1500
                })
                return false;
            }

            apiSendOtp(phone);


        }
        function apiSendOtp(phone) {
            $.ajax({
                url: '/admin/otp/',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_token': '{{csrf_token()}}',
                    '_method': 'POST',
                    'phone' : phone
                },
                success: function (data) {
                    // Success logic goes here..!

                    // disable send otp button
                    $('#send-otp').hide();
                    // $('#send-otp').attr('disabled', true).html( '<span class="">ارسال کد ...</span>' +
                    //     '<div class="spinner-border spinner-border-sm" role="status">\n' +
                    //     '  <span class="visually-hidden"></span>\n' +
                    //     '</div>'
                    // );

                    // hide id="phone" input
                    $('#phone').hide();
                    $('#otpCode').show();

                    // show counter and start counter under phone input
                    $('#counter').show();

                    //show counter and start counter under phone input
                    var timeleft = 2;
                    var downloadTimer = setInterval(function(){
                        if(timeleft <= 0){
                            clearInterval(downloadTimer);
                            $('#counter').html('');
                            $('#otpCode').hide();
                            $('#phone').show();
                            $('#send-otp').show();
                            // $('#send-otp').attr('disabled', false).html('ارسال کد یکبار مصرف');
                        } else {
                            $('#counter').html('<span>ارسال مجدد کد: </span>' + timeleft + ' <span>ثانیه</span>');
                        }
                        timeleft -= 1;
                    }, 1000);
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })

                    // setTimeout(function () {
                    //     location.reload();
                    // }, 1500);
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: error.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    // //
                    // setTimeout(function () {
                    //     location.reload();
                    // }, 1500);
                }
            });
        }
    </script>
@endpush
