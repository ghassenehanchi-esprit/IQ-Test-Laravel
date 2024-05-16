@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th>@lang('username')</th>
                                <th>@lang('Guess Amount')</th>
                                <th>@lang('Winner Status')</th>
                                <th>@lang('Date')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($guess as $item)
                                <tr>
                                    <td>{{$item->user->fullname}}</td>
                                    <td><strong>{{ $item->guess }}</strong></td>
                                    <td>
                                        @if($item->is_winner == Status::YES)
                                            <span class="badge badge--success">@lang('Winner')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('loser')</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{showDateTime($item->created_at,'d M Y')}}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>




    <x-confirmation-modal/>
@endsection


@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline--primary confirmationBtn" data-action="{{route('admin.select.winner')}}" data-question="@lang('Are you sure to selet winner ?')" ><i class="las la-plus"></i>@lang('Make Winner')</button>
@endpush


