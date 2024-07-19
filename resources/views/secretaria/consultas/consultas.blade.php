<x-app-layout>
    <div class="pt-5">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Consultas</h1>
                        </div>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('consultas.index') }}" class="flex my-4 mx-4 items-center">
                            <div class="flex text-center border rounded-md items-center px-2">
                                <input type="text" name="busqueda" placeholder="Buscar usuario" class="border-0" value="{{ request('busqueda') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray" class="size-5">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="date" name="fecha" class="border-0" value="{{ request('fecha') }}">
                            <select name="estado" class="ml-4 px-4 py-2 border rounded-md">
                                <option value="">Todos las consultas</option>
                                <option value="en proceso" {{ request('estado') == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                                <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizadas</option>
                            </select>
                            <button type="submit" class="ml-4 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                                Buscar
                            </button>
                            <button type="reset" onclick="window.location='{{ route('consultas.index') }}'" class="ml-4 px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
                                Reiniciar
                            </button>
                        </form>

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
                                    @if(auth()->user()->hasRole(['medico']))
                                        <th scope="col" class="px-6 py-4">Acciones</th>
                                        <th scope="col" class="px-6 py-4">Descargar PDF</th>
                                    @endif
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

                                        @if(auth()->user()->hasRole(['medico']))
                                            <td class="px-6 py-4">
                                                @if($cita->consulta)
                                                    <a href="{{ route('consultas.edit', ['id' => $cita->consulta->id]) }}" class="text-blue-500 hover:text-blue-700">Editar Consulta</a>
                                                @else
                                                    <a href="{{ route('consultas.create', ['citaId' => $cita->id]) }}" class="text-blue-500 hover:text-blue-700">Tomar Consulta</a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($cita->consulta)
                                                    <a href="{{ route('consultas.download', ['id' => $cita->consulta->id]) }}" class="text-green-500 hover:text-green-700">Descargar PDF</a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay citas registradas -->
                        @if($citas->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay consultas pendientes.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
