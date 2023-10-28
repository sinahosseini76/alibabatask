
@push('plugin-styles')
    <link href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css"  rel="stylesheet" />
@endpush
@push('plugin-scripts')
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
             var pd = $(".from").persianDatepicker({
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                },
                 autoClose: true,
                 initialValue: false,
                 format: 'YYYY/MM/DD HH:mm:ss',

             });
            $(".to").persianDatepicker({
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                },
                autoClose: true,
                initialValue: false,
                format: 'YYYY/MM/DD HH:mm:ss',

            });
        });
    </script>
@endpush



<div class="col-12">
    <a class="btn btn-primary btn-icon-text mb-2"  data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
        فیلتر
        <i class="btn-icon-append" data-feather="filter"></i>
    </a>
</div>
<div class="collapse @if(parse_url(url()->full(), PHP_URL_QUERY)) show @endif mb-5" id="collapseFilter">
    <div class="card card-body">
        <form action="{{route(Route::getCurrentRoute()->action['as'])}}">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="filter">جستجو</label>
                        <input type="text" class="form-control" id="filter" name="filter" placeholder="جستجو" value="{{ request()->filter }}">
                    </div>
                </div>
                @if(isset($statuses) && count($statuses) > 0)
                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="filter">وضعیت</label>
                        <select class="form-control" name="filter_status_id">
                            <option class="m-1" value="">همه</option>
                            @foreach($statuses as $status)
                                <option class="m-1"
                                        style="background-color: {{$status->background_color}}; color: {{$status->color}}; border-radius: 25px; padding: 5px; margin: 10px; font-size: 12px;"
                                        @if(request()->filter_status_id == $status->id) selected @endif
                                        value="{{$status->id}}">{{$status->label}}
                                </option>
                                <hr>
                            @endforeach
                        </select>
{{--                        <input type="text" class="form-control" id="status_id" name="status_id" placeholder="وضعیت" value="{{ request()->status_id }}">--}}
                    </div>
                </div>
                @endif
                @if(isset($departments) && count($departments) > 0)
                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="filter">دپارتمان</label>
                        <select class="form-control" name="filter_department_id">
                            <option class="m-1" value="0">همه</option>
                            @foreach($departments as $department)
                                @php
                                    $type = $department->type == \Modules\Ticket\Models\Department::TYPE_INTERNAL ? 'داخلی' : 'خارجی';
                                @endphp
                                <option class="m-1"
                                        @if(request()->filter_department_id == $department->id) selected @endif
                                        value="{{$department->id}}">{{$department->title}}
                                    ({{$type}})
                                </option>
                                <hr>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
                @if(isset($staffs) && count($staffs) > 0)
                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="filter">کارشناس</label>
                        <select class="form-control" name="filter_admin_id">
                            <option class="m-1" value="0">همه</option>
                            <option class="m-1" value="unknown" @if(request()->filter_admin_id == 'unknown') selected @endif>نامشخص</option>
                            @foreach($staffs as $staff)
                                <option class="m-1"
                                        @if(request()->filter_admin_id == $staff->id) selected @endif
                                        value="{{$staff->id}}">{{$staff->first_name}} {{$staff->last_name}}
                                    | {{$staff->username}}
                                </option>
                                <hr>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
                @if(isset($status_codes) && count($status_codes) > 0)
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="status_code">وضعیت</label>
                            <select class="form-control" name="status_code">
                                <option class="m-1" value="0">همه</option>
                                @foreach($status_codes as $status_code)
                                    <option class="m-1"
                                            @if(request()->status_code == $status_code) selected @endif
                                            value="{{$status_code}}">{{$status_code}}
                                    </option>
                                    <hr>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                @if(isset($from))
                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="from">از تاریخ</label>
                        <input type="text" class="form-control from" id="from" name="from" placeholder="از تاریخ" autocomplete="off" value="{{old('from') ?? request()->from}}">
                    </div>
                </div>
                @endif
                @if(isset($to))
                <div class="col-md-3 mb-2">
                    <div class="form-group">
                        <label for="from">تا تاریخ</label>
                        <input type="text" class="form-control to" id="to" name="to" placeholder="تا تاریخ" autocomplete="off" value="{{old('to') ?? request()->to}}">
                    </div>
                </div>
                @endif

                @if(isset($actions) && count($actions) > 0)
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="action">عملکرد</label>
                            <select class="form-control" name="action">
                                <option class="m-1" value="0">همه</option>
                                @foreach($actions as $action)
                                    <option class="m-1"
                                            @if(request()->action == $action) selected @endif
                                            value="{{$action}}">{{$action}}
                                    </option>
                                    <hr>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                @if(isset($paymentStatus) && count($paymentStatus) > 0)
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="action">وضعیت پرداخت</label>
                            <select class="form-control" name="status">
                                <option class="m-1" value="0">همه</option>
                                @foreach($paymentStatus as $status)
                                    @if($status == \Modules\Payment\Models\Transaction::STATUS_SUCCESS)
                                        <option class="m-1"
                                                @if(request()->status == $status) selected @endif
                                                value="{{$status}}">پرداخت موفق
                                        </option>
                                    @elseif($status == \Modules\Payment\Models\Transaction::STATUS_FAILED)
                                        <option class="m-1"
                                                @if(request()->status == $status) selected @endif
                                                value="{{$status}}">پرداخت نا موفق
                                        </option>
                                    @else
                                        <option class="m-1"
                                                @if(request()->status == $status) selected @endif
                                                value="{{$status}}">در انتظار پرداخت
                                        </option>
                                    @endif
                                    <hr>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif()
                @if(isset($paymentType) && count($paymentType) > 0)
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            <label for="action">نوع پرداخت</label>
                            <select class="form-control" name="type">
                                <option class="m-1" value="0">همه</option>
                                @foreach($paymentType as $type)
                                    @if($type == \Modules\Payment\Models\Transaction::TYPE_ORDER)
                                        <option class="m-1"
                                                @if(request()->type == $type) selected @endif
                                                value="{{$type}}">ثبت سفارش
                                        </option>
                                    @elseif($type == \Modules\Payment\Models\Transaction::TYPE_INCREASE_WALLET)
                                        <option class="m-1"
                                                    @if(request()->type == $type) selected @endif
                                                value="{{$type}}">افزایش اعتبار کیف پول
                                        </option>
                                    @else
                                        <option class="m-1"
                                                @if(request()->type == $status) selected @endif
                                                value="{{$status}}">کاهش اعتبار کیف پول
                                        </option>
                                    @endif
                                    <hr>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif()
                <div class="col-md-12 mt-5">
                    <div class="form-group" style="text-align: center">
                        <button type="submit" class="btn btn-primary" style="width: 10%; text-align: center">جستجو</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>





