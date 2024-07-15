<x-app-layout>
<div class="pt-5">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                    <div class="flex my-4 mx-4 items-center justify-between">
                        <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Consultas Pendientes</h1>
                    </div>
                    <!-- Table -->
                    <table class="min-w-full text-center text-sm whitespace-nowrap">
                        <!-- Table head -->
                        <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                            <tr>
                                <th scope="col" class="px-6 py-4">Médico</th>
                                <th scope="col" class="px-6 py-4">Paciente</th>
                                <th scope="col" class="px-6 py-4">Fecha</th>
                                <th scope="col" class="px-6 py-4">Hora</th>
                                <th scope="col" class="px-6 py-4">Estado</th>
                                <th scope="col" class="px-6 py-4">Acciones</th>
                            </tr>
                        </thead>

                        <!-- Table body -->
                        <tbody>
                            @foreach($citas as $cita)
                                <tr>
                                    <td class="px-6 py-4">{{ $cita->usuarioMedico->nombres }} {{ $cita->usuarioMedico->apepat }}</td>
                                    <td class="px-6 py-4">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                    <td class="px-6 py-4">{{ $cita->fecha }}</td>
                                    <td class="px-6 py-4">{{ $cita->hora }}</td>
                                    <td class="px-6 py-4">
                                        @if($cita->consulta)
                                            <span class="{{ $cita->consulta->estado == 'Finalizado' ? 'text-red-500 rounded p-1 bg-red-50' : 'text-yellow-500 rounded p-1 bg-yellow-50' }}">
                                                {{ $cita->consulta->estado }}
                                            </span>
                                        @else
                                            <span class="text-yellow-500 rounded p-1 bg-yellow-50">En proceso</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($cita->consulta)
                                            <a href="{{ route('consultas.edit', ['id' => $cita->consulta->id]) }}" class="text-blue-500 hover:text-blue-700">Editar Consulta</a>
                                        @else
                                            <a href="{{ route('consultas.create', ['citaId' => $cita->id]) }}" class="text-blue-500 hover:text-blue-700">Tomar Consulta</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Mensaje si no hay citas registradas -->
                    @if($citas->isEmpty())
                        <p class="text-center text-gray-500 mt-4">No hay citas pendientes.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
