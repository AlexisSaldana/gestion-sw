<x-guest-layout>
    @include("header")

    <div class="font-poppins">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
                <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="mb-8">
                            <h3 class="text-gray-800 text-3xl font-extrabold">Iniciar Sesión</h3>
                            <p class="text-gray-500 text-sm mt-4 leading-relaxed">Bienvenido a Care Center.</p>
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-800 text-sm mb-2 block" />
                            <div class="relative flex items-center">
                                <x-text-input id="email" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Ingresa tu correo" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Contraseña')" class="text-gray-800 text-sm mb-2 block" />
                            <div class="relative flex items-center">
                                <x-text-input id="password" class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 shrink-0 text-cyan-700 focus:ring-cyan-500 border-gray-300 rounded" />
                                <label for="remember_me" class="ml-3 block text-sm text-gray-800">
                                    {{ __('Recuérdame') }}
                                </label>
                            </div>

                            <div class="text-sm">
                                @if (Route::has('password.request'))
                                    <a class="text-cyan-700 hover:underline font-semibold" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="!mt-8">
                            <button class="w-full justify-center shadow-xl py-3 font-semibold tracking-wide rounded-xl text-white bg-cyan-700 hover:bg-cyan-900 focus:outline-none">
                                {{ __('Iniciar Sesión') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
                    <img src="{{ asset('img/login-image.webp') }}" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Logo de Care Center" />
                </div>
            </div>
        </div>
    </div>

    @include("footer")
</x-guest-layout>
