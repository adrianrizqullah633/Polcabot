@extends('layouts.landing')

@section('title', 'PolCaBot - Home')

@section('landing-content')
    @include('components.home')
    @include('components.features')
    @include('components.about')
    @include('components.contact')
@endsection
