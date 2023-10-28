@extends('Core::layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="col-md-12 grid-margin stretch-card">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-3">
                          <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-success mr-2"></div>
                              <p class="mb-0">تعداد ادمین ها</p>
                          </div>
                          <h4 class="font-weight-semibold">{{$adminsCount}}</h4>
                          <div class="progress progress-md">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-primary mr-2"></div>
                              <p class="mb-0">تعداد دسته بندی ها</p>
                          </div>
                          <h4 class="font-weight-semibold">{{$categoriesCount}}</h4>
                          <div class="progress progress-md">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-warning mr-2"></div>
                              <p class="mb-0">تعداد مقاله ها</p>
                          </div>
                          <h4 class="font-weight-semibold">{{$articlesCount}}</h4>
                          <div class="progress progress-md">
                              <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                                <p class="mb-0">تعداد بازدید ها</p>
                            </div>
                            <h4 class="font-weight-semibold">{{$viewsCount}}</h4>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                  <br>
                </div>
            </div>
        </div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
@endpush
