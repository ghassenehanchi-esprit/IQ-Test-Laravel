@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.questions.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Display success and error messages -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Image Section -->
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{getImage(getFilePath('seo').'/'. @$seo->data_values->image,getFileSize('seo')) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="question_image" id="profilePicUpload1" accept=".png, .jpg, .jpeg , .svg">
                                                <label for="profilePicUpload1" class="bg--primary">@lang('Upload Image')</label>
                                                <small class="mt-2">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png'),@lang('svg')</b>. @lang('Image will be resized into') {{getFileSize('seo')}}@lang('px'). </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Section -->
                            <div class="col-xl-8">
                                <div class="form-group">
                                    <label>@lang('Question Text')</label>
                                    <textarea name="question_text" rows="3" class="form-control"></textarea>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Category - Difficulty level')</label>
                                        <select name="category_id" class="form-control form--control" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }} -
                                                    @if ($category->difficulty_level == 1)
                                                        Easy
                                                    @elseif ($category->difficulty_level == 2)
                                                        Medium
                                                    @elseif ($category->difficulty_level == 3)
                                                        Hard
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                            </div>


                            <!-- Add fields for 6 answers -->
                            @for ($i = 1; $i <= 6; $i++)
                                <div class="form-group">
                                    <label>@lang('Answer '){{ $i }}</label>
                                    <textarea name="answers[]" rows="2" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Answer Image '){{ $i }}</label>
                                    <input type="file" name="answer_images[]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Is Correct?')</label>
                                    <input type="radio" name="is_correct" value="{{ $i - 1 }}">
                                </div>
                            @endfor

                            <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            // Check for success message
            @if(session('success'))
            alert('{{ session('success') }}');
            @endif

            // Check for errors message
            @if ($errors->any())
            var errorMessage = '';
            @foreach ($errors->all() as $error)
                errorMessage += '{{ $error }}\n';
            @endforeach
            alert(errorMessage);
            @endif

        })(jQuery);
    </script>
@endpush

@push('styles')
    <style>
        /* Custom styles for the layout */
        .form-group {
            margin-bottom: 20px;
        }
    </style>
@endpush
