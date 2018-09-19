<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Internet Banking - @yield('title')</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        @include('layouts.topbar')
        @include('layouts.header-dash')
        <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        @include('layouts.sidebar')
                    </div>
                    <div class="col-md-8">
                            <div class="panel panel-admin panel-default">
                                <div class="panel-heading">
                                    <h1>@yield('heading-title')</h1></div>
                
                                <div class="panel-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @include('layouts.footer')
    </div>

