@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kyc = getContent('kyc_content.content', true);
    @endphp
    <div class="container">
        <div class="row justify-content-center gy-4">
            @if ($user->kv == 0)
                <div class="col-12">
                    <div class="alert alert-danger mb-0" role="alert">
                        <h6 class="alert-heading">@lang('KYC Verification')</h6>
                        <p class="py-2">
                            {{ __(@$kyc->data_values->pending_content) }}
                            <a href="{{ route('user.kyc.form') }}" class="fw-bold">@lang('Click here to verify')</a>
                        </p>
                    </div>
                </div>
            @endif
            @if ($user->kv == 2)
                <div class="col-12">
                    <div class="alert alert--warning mb-0" role="alert">
                        <h6 class="alert-heading">@lang('KYC Verification Pending')</h6>
                        <p class="py-2">
                            {{ __(@$kyc->data_values->pending_content) }}
                            <a href="{{ route('user.kyc.data') }}" class="text--base fw-bold">@lang('See KYC Data')</a>
                        </p>
                    </div>
                </div>
            @endif

            @if ($user->kv == 1)
            <div class="col-lg-12">
                <div class="user-exchange">
                    <div class="currency-converter w-100">
                            
                            <div class="custom-widget mb-4">
                                 <form action="{{ route('user.exchange.start') }}" method="POST" id="exchange-form">
                                        @csrf
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div>
                                                    <h6 class="banner__widget-title mb-3 mt-0">@lang('You Send')</h6>
                                                    <div class="form-group mb-3">
                                                        <div class="select-item">
                                                            <select required class="select2 form-control form--control currency-picker" data-type="select"
                                                                name="sending_currency" id="send">
                                                                <option value="" selected disabled>@lang('Select One')</option>
    <optgroup label="Paiement Mobile">
        @foreach ($sellCurrencies as $sellCurrency)
            @php
                $currencyName = strtolower($sellCurrency->name);
                $category = null;
                // Classify the currency based on category
                if (strpos($currencyName, 'mtn ') !== false || strpos($currencyName, 'mtn ci') !== false || strpos($currencyName, 'moov ') !== false || strpos($currencyName, 'moov togo') !== false || strpos($currencyName, 'orange money ci') !== false || strpos($currencyName, 'wave ci') !== false || strpos($currencyName, 'wave senegal') !== false) {
                    $category = 'Paiement Mobile';
                }
            @endphp
            @if ($category === 'Paiement Mobile')
                <option
                    data-image="{{ getImage(getFilePath('currency') . '/' . @$sellCurrency->image, getFileSize('currency')) }}"
                    data-min="{{ getAmount($sellCurrency->minimum_limit_for_buy) }}"
                    data-max="{{ getAmount($sellCurrency->maximum_limit_for_buy) }}"
                    data-buy="{{ getAmount($sellCurrency->buy_at) }}"
                    data-currency="{{ @$sellCurrency->cur_sym }}"
                    value="{{ $sellCurrency->id }}"
                    data-select-for="send"
                    @selected(old('sending_currency') == $sellCurrency->id || @$exchangeFormData['sending_currency'] == $sellCurrency->id)>
                    {{ __($sellCurrency->name) }} - {{ __($sellCurrency->cur_sym) }}
                </option>
            @endif
        @endforeach
    </optgroup>

    <optgroup label="Paiement Electronique">
        @foreach ($sellCurrencies as $sellCurrency)
            @php
                $currencyName = strtolower($sellCurrency->name);
                $category = null;
                // Classify the currency based on category
                if (strpos($currencyName, 'payeer usd') !== false || strpos($currencyName, 'payeer eur') !== false || strpos($currencyName, 'perfect money') !== false || strpos($currencyName, 'perfect money') !== false) {
                    $category = 'Paiement Electronique';
                }
            @endphp
            @if ($category === 'Paiement Electronique')
                <option
                    data-image="{{ getImage(getFilePath('currency') . '/' . @$sellCurrency->image, getFileSize('currency')) }}"
                    data-min="{{ getAmount($sellCurrency->minimum_limit_for_buy) }}"
                    data-max="{{ getAmount($sellCurrency->maximum_limit_for_buy) }}"
                    data-buy="{{ getAmount($sellCurrency->buy_at) }}"
                    data-currency="{{ @$sellCurrency->cur_sym }}"
                    value="{{ $sellCurrency->id }}"
                    data-select-for="send"
                    @selected(old('sending_currency') == $sellCurrency->id || @$exchangeFormData['sending_currency'] == $sellCurrency->id)>
                    {{ __($sellCurrency->name) }} - {{ __($sellCurrency->cur_sym) }}
                </option>
            @endif
        @endforeach
    </optgroup>

    <optgroup label="Cryptomonnaies">
        @foreach ($sellCurrencies as $sellCurrency)
            @php
                $currencyName = strtolower($sellCurrency->name);
                $category = null;
                // Classify the currency based on category
                if (strpos($currencyName, 'bitcoin') !== false || strpos($currencyName, 'ethereum') !== false || strpos($currencyName, 'bitcoin cash') !== false || strpos($currencyName, 'tron') !== false || strpos($currencyName, 'usdt') !== false || strpos($currencyName, 'usdt') !== false || strpos($currencyName, 'bnb') !== false || strpos($currencyName, 'shiba inu') !== false || strpos($currencyName, 'dogecoin') !== false || strpos($currencyName, 'solana') !== false || strpos($currencyName, 'waves') !== false) {
                    $category = 'Cryptomonnaies';
                }
            @endphp
            @if ($category === 'Cryptomonnaies')
                <option
                    data-image="{{ getImage(getFilePath('currency') . '/' . @$sellCurrency->image, getFileSize('currency')) }}"
                    data-min="{{ getAmount($sellCurrency->minimum_limit_for_buy) }}"
                    data-max="{{ getAmount($sellCurrency->maximum_limit_for_buy) }}"
                    data-buy="{{ getAmount($sellCurrency->buy_at) }}"
                    data-currency="{{ @$sellCurrency->cur_sym }}"
                    value="{{ $sellCurrency->id }}"
                    data-select-for="send"
                    @selected(old('sending_currency') == $sellCurrency->id || @$exchangeFormData['sending_currency'] == $sellCurrency->id)>
                    {{ __($sellCurrency->name) }} - {{ __($sellCurrency->cur_sym) }}
                </option>
            @endif
        @endforeach
    </optgroup>
