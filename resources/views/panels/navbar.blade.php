@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
    <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}"
        data-nav="brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav">
                <li class="nav-item">
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
                            </svg></span>
                        <h2 class="brand-text mb-0">Rumen L@b</h2>
                    </a>
                </li>
            </ul>
        </div>
    @else
        <nav
            class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
@endif
<div class="navbar-container d-flex content">
    <div class="bookmark-wrapper d-flex align-items-center">
        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                        data-feather="menu"></i></a></li>
        </ul>
        <ul class="nav navbar-nav bookmark-icons">
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ url('/') }}"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home"><i class="ficon"
                        data-feather="home"></i></a></li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ url('/users') }}"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Usuários"><i class="ficon"
                        data-feather="user"></i></a></li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ url('/') }}"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calendar"><i class="ficon"
                        data-feather="calendar"></i></a></li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ url('/') }}"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Todo"><i class="ficon"
                        data-feather="check-square"></i></a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="nav-item d-none d-lg-block">
                <a class="nav-link bookmark-star">
                    <i class="ficon text-warning" data-feather="star"></i>
                </a>
                <div class="bookmark-input search-input">
                    <div class="bookmark-input-icon">
                        <i data-feather="search"></i>
                    </div>
                    <input class="form-control input" type="text" placeholder="Bookmark" tabindex="0"
                        data-search="search">
                    <ul class="search-list search-list-bookmark"></ul>
                </div>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav align-items-center ms-auto">

        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                    data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i></a></li>
        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon"
                    data-feather="search"></i></a>
            <div class="search-input">
                <div class="search-input-icon"><i data-feather="search"></i></div>
                <input class="form-control input" type="text" placeholder="Explore Rumen L@b..." tabindex="-1"
                    data-search="search">
                <div class="search-input-close"><i data-feather="x"></i></div>
                <ul class="search-list search-list-main"></ul>
            </div>
        </li>


        <li class="nav-item dropdown dropdown-user">
            <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                data-bs-toggle="dropdown" aria-haspopup="true">
                <div class="user-nav d-sm-flex d-none">
                    <span class="user-name fw-bolder">
                        @if (Auth::check())
                            {{ Auth::user()->name }}
                        @else
                            Sem Nome
                        @endif
                    </span>
                    <span class="user-status">
                        {{ Auth::user()->getRoleNames()[0] }}
                    </span>
                </div>
                <span class="avatar">
                    <img class="round" src="{{ asset('avatar/' . Auth::user()->avatar) }}" alt="avatar"
                        height="40" width="40">
                    <span class="avatar-status-online"></span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                <h6 class="dropdown-header">{{ __('locale.User Settings') }}</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('minha-conta') }}">
                    <i class="me-50" data-feather="user"></i> {{ __('locale.Profile') }}
                </a>

                <a class="dropdown-item" href="{{ route('sair') }}">
                    <i class="me-50" data-feather="power"></i> Sair
                </a>


            </div>
        </li>
    </ul>
</div>
</nav>

{{-- Search Start Here --}}
<ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center">
        <a href="javascript:void(0);">
            <h6 class="section-label mt-75 mb-0">Files</h6>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
            <div class="d-flex">
                <div class="me-75">
                    <img src="{{ asset('images/icons/xls.png') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p>
                    <small class="text-muted">Marketing Manager</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;17kb</small>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
            <div class="d-flex">
                <div class="me-75">
                    <img src="{{ asset('images/icons/jpg.png') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p>
                    <small class="text-muted">FontEnd Developer</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;11kb</small>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
            <div class="d-flex">
                <div class="me-75">
                    <img src="{{ asset('images/icons/pdf.png') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p>
                    <small class="text-muted">Digital Marketing Manager</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;150kb</small>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between w-100" href="{{ url('app/file-manager') }}">
            <div class="d-flex">
                <div class="me-75">
                    <img src="{{ asset('images/icons/doc.png') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p>
                    <small class="text-muted">Web Designer</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;256kb</small>
        </a>
    </li>
    <li class="d-flex align-items-center">
        <a href="javascript:void(0);">
            <h6 class="section-label mt-75 mb-0">Members</h6>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
            <div class="d-flex align-items-center">
                <div class="avatar me-75">
                    <img src="{{ asset('images/portrait/small/avatar-s-8.jpg') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">John Doe</p>
                    <small class="text-muted">UI designer</small>
                </div>
            </div>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
            <div class="d-flex align-items-center">
                <div class="avatar me-75">
                    <img src="{{ asset('images/portrait/small/avatar-s-1.jpg') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p>
                    <small class="text-muted">FontEnd Developer</small>
                </div>
            </div>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
            <div class="d-flex align-items-center">
                <div class="avatar me-75">
                    <img src="{{ asset('images/portrait/small/avatar-s-14.jpg') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p>
                    <small class="text-muted">Digital Marketing Manager</small>
                </div>
            </div>
        </a>
    </li>
    <li class="auto-suggestion">
        <a class="d-flex align-items-center justify-content-between py-50 w-100" href="{{ url('app/user/view') }}">
            <div class="d-flex align-items-center">
                <div class="avatar me-75">
                    <img src="{{ asset('images/portrait/small/avatar-s-6.jpg') }}" alt="png" height="32">
                </div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p>
                    <small class="text-muted">Web Designer</small>
                </div>
            </div>
        </a>
    </li>
</ul>

{{-- if main search not found! --}}
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between">
        <a class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start">
                <span class="me-75" data-feather="alert-circle"></span>
                <span>No results found.</span>
            </div>
        </a>
    </li>
</ul>
{{-- Search Ends --}}
<!-- END: Header-->
