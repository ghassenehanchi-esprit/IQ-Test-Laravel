@php
    $content = getContent('counter.content', true);
    $elements = getContent('counter.element');
@endphp

@if ($content)
    <div class="counter-section padding-bottom section-bg">
        <div class="container">
            <div class="row gy-4 align-items-center justify-content-between">
                <div class="col-lg-5">
                    <h3 class="title">{{ __(@$content->data_values->heading) }}</h3>
                    <p class="mt-3">{{ __(@$content->data_values->subheading) }}</p>
                </div>
                <div class="col-lg-6">
                    <div class="counter-wrapper">
                        <div class="row justify-content-center g-sm-5 gy-4">
                            @foreach ($elements as $element)
                                <div class="col-6">
                                    <div class="counter-item">
                                        <div class="counter-header">
                                            <h4 class="title odometer" data-odometer-final="{{ @$element->data_values->counter_digit }}">0</h4>
                                            <h4 class="title">{{ __(@$element->data_values->counter_abbreviation) }}</h4>
                                        </div>
                                        <div class="counter-content">
                                            <h6 class="subtitle">{{ __($element->data_values->title) }}</h6>
                                        </div>
                                        <div class="icon">
                                            @php echo $element->data_values->counter_icon;@endphp
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
