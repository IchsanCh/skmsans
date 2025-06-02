@extends('layouts.app')
@section('title', __('Too Many Requests'))
@section('content')
    <div class="text-center py-20" data-theme="dark">
        <h1 class="text-4xl font-bold mb-2 mt-8 text-white">429 - Too Many Request</h1>
        <p class="text-lg mb-8 font-semibold text-white">Sorry, Too many request. You can visit this page another time</p>
        <a href="{{ url('/') }}" class="btn color3 text-white mb-8">Go back to Home</a>
    </div>
    <x-footer></x-footer>
@endsection
