@extends('layouts.app')
@section('title', __('Maintenance Mode'))
@section('content')
    <div class="flex flex-col justify-center items-center pb-6" data-theme="dark">
        <img src="https://www.svgrepo.com/show/426192/cogs-settings.svg" alt="Logo" class="mb-8 h-40 animate-pulse mt-4">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-center text-white mb-4">Site is under
            maintenance</h1>
        <p class="text-center text-white text-lg md:text-xl lg:text-2xl mb-8">We're working hard to
            improve the user experience. Stay tuned!</p>
        <div class="flex space-x-4">
            <a href="{{ url('/') }}" class="font-semibold btn rounded color3 text-white">Go
                Back to Home
            </a>
        </div>
    </div>
    <x-footer></x-footer>
@endsection
