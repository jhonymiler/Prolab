@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Verify Email Cover')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-cover">
        <div class="auth-inner row m-0">
            <!-- Brand logo-->
            <a class="brand-logo" href="#">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" height="28" viewBox="0 0 81.000000 90.000000"
                    preserveAspectRatio="xMidYMid meet">

                    <g transform="translate(0.000000,90.000000) scale(0.100000,-0.100000)" fill="#01a08a" stroke="none">
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
                <h2 class="brand-text text-primary ms-1">Rumen L@b</h2>
            </a>
            <!-- /Brand logo-->

            <!-- Left Text-->
            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    @if ($configData['theme'] === 'dark')
                        <img src="{{ asset('images/illustration/verify-email-illustration-dark.svg') }}" class="img-fluid"
                            alt="two steps verification" />
                    @else
                        <img src="{{ asset('images/illustration/verify-email-illustration.svg') }}" class="img-fluid"
                            alt="two steps verification" />
                    @endif
                </div>
            </div>
            <!-- /Left Text-->

            <!-- verify email cover-->
            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                    <h2 class="card-title fw-bolder mb-1">Verify your email &#x2709;&#xFE0F;</h2>
                    <p class="card-text mb-2">Account activation link sent to your email address:<span class="fw-bolder">
                            hello@pixinvent.com</span> Please follow the link inside to continue.</p>
                    <a class="btn btn-primary w-100" href="{{ asset('/') }}">Skip for now</a>
                    <p class="text-center mt-2"><span>Didn&apos;t receive an email?</span>
                        <a href="Javascript:void(0)"><span>&nbsp;Resend</span></a>
                    </p>
                </div>
            </div>
            <!-- verify email cover-->
        </div>
    </div>
@endsection
