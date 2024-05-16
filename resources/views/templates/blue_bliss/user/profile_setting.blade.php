@extends($activeTemplate . 'layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card custom--card">
                <div class="card-body p-0">
                    <div class="row gy-4 justify-content-center flex-wrap-reverse">
                        <div class="col-md-5 col-lg-4">
                            <ul class="list-group list-group-flush bg--light h-100 p-3">
                                <li class="list-group-item d-flex flex-column justify-content-between border-0 bg-transparent">
                                    <span class="fw-bold text-muted">{{ $user->firstname }} {{ $user->lastname }}</span>
                                    <small class="text-muted"> <i class="la la-user"></i> @lang('Name')</small>
                                </li>

                                <li class="list-group-item d-flex flex-column justify-content-between border-0 bg-transparent">
                                    <span class="fw-bold text-muted">{{ $user->username }}</span>
                                    <small class="text-muted"> <i class="la la-user"></i> @lang('User ID')</small>
                                </li>

                                <li class="list-group-item d-flex flex-column justify-content-between border-0 bg-transparent">
                                    <span class="fw-bold text-muted">{{ $user->email }}</span>
                                    <small class="text-muted"><i class="la la-envelope"></i> @lang('Email')</small>
                                </li>

                                <li class="list-group-item d-flex flex-column justify-content-between border-0 bg-transparent">
                                    <span class="fw-bold text-muted">+{{ $user->mobile }}</span>
                                    <small class="text-muted"><i class="la la-mobile"></i> @lang('Mobile')</small>
                                </li>

                                <li class="list-group-item d-flex flex-column justify-content-between border-0 bg-transparent">
                                    <span class="fw-bold text-muted">{{ $user->address->country }}</span>
                                    <small class="text-muted"><i class="la la-globe"></i> @lang('Country')</small>
                                </li>

                                <li class="list-group-item d-flex flex-column justify-content-between border-0 bg-transparent">
                                    <span class="fw-bold text-muted">{{ $user->address->address }}</span>
                                    <small class="text-muted"><i class="la la-map-marked"></i> @lang('Address')</small>
                                </li>
                            </ul>
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
        // Your existing JavaScript code goes here
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
            var form = $(this).closest('form'); // Find the closest form element

            if ($(this).attr('name') == 'mobile') {
                var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                // Concatenate mobile code with the mobile number
                var mobileWithCode = $('input[name=mobile_code]').val() + mobile;
                var data = {
                    mobile: mobileWithCode,
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

            // Submit the form using AJAX
            $.ajax({
                url: form.attr('action'), // Get the form action URL
                method: form.attr('method'), // Get the form method (POST)
                data: form.serialize(), // Serialize the form data including the CSRF token
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response
                    // For example, you can display a success message or redirect the user
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    // For example, you can display an error message to the user
                    console.error(xhr.responseText);
                }
            });

            // Prevent the default form submission
            e.preventDefault();
        });
    })(jQuery);
</script>
@endpush
