@php
    $header = getContent('header.content', true);
@endphp

<div class="user-sidebar">
    <button id="sidebar-close-btn" class="sidebar-close-btn d-lg-none bg-transparent border-0">
        <i class="far fa-times-circle"></i>
    </button>
    <div class="logo-area">
        <a href="{{ route('home') }}">
            <img src="{{ siteLogo('dark') }}">
        </a>
    </div>
    <div class="sidebar-menu-box">
        <ul class="sidebar-menu-list" id="user-menu">
            <li>
                <a href="{{ route('user.home') }}" class="active">
                    <i class="fas fa-layer-group"></i>
                    @lang('Dashboard')
                </a>
            </li>

            <li class="has-dropdown">
                <a href="#">
                    <i class="fas fa-exchange-alt"></i>
                    @lang('Exchanges')
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('user.exchange.list', 'list') }}">@lang('All Exchange')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.exchange.list', 'approved') }}">@lang('Approved Exchange')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.exchange.list', 'pending') }}">@lang('Pending Exchange')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.exchange.list', 'refunded') }}">@lang('Refunded Exchange')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.exchange.list', 'canceled') }}">@lang('Cancled Exchange')</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('user.withdraw') }}">
                    <i class="fas fa-wallet"></i>
                    @lang('Withdraw Money')
                </a>
            </li>
            <li>
                <a href="{{ route('user.withdraw.history') }}">
                    <i class="fas fa-file-invoice"></i>
                    @lang('Withdraw Log')
                </a>
            </li>
            <li>
                <a href="{{ route('user.affiliate.index') }}">
                    <i class="fas fa-users"></i>
                    @lang('Affiliation')
                </a>
            </li>
            <li>
                <a href="{{ route('user.report.commission.log') }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    @lang('Commission Logs')
                </a>
            </li>
            <li>
                <a href="{{ route('ticket.open') }}">
                    <i class="fas fa-ticket-alt"></i>
                    @lang('Create Ticket')
                </a>
            </li>
            <li>
                <a href="{{ route('ticket.index') }}">
                    <i class="fas fa-clipboard-list"></i>
                    @lang('My Tickets')
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="user-navbar">
    <button type="button" id="sidebar-open-btn" class="sidebar-open-btn bg-white border-0 d-lg-none d-inline-flex">
        <i class="fas fa-bars"></i>
    </button>

    @if(auth()->check())
    <h3 class="user-navbar-title d-lg-inline-block d-none">@lang('Welcome,') {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h3>
@endif
    <div class="user-navbar-right">
        <a href="{{ route('home') }}" class="back-btn">
            <span class="d-sm-inline-block d-none">@lang('Back to Home')</span>
            <span class="d-inline-block d-sm-none"><i class="fas fa-home"></i></span>
        </a>
        @if ($general->multi_language)
            <select class="select language langSel me-3">
                @foreach ($language as $lang)
                    <option value="{{ $lang->code }}" {{ session('lang') == $lang->code ? 'selected' : '' }}>
                        {{ __($lang->name) }}
                    </option>
                @endforeach
            </select>
        @endif
        <div class="dropdown">
            <button class="user-drop-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-alt"></i>
                @lang('Account')
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <a class="dropdown-item" href="{{ route('user.profile.setting') }}">
                        @lang('Profile Setting')
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('user.twofactor') }}">
                        @lang('2FA Security')
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.change.password') }}">
                        @lang('Change Password')
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.logout') }}">
                        @lang('Logout')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>