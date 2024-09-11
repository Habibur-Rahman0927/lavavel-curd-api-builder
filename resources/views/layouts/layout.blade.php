@extends('layouts/mainLayoutMaster')
@section('layoutContent')
    @include('layouts/sections/navbar/navbar')
    @include('layouts/sections/menu/menu')
    @yield('content')
    @include('layouts/sections/footer/footer')
@endsection
