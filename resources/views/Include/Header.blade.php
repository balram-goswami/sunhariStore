@php
$data = siteSetting();
@endphp

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $data->meta_title ?? 'Sunhari'}}</title>
    <meta name="description" content="{{ $data->meta_description ?? 'Sunhari -  Where Tradition Shines' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"
        href="{{ $data && $data->favicon ? asset('storage/' . $data->favicon) : asset('assets/img/icons/3.png') }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('Include.Style')

</head>

<body class="template-index belle template-index-belle">
    <!-- <div id="pre-loader">
        <img src="themeAssets/images/loader.gif" alt="Loading..." />
    </div> -->
    <div class="pageWrapper">
        <!--Search Form Drawer-->
        <div class="search">
            <div class="search__form">
                <form class="search-bar__form" action="#">
                    <button class="go-btn search__button" type="submit"><i class="icon anm anm-search-l"></i></button>
                    <input class="search__input" type="search" name="q" value=""
                        placeholder="Search entire store..." aria-label="Search" autocomplete="off">
                </form>
                <button type="button" class="search-trigger close-btn"><i class="anm anm-times-l"></i></button>
            </div>
        </div>

        @include('Include.Menu')