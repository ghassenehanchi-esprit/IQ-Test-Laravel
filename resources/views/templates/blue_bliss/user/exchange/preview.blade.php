@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row gy-4">
                    <div class="col-12">
                        <div class="card custom--card">
                            <div class="card-body">
                                <h6 class="text-center"> @lang('Exchange ID: ') <span class="text-muted">#{{ $exchange->exchange_id }}</span></h6>
                                <p class="mt-1 fw-bold text-center text--warning">
                                    @lang('Send') {{ showAmount($exchange->sending_amount + $exchange->sending_charge) }} {{ __(ucfirst(@$exchange->sendCurrency->cur_sym)) }} @lang('via') {{ __(@$exchange->sendCurrency->name) }} @lang('to get') {{ showAmount($exchange->receiving_amount - $exchange->receiving_charge) }} {{ __(ucfirst(@$exchange->receivedCurrency->cur_sym)) }} @lang('via') {{ __(@$exchange->receivedCurrency->name) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card custom--card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Sending Details')</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush p-3">
                                    <li class="list-group-item d-flex justify-content-between flex-column flex-wrap border-dotted">
                                        <span class="fw-bold">{{ __(@$exchange->sendCurrency->name) }}-{{ __(ucfirst(@$exchange->sendCurrency->cur_sym)) }}</span>
                                        <small class="text-muted">@lang('Sending Method')</small>
                                    </li>





                                    <li class="list-group-item d-flex justify-content-between flex-column flex-wrap border-dotted">
                                        <span class="fw-bold text--danger">
                                            {{ showAmount(@$exchange->sending_charge) }} {{ __(ucfirst(@$exchange->sendCurrency->cur_sym)) }}
                                        </span>
                                        <small class="text-muted">@lang('Charge')</small>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between flex-column flex-wrap border-dotted">
                                        <span class="fw-bold">
                                            {{ showAmount($exchange->sending_amount + $exchange->sending_charge) }} {{ __(ucfirst(@$exchange->sendCurrency->cur_sym)) }}
                                        </span>
                                        <small class="text-muted">@lang('Total Sending Amount Including Charge')</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card custom--card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Receiving Details')</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush p-3">
                                    <li class="list-group-item d-flex justify-content-between flex-column flex-wrap border-dotted">
                                        <span class="fw-bold">{{ __(@$exchange->receivedCurrency->name) }}~{{ __(ucfirst(@$exchange->receivedCurrency->cur_sym)) }}</span>
                                        <small class="text-muted">@lang('Receiving Method')</small>
                                    </li>




                                    <li class="list-group-item d-flex justify-content-between flex-column flex-wrap border-dotted">
                                        <span class="fw-bold text--danger">
                                            {{ showAmount(@$exchange->receiving_charge) }} {{ __(ucfirst(@$exchange->receivedCurrency->cur_sym)) }}
                                        </span>
                                        <small class="text-muted">@lang('Charge')</small>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between flex-column flex-wrap border-dotted">
                                        <span class="fw-bold">
                                            {{ showAmount($exchange->receiving_amount - $exchange->receiving_charge) }} {{ __(ucfirst(@$exchange->receivedCurrency->cur_sym)) }}
                                        </span>
                                        <small class="text-muted">@lang('Receivable Amount After Charge')</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card custom--card">
                            <div class="card-body">
                                <form method="post" action="{{ route('user.exchange.confirm') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label required" for="paytm_wallet">{{ __(@$exchange->receivedCurrency->name) }}
                                            @lang('Wallet Number/ID')</label>
                                        <input type="text" class="form-control form--control" name="wallet_id" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Country')</label>
                                            <select name="country" class="form-control form--control" required>
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Mobile')</label>
                                            <div class="input-group">
                                                <span class="input-group-text mobile-code border-0"></span>
                                                <input type="hidden" name="mobile_code">
                                                <input type="hidden" name="country_code">
                                                <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                                            </div>
                                            <small class="text--danger mobileExist"></small>
                                        </div>
                                    </div>

                                    <x-viser-form identifier="id" identifierValue="{{ @$exchange->receivedCurrency->userDetailsData->id }}" />

                                    <button class="btn btn--base w-100 confirmationBtn" type="submit">
                                        @lang('Confirm Exchange')
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
            $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }

                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .content-area {
            z-index: -1;
            height: 100%;
        }

        .btn-outline-linkedin {
            border-color: #0077B5;
            background-color: transparent;
            color: #0077B5;
        }

        .btn-outline-linkedin:hover {
            border-color: #0077B5;
            color: #fff !important;
            background-color: #0077B5;
        }

        .btn-outline-facebook {
            border-color: #395498;
            background-color: transparent;
            color: #395498;
        }

        .btn-outline-facebook:hover {
            border-color: #395498;
            color: #fff !important;
            background-color: #395498;
        }

        .btn-outline-google {
            border-color: #D64937;
            background-color: transparent;
            color: #D64937;
        }

        .btn-outline-google:hover {
            border-color: #D64937;
            color: #fff !important;
            background-color: #D64937;
        }

        .row>* {
            padding-right: calc(var(--bs-gutter-x) * .0);
        }

        .other-option {
            margin: 25px 0 25px;
            position: relative;
            text-align: center;
            z-index: 1;
        }
        .other-option::before {
            position: absolute;
            content: "";
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            z-index: -1;
            background: #e1e1e1;
        }
        .other-option__text {
            background-color: #f1f5f7;
            color: var(--dark-bg);
            display: inline-block;
            padding:0px 12px;
        }
    </style>
@endpush
