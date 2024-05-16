@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8">
                <div class="alert alert-success
    mb-0" role="alert">
                    <h6 class="alert-heading">KYC Verification</h6>
                    <p class="py-2">
                        Dear user, Your submitted KYC Data is currently pending now. Please take us some time to review your Data. Thank you so much for your cooperation.

                    </p>
                </div>
                <div class="card custom--card" style="margin-top: 50px">
                    <div class="card-body">
                        <!-- Display user's first name and last name -->
                        <div class="form-group">
                            <label class="form-label">@lang('First Name')</label>
                            <input type="text"
                                   class="form-control form--control"
                                   value="{{ auth()->user()->firstname }}"
                                   disabled
                            >
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Last Name')</label>
                            <input type="text"
                                   class="form-control form--control"
                                   value="{{ auth()->user()->lastname }}"
                                   disabled
                            >
                        </div>

                        <!-- KYC submission form -->
                        <form id="kyc-form" action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <x-viser-form identifier="act" identifierValue="kyc" />

                            <!-- Note with randomly generated code -->
                            <div class="form-group">
                                <label class="form-label">@lang('Write the following code on a piece of paper and include it in the photo'):</label>
                                <input type="text"
                                       id="code"
                                       name="code"
                                       class="form-control form--control"
                                       value="{{ $randomCode }}"
                                       readonly
                                >
                            </div>





                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('script')

        <script>
            "use strict";
            window.addEventListener('DOMContentLoaded', () => {
            let stream; // Declare stream variable outside the scope
            const videoContainer = document.querySelector('.video-container');
            const capturedPhoto = document.getElementById('capturedPhoto');
            const recaptureBtn = document.getElementById('recaptureBtn');
            const saveBtn = document.getElementById('saveBtn');

            // Open camera modal when button is clicked
            const openCameraBtn = document.getElementById('open-camera');
            openCameraBtn.addEventListener('click', async () => {
            try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const videoElement = document.getElementById('cameraPreview');
            videoElement.srcObject = stream;
            videoContainer.classList.remove('d-none');
            capturedPhoto.classList.add('d-none');
            recaptureBtn.classList.add('d-none');
            saveBtn.classList.add('d-none');
            $('#cameraModal').modal('show');
        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('Failed to access camera');
        }
        });

            // Close camera modal when cancel button in modal is clicked
            const cancelCaptureBtn = document.getElementById('cancelCaptureBtn');
            cancelCaptureBtn.addEventListener('click', () => {
            $('#cameraModal').modal('hide');
            if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        });

            // Capture photo when button in modal is clicked
            const captureBtn = document.getElementById('captureBtn');
            captureBtn.addEventListener('click', async () => {
            try {
            const videoElement = document.getElementById('cameraPreview');
            const canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
            const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg'));
            const photoInput = document.getElementById('photo');
            const fileList = new DataTransfer();
            fileList.items.add(new File([blob], 'captured_photo.jpg', { type: 'image/jpeg' }));
            photoInput.files = fileList.files;
            capturedPhoto.src = URL.createObjectURL(blob);
            capturedPhoto.classList.remove('d-none');
            videoContainer.classList.add('d-none');
            recaptureBtn.classList.remove('d-none');
            saveBtn.classList.remove('d-none');
        } catch (error) {
            console.error('Error capturing photo:', error);
            alert('Failed to capture photo');
        }
        });

            // Recapture photo when recapture button is clicked
            recaptureBtn.addEventListener('click', () => {
            capturedPhoto.classList.add('d-none');
            videoContainer.classList.remove('d-none');
            recaptureBtn.classList.add('d-none');
            saveBtn.classList.add('d-none');
        });

            // Save photo and close modal when save button in modal is clicked
            saveBtn.addEventListener('click', async () => {
            try {
            // Here you can perform actions to save the photo, such as sending it to a server
            const photoInput = document.getElementById('photo');
            if (photoInput.files.length > 0) {
            console.log('Captured photo:', photoInput.files[0]);
            // Close the modal
            $('#cameraModal').modal('hide');
            // Stop the camera stream
            if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        } else {
            console.error('No photo captured.');
            alert('No photo captured.');
        }
        } catch (error) {
            console.error('Error saving photo:', error);
            alert('Failed to save photo');
        }
        });
        });
    </script>



@endpush
