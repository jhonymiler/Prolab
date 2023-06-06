@if (isset($pageConfigs))
    {!! Helper::updatePageConfig($pageConfigs) !!}
@else
    {!! Helper::updatePageConfig([]) !!}
@endif

<!DOCTYPE html>
@php $configData = Helper::applClasses(); @endphp

<html class="loading {{ $configData['theme'] === 'light' ? '' : $configData['layoutTheme'] }}"
    lang="{{ App::currentLocale() ? App::currentLocale() : $configData['defaultLanguage'] }}"
    data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
    @if ($configData['layoutTheme'] === 'semi-dark') data-layout="semi-dark-layout" @else data-layout="{{ $configData['layoutTheme'] }}" @endif>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Rumen L@b admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Rumen L@b admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') - Rumen L@b</title>
    <link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')
</head>

@isset($configData['mainLayoutType'])
    @extends($configData['mainLayoutType'] === 'horizontal' ? 'layouts.horizontalDetachedLayoutMaster' : 'layouts.verticalDetachedLayoutMaster')
@endisset
