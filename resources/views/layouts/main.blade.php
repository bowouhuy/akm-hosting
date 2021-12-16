<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Linum</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    {{-- Include core + vendor Styles --}}
    @include('layouts/components/styles')

</head>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<div id="app">
    <!-- BEGIN: Content-->
    {{-- Include Sidebar --}}
    @include('layouts/components/sidebar')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <!-- BEGIN: Header-->
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        {{-- Include Navbar --}}
        @include('layouts/components/navbar')

        <div class="content-wrapper">
            {{-- Include Breadcrumb --}}
            <div class="content-body">
                {{-- Include Page Content --}}
                @yield('content')
            </div>
        </div>

    </div>
    <!-- End: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    {{-- include footer --}}
    @include('layouts/components/footer')

    {{-- include default scripts --}}
    @include('layouts/components/js')
</div>
</body>
</html>
