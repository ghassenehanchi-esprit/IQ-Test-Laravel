@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $banner = getContent('banner.content', true);
    @endphp
    <section class="banner-section bg_fixed bg_img">
        <!-- data-background="{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->background_image, '1200x685') }}" -->
        <div class="container">
            <div class="banner-content row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="content">
                        <h2 class="title">{{ __(@$banner->data_values->heading) }}</h2>
                        <p>{{ __(@$banner->data_values->subheading) }}</p>

                        <div class="currency-converter mt-4">
                        @auth
                                @if(auth()->user()->kv == 1)
                                    @include($activeTemplate . 'partials.exchange_form')
                                @endif
                            @endauth
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner-img">
                        <img src="{{getImage('assets/images/frontend/banner/'.@$banner->data_values->banner_image,'600x600')}}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($sections && $sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
