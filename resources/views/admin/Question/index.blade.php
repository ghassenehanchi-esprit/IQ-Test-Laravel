@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Image')</th>
                                <th>@lang('Question Text')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Difficulty Level')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($questions as $question)
                                <tr>
                                    <td>
                                        @if($question->question_image)
                                            <img src="{{ asset('storage/questions/' . $question->question_image) }}" alt="Question Image" class="img-fluid" width="150">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        {{ $question->question_text }}
                                    </td>
                                    <td>
                                        {{ $question->category->category_name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $question->category->difficulty_level ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline--danger" onclick="return confirm('Are you sure you want to delete this question?');">
                                                <i class="las la-trash"></i> @lang('Delete')
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.questions.show', $question->id) }}" class="btn btn-sm btn-outline--primary">
                                            <i class="las la-desktop"></i> @lang('Details')
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">No questions found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Question Text" />
@endpush
