@php
$content  = getContent('feature.content',true);
$elements = getContent('feature.element');
@endphp
@if ($content)
<section class="feature-section padding-top padding-bottom section-bg">
    <div class="container">

        {{-- 
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-header">
                    <h3 class="title">{{__(@$content->data_values->heading)}}</h3>
                    <p> {{__(@$content->data_values->subheading)}}</p>
                </div>
            </div>
        </div> --}}

        <div class="row justify-content-center gy-xl-5 gy-4 feature-box-wrapper">
            @foreach($elements as $element)
            <div class="col-md-6 col-sm-10 col-xl-4">
                <div class="feature-box">
                    <div class="feature-box-top">
                        <div class="feature-box-icon">
                            @php echo $element->data_values->feature_icon; @endphp
                        </div>
                        <h5 class="title">{{__(@$element->data_values->title)}}</h5>
                    </div>
                    <div class="feature-box-content">
                        <p>{{__(@$element->data_values->description)}}</p>
                    </div>  
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