</select>


                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="" class="form-label fw-medium">@lang('Send Amount')</label>
                                                        <div class="input-group">
                                                            <input type="number" step="any" class="form-control form--control rounded"
                                                                name="sending_amount" id="sending_amount" value="{{old('sending_amount') }}"  placeholder="0.00" required>
                                                            <span class="input-group-text d-none bg--base text-white border-0"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rate--txt d-none">
                                                        <div>
                                                            <span>@lang('Limit:')</span>
                                                            <span class="limit-exchange">
                                                                <span class="text--base"></span>
                                                                <span class="currency_name"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                    <h6 class="mb-3 mt-0">@lang('You Get')</h6>
                                                    <div class="form-group mb-3" id="receiving-currency-wrapper">
                                                        <div class="select-item ">
                                                        <select class="select2 form-control form--control currency-picker" name="receiving_currency" id="receive" required value.bind="selectedThing2">
    <option value="" selected disabled>@lang('Select One')</option>
    
    <optgroup label="Paiement Mobile">
        @foreach ($buyCurrencies as $buyCurrency)
            @php
                $currencyName = strtolower($buyCurrency->name);
                $category = null;
                // Classify the currency based on category
                if (strpos($currencyName, 'mtn ') !== false || strpos($currencyName, 'mtn ci') !== false || strpos($currencyName, 'moov ') !== false || strpos($currencyName, 'moov togo') !== false || strpos($currencyName, 'orange money ci') !== false || strpos($currencyName, 'wave ci') !== false || strpos($currencyName, 'wave senegal') !== false) {
                    $category = 'Paiement Mobile';
                }
            @endphp
            @if ($category === 'Paiement Mobile')
                <option
                    data-image="{{ getImage(getFilePath('currency') . '/' . @$buyCurrency->image, getFileSize('currency')) }}"
                    data-sell="{{ getAmount($buyCurrency->sell_at) }}"
                    data-currency="{{ @$buyCurrency->cur_sym }}"
                    data-min="{{ getAmount($buyCurrency->minimum_limit_for_sell) }}"
                    data-max="{{ getAmount($buyCurrency->maximum_limit_for_sell) }}"
                    data-reserve="{{ getAmount($buyCurrency->reserve) }}"
                    value="{{ $buyCurrency->id }}"
                    data-select-for="received"
                    @selected(old('receiving_currency') == $buyCurrency->id || @$exchangeFormData['receiving_currency'] == $buyCurrency->id)>
                    {{ __($buyCurrency->name) }} - {{ __($buyCurrency->cur_sym) }}
                </option>
            @endif
        @endforeach
    </optgroup>

    <optgroup label="Paiement Electronique">
        @foreach ($buyCurrencies as $buyCurrency)
            @php
                $currencyName = strtolower($buyCurrency->name);
                $category = null;
                // Classify the currency based on category
                if (strpos($currencyName, 'payeer usd') !== false || strpos($currencyName, 'payeer eur') !== false || strpos($currencyName, 'perfect money') !== false || strpos($currencyName, 'perfect money') !== false) {
                    $category = 'Paiement Electronique';
                }
            @endphp
            @if ($category === 'Paiement Electronique')
                <option
                    data-image="{{ getImage(getFilePath('currency') . '/' . @$buyCurrency->image, getFileSize('currency')) }}"
                    data-sell="{{ getAmount($buyCurrency->sell_at) }}"
                    data-currency="{{ @$buyCurrency->cur_sym }}"
                    data-min="{{ getAmount($buyCurrency->minimum_limit_for_sell) }}"
                    data-max="{{ getAmount($buyCurrency->maximum_limit_for_sell) }}"
                    data-reserve="{{ getAmount($buyCurrency->reserve) }}"
                    value="{{ $buyCurrency->id }}"
                    data-select-for="received"
                    @selected(old('receiving_currency') == $buyCurrency->id || @$exchangeFormData['receiving_currency'] == $buyCurrency->id)>
                    {{ __($buyCurrency->name) }} - {{ __($buyCurrency->cur_sym) }}
                </option>
            @endif
        @endforeach
    </optgroup>

    <optgroup label="Cryptomonnaies">
        @foreach ($buyCurrencies as $buyCurrency)
            @php
                $currencyName = strtolower($buyCurrency->name);
                $category = null;
                // Classify the currency based on category
                if (strpos($currencyName, 'bitcoin') !== false || strpos($currencyName, 'ethereum') !== false || strpos($currencyName, 'bitcoin cash') !== false || strpos($currencyName, 'tron') !== false || strpos($currencyName, 'usdt') !== false || strpos($currencyName, 'usdt') !== false || strpos($currencyName, 'bnb') !== false || strpos($currencyName, 'shiba inu') !== false || strpos($currencyName, 'dogecoin') !== false || strpos($currencyName, 'solana') !== false || strpos($currencyName, 'waves') !== false) {
                    $category = 'Cryptomonnaies';
                }
            @endphp
            @if ($category === 'Cryptomonnaies')
                <option
                    data-image="{{ getImage(getFilePath('currency') . '/' . @$buyCurrency->image, getFileSize('currency')) }}"
                    data-sell="{{ getAmount($buyCurrency->sell_at) }}"
                    data-currency="{{ @$buyCurrency->cur_sym }}"
                    data-min="{{ getAmount($buyCurrency->minimum_limit_for_sell) }}"
                    data-max="{{ getAmount($buyCurrency->maximum_limit_for_sell) }}"
                    data-reserve="{{ getAmount($buyCurrency->reserve) }}"
                    value="{{ $buyCurrency->id }}"
                    data-select-for="received"
                    @selected(old('receiving_currency') == $buyCurrency->id || @$exchangeFormData['receiving_currency'] == $buyCurrency->id)>
                    {{ __($buyCurrency->name) }} - {{ __($buyCurrency->cur_sym) }}
                </option>
            @endif
        @endforeach
    </optgroup>
