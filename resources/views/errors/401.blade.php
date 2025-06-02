@extends('layouts.app')
@section('title', __('Unauthorized'))
@section('content')
    <div class="text-center py-20" data-theme="dark">
        <h1 class="text-4xl font-bold mb-2 mt-8 text-white">401 - Unauthorized</h1>
        <p class="text-lg mb-8 text-white">Sorry, you do not have permission to access this resource</p>
        <a href="{{ url('/') }}" class="btn color2 text-white mb-8">Go back to Home</a>
    </div>
    <x-footer></x-footer>
@endsection
