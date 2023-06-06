@php
    $configData = Helper::applClasses();
@endphp
{{-- Horizontal Menu --}}
<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal
  {{ $configData['horizontalMenuClass'] }}
  {{ $configData['theme'] === 'dark' ? 'navbar-dark' : 'navbar-light' }}
  navbar-shadow menu-border
  {{ $configData['layoutWidth'] === 'boxed' && $configData['horizontalMenuType'] === 'navbar-floating' ? 'container-xxl' : '' }}"
        role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span class="brand-logo">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="81.000000pt"
                                height="90.000000pt" viewBox="0 0 81.000000 90.000000"
                                preserveAspectRatio="xMidYMid meet">

                                <g transform="translate(0.000000,90.000000) scale(0.100000,-0.100000)" fill="#01a08a"
                                    stroke="none">
                                    <path
                                        d="M390 820 c0 -35 18 -60 106 -151 117 -121 133 -167 94 -271 -14 -38
-31 -61 -59 -80 -45 -32 -63 -34 -85 -12 -24 24 -20 40 23 79 22 20 42 48 46
62 7 28 -11 93 -26 93 -5 0 -9 5 -9 11 0 6 -36 47 -80 90 -64 63 -83 88 -92
125 -7 26 -18 48 -24 51 -22 8 -119 -50 -166 -99 -180 -191 -120 -510 116
-618 66 -31 186 -50 186 -31 0 31 -35 83 -100 146 -95 93 -121 138 -121 210 0
81 52 161 122 187 21 8 59 -18 59 -39 0 -9 -21 -36 -46 -60 -46 -42 -46 -44
-42 -94 5 -47 10 -55 84 -129 84 -84 108 -118 127 -179 l12 -39 55 26 c72 35
149 112 186 187 26 55 29 69 29 165 0 96 -3 110 -29 165 -61 124 -172 203
-309 220 -54 7 -57 6 -57 -15z" />
                                </g>
                            </svg>
                        </span>
                        <h2 class="brand-text mb-0">Rumen L@b</h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                        <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                {{-- Foreach menu item starts --}}
                @if (isset($menuData[1]))
                    @foreach ($menuData[1]->menu as $menu)
                        @php
                            $custom_classes = '';
                            if (isset($menu->classlist)) {
                                $custom_classes = $menu->classlist;
                            }
                        @endphp
                        <li class="nav-item @if (isset($menu->submenu)) {{ 'dropdown' }} @endif {{ $custom_classes }} {{ Route::currentRouteName() === $menu->slug ? 'active' : '' }}"
                            @if (isset($menu->submenu)) {{ 'data-menu=dropdown' }} @endif>
                            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0)' }}"
                                class="nav-link d-flex align-items-center @if (isset($menu->submenu)) {{ 'dropdown-toggle' }} @endif"
                                target="{{ isset($menu->newTab) ? '_blank' : '_self' }}"
                                @if (isset($menu->submenu)) {{ 'data-bs-toggle=dropdown' }} @endif>
                                <i data-feather="{{ $menu->icon }}"></i>
                                <span>{{ __('locale.' . $menu->name) }}</span>
                            </a>
                            @if (isset($menu->submenu))
                                @include('panels/horizontalSubmenu', ['menu' => $menu->submenu])
                            @endif
                        </li>
                    @endforeach
                @endif
                {{-- Foreach menu item ends --}}
            </ul>
        </div>
    </div>
</div>
