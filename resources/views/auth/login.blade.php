<x-guest-layout>
    <div class="relative w-full h-screen">

        <img src="{{ asset('images/sliders/slider3.jpg') }}" alt="foto" class="absolute inset-0 w-full h-full object-cover" />

        <div class="relative z-10 min-h-screen bg-[#FCD34D] bg-opacity-30 flex items-center justify-center px-4 left-0">

            <div class="w-full md:w-[50vw] h-[calc(100vh-2rem)] bg-white shadow-md rounded-xl px-7 md:px-32 py-6 flex flex-col justify-between">
                <div class="text-center mb-2">
                    <a href="{{ url('/') }}">
                        <div class="text-transparent bg-clip-text font-extrabold text-xl bg-gradient-to-r from-[#FCD34D] to-[#60A5FA]">
                            SIJA'26
                        </div>
                    </a>
                </div>

                <div>
                    <div class="text-center mb-8 text-4xl text-gray-800">Welcome Back!</div>
        
                    <x-validation-errors class="mb-4" />
        
                    @session('status')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ $value }}
                        </div>
                    @endsession
        
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
        
                        <div>
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>
        
                        <div class="block mt-4 flex items-center justify-between">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
        
                        <div class="flex items-center text-center justify-end mt-4">
                            <x-button class="w-full justify-center text-center inline-flex items-center px-4 py-2 bg-[#FCD34D] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-100 focus:bg-yellow-100 active:bg-[#FCD34D] focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="text-sm text-center text-gray-700 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-yellow-500 font-bold hover:underline">Register</a>
                </div>
            </div>

        </div>

    </div>
</x-guest-layout>
