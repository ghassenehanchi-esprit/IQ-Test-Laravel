@foreach($formData as $data)
    <div class="form-group">
        <label class="form-label">{{ $data->name }}</label>
        @if($data->type == 'text')
            <input type="text"
                   class="form-control form--control"
                   name="{{ $data->label }}"
                   value="{{ old($data->label) }}"
                   @if($data->is_required == 'required') required @endif
            >
        @elseif($data->type == 'image')

            <div class="form-group">
                <button type="button" id="open-camera" class="btn btn--base w-100" data-bs-toggle="modal" data-bs-target="#cameraModal">
                    @lang('Take Photo')
                </button>
                <input type="file" id="photo" name="photo" class="d-none"  required> <!-- Add name attribute -->
            </div>

        @elseif($data->type == 'textarea')
            <textarea class="form-control form--control"
                      name="{{ $data->label }}"
                      @if($data->is_required == 'required') required @endif
            >{{ old($data->label) }}</textarea>
        @elseif($data->type == 'select')
            <select class="form-control form--control"
                    name="{{ $data->label }}"
                    @if($data->is_required == 'required') required @endif
            >
                <option value="">@lang('Select One')</option>
                @foreach ($data->options as $item)
                    <option value="{{ $item }}" @selected($item == old($data->label))>{{ __($item) }}</option>
                @endforeach
            </select>
        @elseif($data->type == 'date')
            <div class="input-group w-auto flex-fill">
                <input type="date" name="{{ $data->label }}"
                       value="{{ old($data->label) }}"
                       @if($data->is_required == 'required') required @endif class="datepicker-here form-control bg--white pe-2"
                       data-position="bottom right" placeholder="Select Date" autocomplete="off">
            </div>
        @elseif($data->type == 'checkbox')
            @foreach($data->options as $option)
                <div class="form-check">
                    <input class="form-check-input"
                           name="{{ $data->label }}[]"
                           type="checkbox"
                           value="{{ $option }}"
                           id="{{ $data->label }}_{{ titleToKey($option) }}"
                    >
                    <label class="form-check-label" for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                </div>
            @endforeach
        @elseif($data->type == 'radio')
            @foreach($data->options as $option)
                <div class="form-check">
                    <input class="form-check-input"
                           name="{{ $data->label }}"
                           type="radio"
                           value="{{ $option }}"
                           id="{{ $data->label }}_{{ titleToKey($option) }}"
                        @checked($option == old($data->label))
                    >
                    <label class="form-check-label" for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                </div>
            @endforeach
        @elseif($data->type == 'file')
            <input type="file"
                   class="form-control form--control"
                   name="{{ $data->label }}"
                   @if($data->is_required == 'required') required @endif
                   accept="@foreach(explode(',',$data->extensions) as $ext) .{{ $ext }}, @endforeach"
            >
            <pre class="text--base mt-1">@lang('Supported mimes'): {{ $data->extensions }}</pre>

        @endif

    </div>
@endforeach

<!-- Modal for capturing photo -->
<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cameraModalLabel">@lang('Capture Photo')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="video-container d-none">
                    <video id="cameraPreview" autoplay playsinline></video>
                </div>
                <img id="capturedPhoto" class="d-none" alt="Captured Photo" style="max-width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelCaptureBtn" data-bs-dismiss="modal">@lang('Cancel')</button>
                <button type="button" id="captureBtn" class="btn btn-primary">@lang('Capture')</button>
                <button type="button" id="recaptureBtn" class="btn btn-primary d-none">@lang('Recapture')</button>
                <button type="button" id="saveBtn" class="btn btn-success d-none">@lang('Save')</button>
            </div>
        </div>
    </div>
</div>
<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
    }

    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

</style>
