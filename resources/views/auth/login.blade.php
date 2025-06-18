@extends('layouts.auth')

@section('title', 'เข้าสู่ระบบ')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">เข้าสู่ระบบ</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">อีเมล</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">รหัสผ่าน</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        จดจำฉัน
                    </label>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    เข้าสู่ระบบ
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                ยังไม่มีบัญชี? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">ลงทะเบียน</a>
            </p>
        </div>
    </div>
@endsection