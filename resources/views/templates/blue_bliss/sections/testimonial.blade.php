@php
    $content = getContent('testimonial.content', true);
    $elements = getContent('testimonial.element');
@endphp
@if ($content)
    <section class="client-section padding-bottom section-bg">
        <div class="container">
            <div class="testimonial-wrapper">
                <div class="testimonial-shape"></div>
                <div class="section-header left-style">
                    <h3 class="title">{{ __(@$content->data_values->heading) }}</h3>
                    <p>{{ __(@$content->data_values->subheading) }}</p>
                </div>
                <div class="client-slider">
                    <div class="swiper-wrapper">
                        @foreach ($elements as $element)
                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-thumb">
                                        <div class="content">
                                            <h6 class="title">{{ __(@$element->data_values->name) }}</h6>
                                            <span>{{ __(@$element->data_values->designation) }}</span>
                                        </div>
                                    </div>
                                    <div class="client-content">
                                        <blockquote> {{ __(@$element->data_values->description) }}</blockquote>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="common-pagination"></div>
            </div>
        </div>
    </section>
@endif
