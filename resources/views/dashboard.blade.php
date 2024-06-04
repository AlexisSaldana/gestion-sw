<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} {{ Auth::user()->rol }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <!-- Table -->
                        <table class="min-w-full text-left text-sm whitespace-nowrap">

                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombres</th>
                                    <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4">Fecha de Nacimiento</th>
                                    <th scope="col" class="px-6 py-4">Activo</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr class="border-b dark:border-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-600 @if($loop->odd) bg-neutral-50 dark:bg-neutral-800 @endif">
                                        <td class="px-6 py-4">{{ $paciente->nombres }}</td>
                                        <td class="px-6 py-4">{{ $paciente->apepat }}</td>
                                        <td class="px-6 py-4">{{ $paciente->apemat }}</td>
                                        <td class="px-6 py-4">{{ $paciente->fechanac }}</td>
                                        <td class="px-6 py-4">{{ $paciente->activo }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
