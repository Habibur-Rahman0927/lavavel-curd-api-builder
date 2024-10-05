<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title') | Dashboard - Admin Bootstrap Template</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts/sections/styles')
</head>

<body>


    @yield('layoutContent')



    @include('layouts/sections/scripts')
</body>

</html>
