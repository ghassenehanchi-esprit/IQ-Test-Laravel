<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('admin.dashboard') }}" class="sidebar__main-logo"><img src="{{ siteLogo('dark') }}" alt="@lang('image')"></a>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('admin.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>



                <li class="sidebar-menu-item  {{ menuActive('admin.categories') }}">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link" data-default-url="{{ route('admin.categories.index') }}}">
                        <i class="menu-icon las la-money-bill"></i>
                        <span class="menu-title">@lang('Manage Categories') </span>
                    </a>
                </li>
                <li class="sidebar-menu-item  {{ menuActive('admin.contact') }}">
                    <a href="{{ route('admin.contact.index') }}" class="nav-link" data-default-url="{{ route('admin.contact.index') }}}">
                        <i class="menu-icon las la-money-bill"></i>
                        <span class="menu-title">@lang('Manage Contacts') </span>
                    </a>
                </li>



                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.question*', 3) }}">
                        <i class="menu-icon las la-question-circle"></i>
                        <span class="menu-title">@lang('Questions')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.question*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.question.index') }} ">
                                <a href="{{ route('admin.question.index') }}" class="nav-link">
                                    <i class="menu-icon las la-list"></i>
                                    <span class="menu-title">@lang('All Questions')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.question.add') }} ">
                                <a href="{{ route('admin.question.add') }}" class="nav-link">
                                    <i class="menu-icon las la-plus-circle"></i>
                                    <span class="menu-title">@lang('Create Question')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.quiz.*', 3) }}">
                        <i class="menu-icon las la-question-circle"></i>
                        <span class="menu-title">@lang('Quiz')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.quiz*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.quiz.index') }} ">
                                <a href="{{ route('admin.quiz.index') }}" class="nav-link">
                                    <i class="menu-icon las la-list"></i>
                                    <span class="menu-title">@lang('All Paid Orders')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('admin.quiz.price') }} ">
                                <a href="" class="nav-link">
                                    <i class="menu-icon las la-plus-circle"></i>
                                    <span class="menu-title">@lang('Manage IQ Test Price')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>








                <li class="sidebar__menu-header">@lang('Settings')</li>

                <li class="sidebar-menu-item {{ menuActive('admin.setting.index') }}">
                    <a href="{{ route('admin.setting.index') }}" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title">@lang('General Setting')</span>
                    </a>
                </li>


                <li class="sidebar-menu-item {{ menuActive('admin.setting.system.configuration') }}">
                    <a href="{{ route('admin.setting.system.configuration') }}" class="nav-link">
                        <i class="menu-icon las la-cog"></i>
                        <span class="menu-title">@lang('System Configuration')</span>
                    </a>
                </li>




                <li class="sidebar-menu-item {{ menuActive('admin.setting.logo.icon') }}">
                    <a href="{{ route('admin.setting.logo.icon') }}" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title">@lang('Logo & Favicon')</span>
                    </a>
                </li>






                <li class="sidebar-menu-item {{ menuActive('admin.trustpilot.credentials') }}">
                    <a href="{{ route('admin.trustpilot.credentials') }}" class="nav-link">
                        <i class="menu-icon las la-comment"></i>
                        <span class="menu-title">@lang('Trustpilot Setting')</span>
                    </a>
                </li>


                <li class="sidebar__menu-header">@lang('Frontend Manager')</li>



                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.frontend.sections*', 3) }}">
                        <i class="menu-icon la la-puzzle-piece"></i>
                        <span class="menu-title">@lang('Manage Section')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.frontend.sections*', 2) }} ">
                        <ul>
                            @php
                                $lastSegment = collect(request()->segments())->last();
                            @endphp

                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header">@lang('Extra')</li>

                <li class="sidebar-menu-item {{ menuActive('admin.maintenance.mode') }}">
                    <a href="{{ route('admin.maintenance.mode') }}" class="nav-link">
                        <i class="menu-icon las la-robot"></i>
                        <span class="menu-title">@lang('Maintenance Mode')</span>
                    </a>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('admin.system*', 3) }}">
                        <i class="menu-icon la la-server"></i>
                        <span class="menu-title">@lang('System')</span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('admin.system*', 2) }} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('admin.system.info') }} ">
                                <a href="{{ route('admin.system.info') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Application')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.system.server.info') }} ">
                                <a href="{{ route('admin.system.server.info') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Server')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('admin.system.optimize') }} ">
                                <a href="{{ route('admin.system.optimize') }}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Cache')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item {{ menuActive('admin.setting.custom.css') }}">
                    <a href="{{ route('admin.setting.custom.css') }}" class="nav-link">
                        <i class="menu-icon lab la-css3-alt"></i>
                        <span class="menu-title">@lang('Custom CSS')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item  {{ menuActive('admin.request.report') }}">
                    <a href="{{ route('admin.request.report') }}" class="nav-link" data-default-url="{{ route('admin.request.report') }}">
                        <i class="menu-icon las la-bug"></i>
                        <span class="menu-title">@lang('Report & Request') </span>
                    </a>
                </li>
            </ul>
            <!--<div class="text-center mb-3 text-uppercase">-->
            <!--    <span class="text--primary">{{ __(systemDetails()['name']) }}</span>-->
            <!--    <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>-->
            <!--</div>-->
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
@endpush
