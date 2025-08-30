@extends('layouts.app')

@section('title', 'Sign in | Homeland News')
@section('canonical', route('login'))

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow border border-gray-100 p-6">
        <h1 class="text-xl font-bold mb-4">Sign in</h1>
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded p-3">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="post" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center justify-between">
                <label class="text-sm flex items-center gap-2">
                    <input type="checkbox" name="remember" value="1" class="rounded border-gray-300"> Remember me
                </label>
                <a href="{{ route('register') }}" class="text-sm text-blue-700 hover:underline">Create account</a>
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded-md">Sign in</button>
        </form>
    </div>
</div>
@endsection
