@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card card-deposit text-center">
                    <div class="card-header card-header-bg">
                        <h3>@lang('Payment Preview')</h3>
                    </div>
                    <div class="card-body card-body-deposit text-center">
                        <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text--success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                        <h5 class="mb-2">@lang('TO') <span class="text--success"> {{ $data->sendto }}</span>
                        <button onclick="copyToClipboard('{{ $data->sendto }}')" class="copy-address-button">
    <i class="las la-copy"></i> Copy Address
</button>

                            <span id="copyNotification" class="text-muted" style="display: none;">@lang("Address copied to clipboard")</span>
                        </h5>
                        <img src="{{$data->img}}" alt="@lang('Image')">
                        <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            document.getElementById('copyNotification').style.display = 'inline';
            setTimeout(function() {
                document.getElementById('copyNotification').style.display = 'none';
            }, 3000); // 3 seconds
        }
    </script>
@endsection
@push('style')
<style>
.copy-address-button {
    background-color: #28df99;
    color: #fff;
    border: none;
    padding: 6px 12px;
    cursor: pointer;
    border-radius: 4px;
}

.copy-address-button:hover {
    background-color: #1d9e74;
}
</style>
@endpush
