@extends('layouts.app')
@section('title', __('Payment Required'))
@section('content')
    <div class="text-center py-20" data-theme="dark">
        <h1 class="text-4xl font-bold mb-2 mt-8 text-white">402 - Payment Required</h1>
        <p class="text-lg mb-8 text-white">This page is required payment</p>
        <a href="{{ url('/') }}" class="btn color1 text-white mb-8">Go back to Home</a>
    </div>
    <x-footer></x-footer>
@endsection
