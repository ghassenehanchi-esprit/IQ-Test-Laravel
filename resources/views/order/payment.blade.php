@extends('layouts.app')

@section('content')
    <div class="container my-3 mt-10" style="margin-top: 100px;">
        <div class="gb-pay mb-10 mx-auto">
            <input type="hidden" name="action" value="client_pay_init">
            <input type="hidden" name="invoice_id" value="127876">
            <section class="pay-description mb-6">
                <h3 class="pay-title mb-3">You're Buying</h3>
                <div class="d-flex gap-5">
                    <div class="symbol bg-light p-3">
                        <img src="" class="w-40px h-40px">
                    </div>
                    <div class="d-flex align-items-start flex-column justify-content-center">
                        <span class="text-dark fw-semibold text-capitalize fs-5">IQ Test - Quiz</span>
                    </div>
                </div>
            </section>
            <section class="pay-method mb-6">
                <h3 class="pay-title mb-5">Pay With</h3>
                <div class="pay-method-list">
                    @php
                        $paymentMethod = 'stripe'; // Set the default payment method here
                    @endphp
                    <input type="hidden" id="payment_method" name="payment_method" value="{{ $paymentMethod }}" />
                    <div class="pay-method-ind recommended">
                        <input id="stripe" name="payment_method" value="stripe" type="radio" {{ $paymentMethod === 'stripe' ? 'checked' : '' }} />
                        <label class="border border-hover-gray" for="stripe">
                            <img class="p-method" src="{{ asset('img/payment/Stripe.svg') }}">
                            <div>
                                <img src="{{ asset('img/payment/MasterCard-dark.svg') }}" class="pay-img-card img-second">
                                <img src="{{ asset('img/payment/Visa-card-dark.svg') }}" class="pay-img-card img-second">
                                <img src="{{ asset('img/payment/AmericanExpress-dark.svg') }}" class="pay-img-card img-second">
                            </div>
                        </label>
                    </div>
                    <div class="pay-method-ind">
                        <input id="paypal" name="payment_method" value="paypal" type="radio" {{ $paymentMethod === 'paypal' ? 'checked' : '' }} />
                        <label class="border border-hover-gray" for="paypal">
                            <img class="p-method" src="{{ asset('img/payment/Paypal.svg') }}">
                            <div>
                                <img src="{{ asset('img/payment/Paypal-card-dark.svg') }}" class="pay-img-card img-second">
                            </div>
                        </label>
                    </div>
                </div>
            </section>
            <section class="pay-total">
                <div class="pay-tos"></div>
                <div class="pay-summary">
                    <div class="total-text text-dark">Total Price</div>
                    <div class="total-price fw-bold" id="displayed-price">{{ $price }} USD</div>
                </div>
            </section>
            <section class="pay-finalize">
                <input type="hidden" name="invoice_id" value="127876">
                @if ($paymentMethod === 'paypal')
                    @php
                        $paymentRoute = 'paypal.payment.show';
                    @endphp
                @elseif ($paymentMethod === 'stripe')
                    @php
                        $paymentRoute = 'stripe.payment.show';
                    @endphp
                @endif
                <div class="d-grid mb-2">
                    <a class="btn btn-primary btn-lg" href="{{ route($paymentRoute,['id'=>$quizOrder->id]) }}">
                        <span class="indicator-label">Pay Now</span>
                    </a>
                </div>
                <div class="text-center mt-3">
                    <a href="/" class="link-danger">Cancel Payment</a>
                </div>
            </section>
        </div>
    </div>

    <script>
        // JavaScript code to handle payment method selection
        document.getElementById("stripe").addEventListener("change", function() {
            // Set the payment method to "stripe"
            document.getElementById("payment_method").value = "stripe";
            // Update the href of the button
            document.querySelector(".btn-lg").href = "{{ route('stripe.payment.show',['id'=>$quizOrder->id]) }}";
        });

        document.getElementById("paypal").addEventListener("change", function() {
            // Set the payment method to "paypal"
            document.getElementById("payment_method").value = "paypal";
            // Update the href of the button
            document.querySelector(".btn-lg").href = "{{ route('paypal.payment.show',['id'=>$quizOrder->id]) }}";
        });
    </script>
@endsection