</select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="" class="form-label fw-medium">@lang('Get Amount')</label>
                                                        <div class="input-group">
                                                            <input type="number" step="any" class="form-control form--control rounded"  id="receiving_amount" name="receiving_amount"
                                                                value="{{ old('receiving_amount') }}"  placeholder="0.00" required>
                                                            <span class="input-group-text d-none bg--base text-white border-0"></span>
                                                        </div>
                                                    </div>
                                                    <div class="rate--txt-received d-none">
                                                        <div>
                                                            <span>@lang('Limit:')</span>
                                                            <span class="limit-received-exchange">
                                                                <span class="text--base"></span>
                                                                <span class="currency_name"></span>
                                                            </span>
                                                            <span>@lang('| Reserve:')</span>
                                                            <span class="reserve-amount">
                                                                <span class="text--base"></span>
                                                                <span class="currency_name"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <button class="btn btn--base " type="submit">
                                                    <span class="me-2"> <i class="las la-exchange-alt"></i></span>@lang('Exchange Now')
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            @endif


            <div class="col-xl-4 col-md-6">
                <div class="widget-item">
                    <div class="widget-item__icon"><i class="fas fa-sync"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Approved Exchange')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($exchange['approved']) }}</h4>
                        <a href="{{ route('user.exchange.list', 'approved') }}" class="btn--simple">
                            @lang('View All') <span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="widget-item">
                    <div class="widget-item__icon"><i class="fas fa-undo-alt"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Pending Exchange')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($exchange['pending']) }}</h4>
                        <a href="{{ route('user.exchange.list', 'pending') }}" class="btn--simple">@lang('View All')
                            <span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="widget-item">
                    <div class="widget-item__icon"><i class="fas fa-window-close"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Cancled Exchange')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($exchange['cancel']) }}</h4>
                        <a href="{{ route('user.exchange.list', 'canceled') }}" class="btn--simple">@lang('View All')
                            <span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="widget-item">
                    <div class="widget-item__icon"><i class="fas fa-sync-alt"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Refunded Exchange')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($exchange['refunded']) }}</h4>
                        <a href="{{ route('user.exchange.list', 'refunded') }}" class="btn--simple">@lang('View All')
                            <span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="widget-item">
                    <div class="widget-item__icon"><i class="fas fa-exchange-alt"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Total Exchange')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($exchange['total']) }}</h4>
                        <a href="{{ route('user.exchange.list', 'list') }}" class="btn--simple">@lang('View All')
                            <span class="icon text--base"> <i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="widget-item h-100">
                    <div class="widget-item__icon"><i class="fas fa-voicemail"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Answer Ticket')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($tickets['answer']) }}</h4>
                        <a href="{{ route('ticket.index') }}" class="btn--simple">
                            @lang('View All')<span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="widget-item">
                    <div class="widget-item__icon"><i class="fas fa-reply"></i></div>
                    <div class="widget-item__content">
                        <h5 class="widget-item__title">@lang('Reply Ticket')</h5>
                        <h4 class="widget-item__amount ">{{ getAmount($tickets['reapply']) }}</h4>
                        <a href="{{ route('ticket.index') }}" class="btn--simple">
                            @lang('View All') <span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col">
    <div class="widget-item">
        <div class="widget-item__icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="widget-item__content">
            <h5 class="widget-item__title">@lang('Your Balance')</h5>
            <h4 class="widget-item__amount ">{{ number_format($user->balance, 2) }} XOF</h4>
            <a href="{{ route('user.report.commission.log') }}" class="btn--simple">
                @lang('View All') <span class="icon text--base"><i class="fas fa-angle-double-right"></i></span>
            </a>
        </div>
    </div>
