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
                    <select id="hora" name="hora" class="block mt-1 w-full" required autofocus>
                        <option value="" disabled selected>Selecciona una hora</option>
                        @for ($i = 8; $i <= 14; $i++)
                            @php
                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $time1 = $hour . ':00';
                                $time2 = $hour . ':30';
                            @endphp
                            <option value="{{ $time1 }}" {{ old('hora') == $time1 ? 'selected' : '' }}>
                                {{ $time1 }}
                            </option>
                            @if($i < 16)
                                <option value="{{ $time2 }}" {{ old('hora') == $time2 ? 'selected' : '' }}>
                                    {{ $time2 }}
                                </option>
                            @endif
                        @endfor
                    </select>
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

        <div id="calendar"></div>
    </x-guest-layout>
</x-app-layout>
