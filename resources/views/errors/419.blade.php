@extends('layouts.app')
@section('title', __('Page Expired'))
@section('content')
    <div class="text-center py-20" data-theme="dark">
        <h1 class="text-4xl font-bold mb-2 mt-8 text-white">419 - Page Expired</h1>
        <p class="text-lg mb-8 font-semibold text-white">This Page is expired, Please try to refresh or Contact Support</p>
        <a href="{{ url('/') }}" class="btn color3 text-white mb-8">Go back to Home</a>
    </div>
    <x-footer></x-footer>
@endsection
