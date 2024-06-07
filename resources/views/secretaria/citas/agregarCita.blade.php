<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('citas.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <!-- Fecha -->
                <div class="mt-4">
                    <x-input-label for="fecha" :value="__('Fecha')" />
                    <x-text-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" :value="old('fecha')" required autofocus />
                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                </div>

                <!-- Hora -->
                <div class="mt-4">
                    <x-input-label for="hora" :value="__('Hora')" />
                    <x-text-input id="hora" class="block mt-1 w-full" type="time" name="hora" :value="old('hora')" required autofocus />
                    <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                </div>

                <!-- Paciente -->
                <div class="mt-4">
                    <x-input-label for="pacienteid" :value="__('Paciente')" />
                    <select id="pacienteid" name="pacienteid" class="block mt-1 w-full" required>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" {{ old('pacienteid') == $paciente->id ? 'selected' : '' }}>
                                {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pacienteid')" class="mt-2" />
                </div>

                <!-- Usuario Médico -->
                <div class="mt-4">
                    <x-input-label for="usuariomedicoid" :value="__('Usuario Médico')" />
                    <select id="usuariomedicoid" name="usuariomedicoid" class="block mt-1 w-full" required>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuariomedicoid') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombres }} {{ $usuario->apepat }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('usuariomedicoid')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Registrar Cita') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
