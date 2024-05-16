@extends('admin.layouts.app')
@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">

                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
        </div><!-- dashboard-w1 end -->


        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="" icon="la la-check" title="Approved Exchanges" value="" color="success" icon_style="solid" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="" icon="la la-reply" title="Refunded Exchanges" value="" color="dark" icon_style="solid" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="2" link="" icon="la la-reply" title="Canceled Exchanges" value="" color="danger" icon_style="solid" />
        </div>

    </div>



    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>

@endpush
@push('style')
    <style>
        .reserved-currency-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .bg--succes-2 {
            background: #176c3d !important;
        }

        .bg--warning-2 {
            background: #ca701afa !important
        }

        .bg--danger-2 {
            background: #b4170bd9 !important;
        }
    </style>
@endpush