</div>


            <div class="col-12 mt-5">
                <h5 class="title mb-2">@lang('Your Latest Exchanges')</h5>
                <div class="card custom--card">
                    <div class="card-body p-0">
                        <table class="table custom--table table-responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Send')</th>
                                    <th>@lang('Received')</th>
                                    <th>@lang('Exchange ID')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestExchange as $exchange)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-start">
                                            <span class="thumb">
                                                <img class="table-currency-img" src="{{ getImage(getFilePath('currency') . '/' . @$exchange->sendCurrency->image, getFileSize('currency')) }}">
                                            </span>
                                            {{ $exchange->sendCurrency->name }}
                                        </td>

                                        <td class="text-start">
                                            <span class="thumb">
                                                <img src="{{ getImage(getFilePath('currency') . '/' . @$exchange->receivedCurrency->image, getFileSize('currency')) }}" class="table-currency-img">
                                            </span>
                                            <span>
                                                {{ __($exchange->receivedCurrency->name) }}
                                            </span>
                                        </td>
                                        <td>{{ @$exchange->exchange_id }}</td>
                                        <td>
                                            <div>
                                                {{ showAmount($exchange->sending_amount) }} {{ __(@$exchange->sendCurrency->cur_sym) }}
                                                <i class="la la-arrow-right text--base"></i>
                                                {{ showAmount($exchange->receiving_amount) }} {{ __(@$exchange->receivedCurrency->cur_sym) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="d-block">{{ showDateTime(@$exchange->created_at) }}</span>
                                            <span class="text--base">{{ diffForHumans(@$exchange->created_at) }}</span>
                                        </td>
                                        <td> @php echo $exchange->badgeData(); @endphp </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>  
@endpush

@push('script')
    <script>
            "use strict";
        (function($) {
            let sendId, sendMinAmount = 0, sendMaxAmount = 0, sendAmount = 0, sendCurrency, sendCurrencyBuyRate = 0;
            let receivedId, receivedAmount = 0, receivedCurrency, receiveCurrencySellRate = 0;
            
            @if (old('sending_currency') || @$exchangeFormData)
                sendAmount = "{{ old('sending_amount') ?? 0}}";
                @if(@$exchangeFormData['sending_amount'])
                    sendAmount = "{{ @$exchangeFormData['sending_amount'] ?? 0}}";
                @endif
                sendAmount = parseFloat(sendAmount);
                $("#sending_amount").val(sendAmount.toFixed("{{$general->show_number_after_decimal}}"));
                setTimeout(() => {
                    $('#send').trigger('change');
                });
            @endif

            @if (old('receiving_currency') || @$exchangeFormData)
                receivedAmount = "{{ old('receiving_amount')}}";
                @if(@$exchangeFormData['receiving_amount'])
                    receivedAmount = "{{ @$exchangeFormData['receiving_amount'] }}";
                @endif
                receivedAmount=parseFloat(receivedAmount);
                $("#receiving_amount").val(receivedAmount.toFixed("{{$general->show_number_after_decimal}}"));
                setTimeout(() => {
                    $('#receive').trigger('change');
                });
            @endif

            const formatValueWithFiveDecimals = (value) => {
                // Convert value to a floating-point number with a maximum of 5 decimal places
                const floatValue = parseFloat(value);
                // If floatValue is a valid number, round it to 5 decimal places, otherwise return the original value
                return isNaN(floatValue) ? '' : floatValue.toFixed(5);
            };

            const calculationReceivedAmount = () => {
                if (!sendId || !receivedId || !sendCurrencyBuyRate || !receiveCurrencySellRate) {
                    return false;
                }
                const amountReceived = (sendCurrencyBuyRate / receiveCurrencySellRate) * sendAmount;
                $("#receiving_amount").val(formatValueWithFiveDecimals(amountReceived));
            };

            const calculationSendAmount = () => {
                if (!sendId || !receivedId || !sendCurrencyBuyRate || !receiveCurrencySellRate) {
                    return false;
                }
                const amountReceived = (receiveCurrencySellRate / sendCurrencyBuyRate) * receivedAmount;
                $("#sending_amount").val(formatValueWithFiveDecimals(amountReceived));
            };


            
            

            //=============change select2 structure + color
            $('.currency-picker').select2({
                templateResult: formatState
            });

            function formatState(state) {
                if (!state.id) return state.text;
                let selectType=$(state.element).data('select-for').toUpperCase();

                if(sendId && selectType=='RECEIVED' && sendId==state.element.value ){
                    return false;
                }

                if(receivedId && selectType=='SEND' && receivedId==state.element.value ){
                    return false;
                }
                return $('<img class="ms-1"   src="' + $(state.element).data('image') + '"/> <span class="ms-3">' +
                    state.text + '</span>');
            }



            

            $('#send').on('change', function(e) {

                sendId = parseInt($(this).val());
                sendMinAmount = parseFloat($(this).find(':selected').data('min'));
                sendMaxAmount = parseFloat($(this).find(':selected').data('max'));
                sendCurrency = $(this).find(':selected').data('currency');
                sendCurrencyBuyRate = parseFloat($(this).find(':selected').data('buy'));

                $('.limit-exchange').find('.text--base').text(
                    `${sendMinAmount.toFixed(2)}- ${sendMaxAmount.toFixed(2)}`);
                $('.limit-exchange').find('.currency_name').text(sendCurrency);
                $('.rate--txt').removeClass('d-none');

                $("#sending_amount").siblings('.input-group-text').removeClass('d-none');
                $("#sending_amount").removeClass('rounded');
                $("#sending_amount").siblings('.input-group-text').text(sendCurrency);

                $(this).closest('.form-group').find('.select2-selection__rendered').html(
                    `
               <img src="${$(this).find(':selected').data('image')}" class="currency-image"/> ${$(this).find(':selected').text()}`
                )

                calculationReceivedAmount();
            });

            $('#receive').on('change', function(e) {

                receivedId = parseInt($(this).val());
                receiveCurrencySellRate = parseFloat($(this).find(':selected').data('sell'));
                receivedCurrency = $(this).find(':selected').data('currency');

                let minAmount = parseFloat($(this).find(':selected').data('min'));
                let maxAmount = parseFloat($(this).find(':selected').data('max'));
                let reserveAmount = parseFloat($(this).find(':selected').data('reserve'))

                $('.limit-received-exchange').find('.text--base').text(
                    `${minAmount.toFixed(2)}- ${maxAmount.toFixed(2)}`);
                $('.reserve-amount').find('.text--base').text(`${reserveAmount.toFixed(2)}`);
                $('.limit-received-exchange').find('.currency_name').text(receivedCurrency);
                $('.reserve-amount').find('.currency_name').text(receivedCurrency);
                $('.rate--txt-received').removeClass('d-none');



                $("#receiving_amount").siblings('.input-group-text').removeClass('d-none');
                $("#receiving_amount").removeClass('rounded');
                $("#receiving_amount").siblings('.input-group-text').text(receivedCurrency);

                $(this).closest('.form-group').find('.select2-selection__rendered').html(
                    `<img src="${$(this).find(':selected').data('image')}" class="currency-image"/> ${$(this).find(':selected').text()}`
                    )
                calculationReceivedAmount();
            });

            $('#sending_amount').on('input', function(e) {
                sendAmount = parseFloat(this.value);
                calculationReceivedAmount();
            });

            $('#receiving_amount').on('input', function(e) {
                receivedAmount = parseFloat(this.value);
                calculationSendAmount();
            });

           
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .select2-container .select2-selection--single {
            height: 46px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
        }

        .select2-container--default img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .select2-results__option--selectable {
            display: flex;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 80%;
        }

        img.currency-image {
            width: 25px;
            height: 25px;
            margin-right: 8px;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid hsl(var(--border));
        }
        .select2-results__option:empty {
            display: none !important;
        }
    </style>
@endpush

<!--@push('script')-->
<!--    <script>-->


<!--        (function($) {-->
<!--            "use strict"-->

<!--            let sendId, sendMinAmount = 0, sendMaxAmount = 0, sendAmount = 0, sendCurrency, sendCurrencyBuyRate = 0;-->

<!--            let receivedId, receivedAmount = 0, receivedCurrency, receiveCurrencySellRate = 0;-->


<!--            @if (old('sending_currency') || @$exchangeFormData)-->
<!--                sendAmount = "{{ old('sending_amount') ?? 0}}";-->
<!--                @if(@$exchangeFormData['sending_amount'])-->
<!--                    sendAmount = "{{ @$exchangeFormData['sending_amount']  ?? 0}}";-->
<!--                @endif-->
<!--                sendAmount = parseFloat(sendAmount);-->
<!--                $("#sending_amount").val(sendAmount.toFixed("{{$general->show_number_after_decimal}}"));-->
<!--                setTimeout(() => {-->
<!--                    $('#send').trigger('change');-->
<!--                });-->
<!--            @endif-->

<!--            @if (old('receiving_currency') || @$exchangeFormData)-->
<!--                receivedAmount = "{{ old('receiving_amount')}}";-->
<!--                @if(@$exchangeFormData['receiving_amount'])-->
<!--                    receivedAmount = "{{ @$exchangeFormData['receiving_amount'] }}";-->
<!--                @endif-->
<!--                receivedAmount=parseFloat(receivedAmount);-->
<!--                $("#receiving_amount").val(receivedAmount.toFixed("{{$general->show_number_after_decimal}}"));-->
<!--                setTimeout(() => {-->
<!--                    $('#receive').trigger('change');-->
<!--                });-->
<!--            @endif-->

<!--            function sameCurrencyCheck(){-->

<!--                if(sendId){-->
<!--                    $('.receiveData').find(`.list li`).removeClass('d-none');-->
<!--                    $('.receiveData').find(`.list li[data-value="${sendId}"]`).addClass('d-none');-->
<!--                }-->
<!--                if(receivedId){-->
<!--                    $('.sendData').find(`.list li`).removeClass('d-none');-->
<!--                    $('.sendData').find(`.list li[data-value="${receivedId}"]`).addClass('d-none');-->
<!--                }-->
<!--            }-->

<!--            function calculationReceivedAmount(){-->

<!--                if (!sendId && !receivedId && !sendCurrencyBuyRate && !receiveCurrencySellRate) {-->
<!--                    return false;-->
<!--                }-->
<!--                let amountReceived = (sendCurrencyBuyRate / receiveCurrencySellRate) * sendAmount;-->
<!--                $("#receiving_amount").val(amountReceived.toFixed(2))-->
<!--            }-->

<!--            function calculationSendAmount(){-->

<!--                if (!sendId && !receivedId && !sendCurrencyBuyRate && !receiveCurrencySellRate) {-->
<!--                    return false;-->
<!--                }-->
<!--                let amountReceived = (receiveCurrencySellRate / sendCurrencyBuyRate) * receivedAmount;-->
<!--                $("#sending_amount").val(amountReceived.toFixed(2))-->
<!--            }-->

<!--            $('#send').on('change',function(){-->
               
<!--                sendId = parseInt($(this).val());-->
<!--                sendMinAmount = parseFloat($(this).find(':selected').data('min') ?? 0);-->
<!--                sendMaxAmount = parseFloat($(this).find(':selected').data('max') ?? 0);-->
<!--                sendCurrency = $(this).find(':selected').data('currency') ?? '';-->
<!--                sendCurrencyBuyRate = parseFloat($(this).find(':selected').data('buy') ?? 0);-->
<!--                $("#currency-limit").removeClass('d-none').text(`Limit: ${sendMinAmount.toFixed(2)} - ${sendMaxAmount.toFixed(2)} ${sendCurrency}`);-->
<!--                sameCurrencyCheck()-->
<!--                calculationReceivedAmount();-->

<!--            }).change();-->

<!--            $('#receive').on('change',function(){-->
<!--                receivedId = parseInt($(this).val());-->
<!--                receiveCurrencySellRate = parseFloat($(this).find(':selected').data('sell'));-->
<!--                receivedCurrency = $(this).find(':selected').data('currency');-->

<!--                let minAmount = parseFloat($(this).find(':selected').data('min')) ?? 0;-->
<!--                let maxAmount = parseFloat($(this).find(':selected').data('max')) ?? 0;-->
<!--                let reserveAmount = parseFloat($(this).find(':selected').data('reserve'))-->

<!--                $("#currency-limit-received").removeClass('d-none').text(`Limit: ${minAmount.toFixed(2)} - ${maxAmount.toFixed(2)} ${receivedCurrency} | Reserve ${reserveAmount.toFixed(2)} ${receivedCurrency}`);-->

<!--                sameCurrencyCheck();-->
<!--                calculationReceivedAmount(); -->
<!--            });-->

<!--            $('#sending_amount').on('input',function(){-->
<!--                sendAmount = parseFloat(this.value);-->
<!--                sameCurrencyCheck();-->
<!--                calculationReceivedAmount();-->
<!--            });-->

<!--            $('#receiving_amount').on('input',function(){-->
<!--                if (!sendId) {-->
<!--                    this.value = this.value.replace('');-->
<!--                    return false;-->
<!--                }-->
<!--                receivedAmount = parseFloat(this.value);-->
<!--                sameCurrencyCheck();-->
<!--                calculationSendAmount();-->
<!--            })-->




<!--        })(jQuery);-->
<!--    </script>-->
<!--@endpush-->






