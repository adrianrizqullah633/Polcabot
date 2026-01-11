@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

@section('content')
<div class="landing-page" id="landingPage">
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="PolCaBot Logo">
            <span>
                <span style="color:white;">P</span><span style="color:orange;">o</span><span style="color:white;">l</span><span style="color:#1e90ff;">CaBot</span>
            </span>
        </div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        
        <!-- Tombol Sign In (tampil kalau BELUM login) -->
        @guest
            <a href="{{ route('login') }}" class="btn-signin">Sign In</a>
        @endguest

        <!-- Tombol Logout (tampil kalau SUDAH login) -->
        @auth
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-signin" style="background: #dc3545; border: none; cursor: pointer;">Logout</button>
            </form>
        @endauth
    </nav>

    @yield('landing-content')

    <footer>
        <p>© 2025 PolCaBot. All rights reserved.</p>
        <ul>
            <li><a href="#">UI Design</a></li>
            <li><a href="#">UX Design</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Best Practices</a></li>
        </ul>
    </footer>
</div>
@endsection