@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Login</h1>

        <div class="bg-white rounded-lg shadow-sm p-8 max-w-md">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-panrb-gold" required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-panrb-gold" required>
                </div>

                <button type="submit" class="w-full bg-panrb-blue hover:bg-panrb-blue-dark text-white font-semibold py-2.5 rounded-md transition-colors">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
