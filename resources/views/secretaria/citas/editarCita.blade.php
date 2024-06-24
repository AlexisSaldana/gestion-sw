<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('citas.update', $cita->id) }}">
            @csrf
            @method('PATCH')

            <!-- Fecha -->
            <div class="mt-4 col-span-2">
                <x-input-label for="fecha" :value="__('Fecha')" />
                <input id="fecha" class="block mt-1 w-full" type="date" name="fecha" x-model="event_date" required autofocus min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}" />
                <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
            </div>

            <!-- Hora -->
            <div class="mt-4">
                <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="hora">Hora</label>
                <select id="hora" name="hora" class="block mt-1 w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" x-model="event_time" required autofocus>
                    <option value="" disabled selected>Selecciona una hora</option>
                    @for ($i = 8; $i <= 14; $i++)
                        @php
                            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $time1 = $hour . ':00';
                            $time2 = $hour . ':30';
                        @endphp
                        <option value="{{ $time1 }}">{{ $time1 }}</option>
                        @if($i < 16)
                            <option value="{{ $time2 }}">{{ $time2 }}</option>
                        @endif
                    @endfor
                </select>
                @error('hora')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Paciente -->
            <div class="mt-4">
                <x-input-label for="pacienteid" :value="__('Paciente')" />
                <select id="pacienteid" name="pacienteid" class="block mt-1 w-full" required>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ $cita->pacienteid == $paciente->id ? 'selected' : '' }}>
                            {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('pacienteid')" class="mt-2" />
            </div>

            <!-- Usuario Médico (Oculto) -->
            <div class="mt-4">
                <x-input-label for="usuariomedicoid" :value="__('Usuario Médico')" />
                <x-text-input id="usuariomedicoid" class="block mt-1 w-full" type="hidden" name="usuariomedicoid" :value="$usuario->id" required />
                <x-text-input id="usuariomedicoid-display" class="block mt-1 w-full" type="text" :value="$usuario->nombres . ' ' . $usuario->apepat" readonly disabled />
                <x-input-error :messages="$errors->get('usuariomedicoid')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Actualizar Cita') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
