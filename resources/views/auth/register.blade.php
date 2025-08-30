@extends('layouts.app')

@section('title', 'Create account | Homeland News')
@section('canonical', route('register'))

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow border border-gray-100 p-6">
        <h1 class="text-xl font-bold mb-4">Create account</h1>
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded p-3">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="post" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium mb-1">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded-md">Create account</button>
            <p class="text-sm text-gray-600 mt-2">Already have an account? <a href="{{ route('login') }}" class="text-blue-700 hover:underline">Sign in</a></p>
        </form>
    </div>
</div>
@endsection
