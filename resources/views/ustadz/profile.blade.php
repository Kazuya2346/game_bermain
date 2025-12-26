@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profile Information
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Success Message --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Profile Information Card --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- Profile Photo Section --}}
                    <div class="mb-6 flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                     alt="Profile Photo" 
                                     class="w-24 h-24 rounded-full object-cover border-4 border-teal-500">
                            @else
                                <div class="w-24 h-24 rounded-full bg-purple-200 flex items-center justify-center border-4 border-teal-500">
                                    <span class="text-4xl font-bold text-purple-600">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                            <input type="file" 
                                   name="profile_photo" 
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-teal-50 file:text-teal-700
                                          hover:file:bg-teal-100
                                          cursor-pointer">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, or GIF (MAX. 2MB)</p>
                        </div>
                    </div>

                    <hr class="my-6">

                    {{-- Name Field --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', Auth::user()->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               required>
                    </div>

                    {{-- Email Field --}}
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', Auth::user()->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               required>
                    </div>

                    {{-- Role Display (Read-only) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700">
                            @if(Auth::user()->role == 'ustadz')
                                🧑‍🏫 Ustadz
                            @elseif(Auth::user()->role == 'ustadzah')
                                👩‍🏫 Ustadzah
                            @else
                                {{ ucfirst(Auth::user()->role) }}
                            @endif
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-purple-800 mb-2">Untuk mengubah email, silakan hubungi Admin:</h3>
                        <p class="text-purple-700">
                            <strong>Lord Ustadz ARIF</strong><br>
                            📞 <a href="tel:081391023867" class="hover:underline">081391023867</a>
                        </p>
                    </div>

                    {{-- Save Button --}}
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                            SAVE
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password Card --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Update Password</h2>
                <p class="text-gray-600 mb-6">Ensure your account is using a long, random password to stay secure.</p>

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Current Password --}}
                    <div class="mb-6">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               required>
                    </div>

                    {{-- New Password --}}
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               required>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               required>
                    </div>

                    {{-- Save Password Button --}}
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                            UPDATE PASSWORD
                        </button>
                    </div>
                </form>
            </div>

            {{-- Back to Dashboard --}}
            <div class="mt-6">
                <a href="{{ route('ustadz.dashboard') }}" 
                   class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Dashboard
                </a>
            </div>

        </div>
    </div>
@endsection