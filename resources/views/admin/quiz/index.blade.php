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
                                <th>@lang('Order ID')</th>
                                <th>@lang('Quiz ID')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Stripe Session ID')</th>
                                <th>@lang('PayPal Session ID')</th>
                                <th>@lang('Is Paid')</th>
                                <th>@lang('Quiz Score')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($paidOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->quizz_id }}</td>
                                    <td>{{ $order->amount }}</td>
                                    <td>{{ $order->stripe_session_id }}</td>
                                    <td>{{ $order->paypal_session_id }}</td>
                                    <td>{{ $order->is_paid ? 'Yes' : 'No' }}</td>
                                    <td>{{ $order->quizz->quizz_score }}</td>
                                    <td>
                                        <!-- Add action buttons here -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('No paid orders found')</td>
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
    <x-search-form placeholder="Search Orders" />
@endpush
