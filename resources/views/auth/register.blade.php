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
                    <div class="text-center mb-8 text-4xl text-gray-800">Create an Account!</div>
        
                    <x-validation-errors class="mb-4" />
        
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
        
                        <div>
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        </div>
        
                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-4">
                                <x-label for="terms">
                                    <div class="flex items-center">
                                        <x-checkbox name="terms" id="terms" required />
        
                                        <div class="ms-2">
                                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif
        
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="w-full justify-center text-center inline-flex items-center px-4 py-2 bg-[#FCD34D] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-100 focus:bg-yellow-100 active:bg-[#FCD34D] focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                                {{ __('Register') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="text-sm text-center text-gray-700 mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-yellow-500 font-bold hover:underline">Login</a>
                </div>

            </div>
        </div>
   </div>
</x-guest-layout>
