@extends('dashboard')

@section('title', 'Profile - ' . config('app.name'))

@section('container')

    <!-- Topbar -->
    <div class="topbar">
        <button class="menu-toggle" id="menuToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search data"/>
        </div>
        <div class="topbar-right">
            <div class="topbar-icon">
                <i class="bi bi-bell"></i>
                <span class="badge-dot"></span>
            </div>
            <div class="topbar-icon">
                <i class="bi bi-question-circle"></i>
            </div>
            <div class="user-chip">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <span class="user-chip-name">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>

    <!-- Page -->
    <div class="page">

        <div class="page-header">
            <h2>Profile <span class="page-name">Settings</span></h2>
            <p class="page-desc">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        <div class="row g-4">

            {{-- Update Profile Information --}}
            <div class="col-12 col-lg-8">
                <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Update Password --}}
                <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
                    @include('profile.partials.update-password-form')
                </div>

                {{-- Delete Account --}}
                <div class="bg-white rounded-3 shadow-sm p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>

    </div><!-- /page -->

@endsection
