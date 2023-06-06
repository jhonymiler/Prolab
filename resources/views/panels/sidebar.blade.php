@php
    $configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{ $configData['theme'] === 'dark' || $configData['theme'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow"
    data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="brand-logo">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" height="28"
                            viewBox="0 0 81.000000 90.000000" preserveAspectRatio="xMidYMid meet">

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
                    <h2 class="brand-text">Rumen L@b</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
                        data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Foreach menu item starts --}}

            @if (isset($menuData[0]))
                @foreach ($menuData[0]->menu as $menu)
                    @if (isset($menu->navheader))
                        <li class="navigation-header">
                            <span>{{ $menu->navheader }}</span>
                            <i data-feather="more-horizontal"></i>
                        </li>
                    @else
                        {{-- Add Custom Class with nav-item --}}
                        @php
                            $custom_classes = '';
                            if (isset($menu->classlist)) {
                                $custom_classes = $menu->classlist;
                            }

                            if ($menu->slug != '' && preg_match("/($menu->slug)+/", Route::currentRouteName())) {
                                $active = 'active';
                            } else {
                                $active = '';
                            }
                        @endphp
                        @if (isset($menu->permission))
                            @php $permissoes = []; @endphp
                            @foreach ($menu->permission as $permissao)
                                @foreach (['criar', 'editar', 'ler', 'deletar'] as $per)
                                    @php $permissoes[] = $per . ' ' . $permissao; @endphp
                                @endforeach
                            @endforeach
                            @canany($permissoes)
                                <li class="nav-item {{ $custom_classes }} {{ $active }} {{ $menu->slug }}">
                                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0)' }}"
                                        class="d-flex align-items-center"
                                        target="{{ isset($menu->newTab) ? '_blank' : '_self' }}"
                                        title="{{ $menu->name }}">
                                        <i data-feather="{{ $menu->icon }}"></i>
                                        <span class="menu-title text-truncate">{{ $menu->name }}</span>
                                        @if (isset($menu->badge))
                                            <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                                            <span
                                                class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                                        @endif
                                    </a>
                                    @if (isset($menu->submenu))
                                        @include('panels/submenu', ['menu' => $menu->submenu])
                                    @endif
                                </li>
                            @endcanany
                        @else
                            <li class="nav-item {{ $custom_classes }} {{ $active }} {{ $menu->slug }}">
                                <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0)' }}"
                                    class="d-flex align-items-center"
                                    target="{{ isset($menu->newTab) ? '_blank' : '_self' }}"
                                    title="{{ $menu->name }}">
                                    <i data-feather="{{ $menu->icon }}"></i>
                                    <span class="menu-title text-truncate">{{ $menu->name }}</span>
                                    @if (isset($menu->badge))
                                        <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                                        <span
                                            class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                                    @endif
                                </a>
                                @if (isset($menu->submenu))
                                    @include('panels/submenu', ['menu' => $menu->submenu])
                                @endif
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
            {{-- Foreach menu item ends --}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
