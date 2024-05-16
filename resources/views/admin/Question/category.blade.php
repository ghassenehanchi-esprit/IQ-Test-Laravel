@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
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
                            <!-- Form Section -->
                            <div class="col-xl-8">
                                <div class="form-group">
                                    <label>@lang('Category Name')</label>
                                    <select name="category_name" class="form-control" required>
                                        <option value="">@lang('Select a category')</option>
                                        <option value="Verbal">@lang('Verbal')</option>
                                        <option value="Numerical">@lang('Numerical')</option>
                                        <option value="Spatial">@lang('Spatial')</option>
                                        <option value="Logical">@lang('Logical')</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>@lang('Difficulty Level')</label>
                                    <select name="difficulty_level" class="form-control" required>
                                        <option value="1">Easy</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Hard</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Score')</label>
                                    <input type="number" name="score" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Add Category')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>@lang('Category Name')</th>
                            <th>@lang('Difficulty Level')</th>
                            <th>@lang('Score')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->difficulty_level }}</td>
                                    <td>
                                        <input type="number" name="score" class="form-control" value="{{ $category->score }}">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script>
        function editCategory(id) {
            var score = document.getElementById('score_' + id).value;

            $.ajax({
                url: '{{ route('admin.categories.update', '') }}/' + id,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    score: score
                },
                success: function(response) {
                    alert('Category updated successfully!');
                }
            });
        }
    </script>
@endpush

