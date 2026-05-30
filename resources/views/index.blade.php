@extends('layout.landing_page.main')

@section('title', 'Beranda - Milkyway')

@section('content')
    @include('layout.landing_page.hero')
    @include('layout.landing_page.about')
    @include('layout.landing_page.product')
    @include('layout.landing_page.benefit')
    @include('layout.landing_page.testimoni')
@endsection