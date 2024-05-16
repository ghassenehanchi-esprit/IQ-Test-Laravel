@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($question->question_image)
                                <img src="{{ asset('storage/questions/' . $question->question_image) }}" alt="Question Image" class="img-fluid" width="150">
                            @else
                                No Image
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4 class="font-weight-bold">{{ $question->question_text }}</h4>
                            <div class="form-group">
                                <label>@lang('Category'):</label>
                                {{ optional($question->category)->category_name ?? 'N/A' }}
                            </div>
                            <div class="form-group">
                                <label>@lang('Difficulty Level'):</label>
                                {{ optional($question->category)->difficulty_level ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <h6 class="card-title mt-4 mb-3">@lang('Answers')</h6>
                    @foreach($question->answers as $answer)
                        <div class="row border border--primary border-radius-3 my-3 mx-2">
                            <div class="col-md-4">
                                @if($answer->answer_image)
                                    <img src="{{ asset('storage/answers/' . $answer->answer_image) }}" alt="Answer Image" class="img-fluid" width="150">
                                @endif
                            </div>
                            <div class="col-md-8" style="{{ $answer->is_correct == 1 ? 'background-color: #e6ffe6;' : ($answer->is_correct == 0 ? 'background-color: #ffe6e6;' : '') }}">
                                <p>{{ $answer->answer_text }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.questions.index') }}"/>
@endpush
