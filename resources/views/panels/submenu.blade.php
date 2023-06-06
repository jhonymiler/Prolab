{{-- For submenu --}}
<ul class="menu-content">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            @php
                if ($submenu->slug != '' && preg_match("/($submenu->slug)+/", Route::currentRouteName())) {
                    $active = 'active';
                } else {
                    $active = '';
                }

            @endphp

            @if (isset($submenu->permission))
                @canany($submenu->permission)
                    <li class="{{ $active }}" slug="{{ Route::currentRouteName() }}">
                        <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                            class="d-flex align-items-center"
                            target="{{ isset($submenu->newTab) && $submenu->newTab === true ? '_blank' : '_self' }}"
                            title="{{ $submenu->name }}">
                            @if (isset($submenu->icon))
                                <i data-feather="{{ $submenu->icon }}"></i>
                            @endif
                            <span class="menu-item text-truncate">{{ $submenu->name }}</span>
                        </a>
                        @if (isset($submenu->submenu))
                            @include('panels/submenu', ['menu' => $submenu->submenu])
                        @endif
                    </li>
                @endcanany
            @else
                <li class="{{ $active }}" slug="{{ Route::currentRouteName() }}">
                    <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                        class="d-flex align-items-center"
                        target="{{ isset($submenu->newTab) && $submenu->newTab === true ? '_blank' : '_self' }}"
                        title="{{ $submenu->name }}">
                        @if (isset($submenu->icon))
                            <i data-feather="{{ $submenu->icon }}"></i>
                        @endif
                        <span class="menu-item text-truncate">{{ $submenu->name }}</span>
                    </a>
                    @if (isset($submenu->submenu))
                        @include('panels/submenu', ['menu' => $submenu->submenu])
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>
