@extends('layouts.app')
@section('title', __('Forbidden'))
@section('content')
    <div class="text-center py-20" data-theme="dark">
        <h1 class="text-4xl font-bold mb-2 mt-8 text-white">403 - Forbidden</h1>
        <p class="text-lg mb-8 text-white">You do not have permission to access this resource</p>
        <a href="{{ url('/') }}" class="btn color1 text-white mb-8">Go back to Home</a>
    </div>
    <x-footer></x-footer>
@endsection
