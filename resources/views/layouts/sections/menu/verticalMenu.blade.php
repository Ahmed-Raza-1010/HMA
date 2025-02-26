@php
    $configData = Helper::appClasses();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                    {{-- @include('_partials.macros', ['height' => 20]) --}}
                    <img src="{{ asset('assets/img/tmh-icons/medicine.png') }}" alt="TMH Logo"
                        style="height: 20px; width: 20px;">
                </span>
                <span class="app-brand-text demo menu-text fw-bold">TMH</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
            </a>
        </div>
    @endif

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item @if (str_contains(Request::fullUrl(), '/dashboard')) active @endif">
            <a href="{{ url('/dashboard') }}"
                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                <i class="menu-icon tf-icons ti ti-smart-home"> </i>
                <div>Dashboard</div>
                @isset($menu->badge)
                    <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                @endisset
            </a>
        </li>
        <li class="menu-item @if (str_contains(Request::fullUrl(), '/edit/password')) active @endif">
            <a href="{{ url('/edit/password/' . Auth::user()->id) }}"
                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                <i class="menu-icon tf-icons ti ti-user-circle"> </i>
                <div>My Profile</div>
                @isset($menu->badge)
                    <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                @endisset
            </a>
        </li>
        @if (Auth::check() && Auth::user()->can('manage patients'))
            <li class="menu-item @if (str_contains(Request::fullUrl(), '/patients') ||
                    str_contains(Request::fullUrl(), '/create/patient') ||
                    str_contains(Request::fullUrl(), '/edit/patient/') ||
                    str_contains(Request::fullUrl(), '/view/patient/')) active @endif">
                <a href="{{ url('/patients') }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                    <i class="menu-icon tf-icons ti ti-heart-rate-monitor"> </i>
                    <div>Patient Management</div>
                    @isset($menu->badge)
                        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                    @endisset
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->can('manage opd'))
            <li class="menu-item @if (str_contains(Request::fullUrl(), '/opd-cases') ||
                    str_contains(Request::fullUrl(), '/create/opd-case') ||
                    str_contains(Request::fullUrl(), '/edit/opd-case/') ||
                    str_contains(Request::fullUrl(), '/view/opd-case/')) active @endif">
                <a href="{{ url('/opd-cases') }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                    <i class="menu-icon tf-icons ti ti-first-aid-kit"> </i>
                    <div>OPD</div>
                    @isset($menu->badge)
                        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                    @endisset
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->can('manage ipd'))
            <li class="menu-item @if (str_contains(Request::fullUrl(), '/ipd-cases') ||
                    str_contains(Request::fullUrl(), '/create/ipd-case') ||
                    str_contains(Request::fullUrl(), '/edit/ipd-case/') ||
                    str_contains(Request::fullUrl(), '/view/ipd-case/')) active @endif">
                <a href="{{ url('/ipd-cases') }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                    <i class="menu-icon tf-icons ti ti-emergency-bed"> </i>
                    <div>IPD</div>
                    @isset($menu->badge)
                        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                    @endisset
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->can('manage notes'))
            <li class="menu-item @if (str_contains(Request::fullUrl(), '/operational-notes') ||
                    str_contains(Request::fullUrl(), '/create/operational-note') ||
                    str_contains(Request::fullUrl(), '/edit/operational-note/') ||
                    str_contains(Request::fullUrl(), '/view/operational-note/')) active @endif">
                <a href="{{ url('/operational-notes') }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                    <i class="menu-icon tf-icons ti ti-notes"> </i>
                    <div>Operational Notes</div>
                    @isset($menu->badge)
                        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                    @endisset
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->can('manage discharge'))
            <li class="menu-item @if (str_contains(Request::fullUrl(), '/discharge-plan') ||
                    str_contains(Request::fullUrl(), '/create/discharge-plan') ||
                    str_contains(Request::fullUrl(), '/edit/discharge-plan/') ||
                    str_contains(Request::fullUrl(), '/view/discharge-plan/')) active @endif">
                <a href="{{ url('/discharge-plan') }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                    <i class="menu-icon tf-icons ti ti-checkup-list"> </i>
                    <div>Discharge Plan</div>
                    @isset($menu->badge)
                        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                    @endisset
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->can('manage doctors'))
            <li class="menu-item @if (str_contains(Request::fullUrl(), '/doctors') ||
                    str_contains(Request::fullUrl(), '/create/doctor') ||
                    str_contains(Request::fullUrl(), '/edit/doctor/') ||
                    str_contains(Request::fullUrl(), '/view/doctor/')) active @endif">
                <a href="{{ url('/doctors') }}"
                    class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                    @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                    <i class="menu-icon tf-icons ti ti-users"> </i>
                    <div>Users</div>
                    @isset($menu->badge)
                        <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                    @endisset
                </a>
            </li>
        @endif
        {{-- @if (Auth::check() && Auth::user()->can('manage medicines')) --}}
        <li class="menu-item @if (str_contains(Request::fullUrl(), '/medicines') ||
                str_contains(Request::fullUrl(), '/create/medicine') ||
                str_contains(Request::fullUrl(), '/edit/medicine/')) active @endif">
            <a href="{{ url('/medicines') }}"
                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                <i class="menu-icon tf-icons ti ti-pill"> </i>
                <div>Medicines</div>
                @isset($menu->badge)
                    <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
                @endisset
            </a>
        </li>
        {{-- @endif --}}
    </ul>

</aside>
