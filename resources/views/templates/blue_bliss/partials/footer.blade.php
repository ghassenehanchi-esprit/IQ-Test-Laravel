@php
    $footerContent = getContent('footer.content', true);
    $socialIcons = getContent('social_icons.element', false);
    $topCurrencies = App\Models\Exchange::where('status', Status::EXCHANGE_APPROVED)
        ->orWhere('automatic_payment_status', Status::YES)
        ->groupBy('send_currency_id')
        ->selectRaw('count(send_currency_id) as gateway , send_currency_id')
        ->take(3)
        ->with('sendCurrency:id,name,cur_sym')
        ->get();
    $policyPages = getContent('policy_pages.element', false, null, true);
    $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();

    $content = getContent('subscribe.content', true);

    $header = getContent('header.content', true);
@endphp

<!--=======Footer-Section Starts Here=======-->
<footer class="overflow-hidden footer-section">
    <div class="footer-shape"></div>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-xl-7 col-lg-10 text-center">
                <h2 class="footer-title text-white">{{ __(@$footerContent->data_values->title) }}</h2>
                <a href="{{ __(@$footerContent->data_values->url) }}" class="btn btn-base-two mt-4">
                    {{ __(@$footerContent->data_values->button_text) }}
                </a>
            </div>
        </div>
        <div class="footer-wrapper">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-3">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <img src="{{ siteLogo('dark') }}" alt="{{ __($general->site_name) }}" title="{{ __($general->site_name) }}">
                    </a>
                    <p class="mt-3">{{ __(@$footerContent->data_values->details) }}</p>
                    <h6 class="mt-4">@lang('Social Media')</h6>
                    <ul class="social-icons mt-3">
                        @foreach ($socialIcons as $socialIcon)
                            <li title="{{ ucfirst(@$socialIcon->data_values->title) }}">
                                <a href="{{ @$socialIcon->data_values->url }}" class="{{ strtolower(@$socialIcon->data_values->name) }}">
                                    @php  echo @$socialIcon->data_values->icon; @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h5 class="footer-item-title">@lang('Support')</h5>
                    <ul class="footer-item-menu-list">
                        <li>
                            <a href="{{ route('contact') }}">@lang('Contact')</a>
                        </li>
                        <li>
                            <a href="{{ route('pages', 'blog') }}">@lang('Blog')</a>
                        </li>
                        @guest
                            <li>
                                <a href="{{ route('user.login') }}">@lang('Login')</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </li>
                        @endguest
                    </ul>
                </div>
                {{--
                <div class="col-lg-2">
                    <h5 class="title">@lang('Exchange Gateways')</h5>
                    <ul>
                        @foreach ($topCurrencies as $topCurrency)
                            <li>
                                <a href="{{ route('home') }}">
                                    {{ __(@$topCurrency->sendCurrency->name) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
                <div class="col-lg-2 col-sm-6">
                    <h5 class="footer-item-title">@lang('Useful Link')</h5>
                    <ul class="footer-item-menu-list">
                        @foreach ($policyPages as $policy)
                            <li>
                                <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">
                                    {{ __($policy->data_values->title) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="footer-item-title">@lang('Support Center')</h5>
                    <ul class="footer-info-list mt-4">
                        <li>
                            <i class="fas fa-phone"></i>
                            <p>{{ @$header->data_values->mobile }}</p>
                        </li>
                        <li class="mt-2">
                            <i class="far fa-envelope"></i>
                            <p>{{ @$header->data_values->email }}</p>
                        </li>
                    </ul>

                    <p class="mt-4">{{ __(@$content->data_values->subheading) }}</p>
                    <form class="newsletter-form" action="{{route('subscribe')}}" method="POST" id="newsletr-form">
                        @csrf
                        <input type="email" placeholder="@lang('Enter Your Email....')" name="email" class="form--control text--base subscribe-input-field" required>
                        <button type="submit" id="subscribe" class="h5 text-white">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <p>@lang('Copyright') &copy; {{ date('Y') }} {{ __(@$footerContent->data_values->copyright) }}</p>
            </div>
        </div>
    </div>
</footer>
<!--=======Footer-Section Ends Here=======-->

@if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
    <div class="cookies-card text-center hide">
        <div class="cookies-card__icon bg--base">
            <i class="fas fa-cookie-bite"></i>
        </div>
        <p class="mt-4 cookies-card__content">{{ __($cookie->data_values->short_desc) }} <a href="{{ route('cookie.policy') }}" target="_blank" class="text--base">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <button type="button" class="btn btn--base w-100 policy cookie-btn">@lang('Allow')</button>
        </div>
    </div>
@endif


@push('script')
    <script>
        "use strict";
        (function($) {
            $("#newsletr-form").on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData($(this)[0]);
                $.ajax({
                    url: `{{ route('subscribe') }}`,
                    method: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        if (resp.success) {
                            notify('success', resp.message)
                            $('.subscribe-input-field').val('')
                        } else {
                            notify('error', resp.error || `@lang('Something went wrong')`)
                        }
                    },
                    error: function(e) {
                        notify(`@lang('Something went wrong')`)
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
