@extends('layouts.app')
@section('title', __('Internal Server Error'))
@section('content')
    <div class="text-center py-20" data-theme="dark">
        <h1 class="text-4xl font-bold mb-2 mt-8 text-white">500 - Internal Server Error</h1>
        <p class="text-lg mb-8 font-semibold text-white">Sorry, There is problem with our server, try to come back later</p>
        <a href="{{ url('/') }}" class="btn color3 text-white mb-8">Go back to Home</a>
    </div>
    <x-footer></x-footer>
@endsection
