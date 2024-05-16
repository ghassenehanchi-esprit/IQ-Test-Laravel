@extends('layouts.app')
@section('content')
    <style>
        .congrats-image {
            display: block; /* Use block display */
            height: auto; /* Maintain aspect ratio */
            z-index: 1; /* Ensure it's above other elements */
            margin: 0 auto; /* Center the image horizontally */
        }

    </style>

    <!-- Testimonial Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h6 class="text-primary text-uppercase mb-2">IQ Test Results</h6>
                <h1 class="display-6 mb-4">Congratulations ! You passed the Test !</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="owl-carousel testimonial-carousel">
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-5">
                                <!-- Position for the PNG image -->
                                <img src="{{ asset('img/iq1.png') }}" alt="Achievement" class="congrats-image">
                            </div>
                            <p class="fs-4">Congratulations on completing your IQ test!</p>
                            <hr class="w-25 mx-auto">
                            <h5>Your Score</h5>
                            <!-- Enlarged the score and changed the color for emphasis -->
                            <span style="font-size: 2rem; color: #007bff;">{{ $order->quizz->quizz_score }} / {{calculateTotalQuizScore($order->quizz->id)}}</span>
                        </div>

                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-5">
                                <img class="img-fluid rounded-circle mx-auto" src="{{ asset('pdf.png') }}" alt="PDF Icon">
                                </div>
                            <p class="fs-4">Complete the form below to receive your personalized IQ Test Certificate.</p>
                            <hr class="w-25 mx-auto">
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
    <!-- PDF Generation Form Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="text-center mx-auto mb-5">
                        <h2 class="mb-4">Get Your IQ Test Certificate</h2>
                        <p>Enter your details below to receive your personalized IQ test certificate.</p>
                    </div>
                    <form action="{{ route('show.order', ['id' => $order->id]) }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter your email address" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit & Generate Certificate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- PDF Generation Form End -->
@endsection
