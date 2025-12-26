<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            
            <!-- MODIFIED: Ditambahkan 'disabled' dan 'bg-gray-100' untuk menonaktifkan field email -->
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-100" :value="old('email', $user->email)" required autocomplete="username" disabled />
            
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <!-- DITAMBAHKAN: Info Kontak Admin -->
            <div class="mt-6 rounded-lg bg-gray-50 p-6 border-l-4 border-purple-500 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <!-- Placeholder Foto Anda -->
                        <img class="h-20 w-20 rounded-full object-cover border-4 border-purple-200" src="https://placehold.co/80x80/E9D5FF/8B5CF6?text=UA" alt="Lord Ustadz ARIF">
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">
                            Untuk mengubah email, silakan hubungi Admin:
                        </p>
                        <p class="text-lg font-bold text-gray-900 mt-1">
                            Lord Ustadz ARIF
                        </p>
                        <p class="text-md font-medium text-purple-600">
                            081391023867
                        </p>
                    </div>
                </div>
            </div>
            <!-- AKHIR TAMBAHAN -->


            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>