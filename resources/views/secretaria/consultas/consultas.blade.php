<x-app-layout>
    <div class="pt-5 mx-5">
        <div class="max-w-full mx-auto">
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

                        <!-- Tabla de Consultas -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    @if(auth()->user()->hasRole(['medico']))
                                        <th scope="col" class="px-6 py-4"></th>
                                    @endif
                                    <th scope="col" class="px-6 py-4">Médico</th>
                                    <th scope="col" class="px-6 py-4">Paciente</th>
                                    <th scope="col" class="px-6 py-4">Fecha</th>
                                    <th scope="col" class="px-6 py-4">Hora</th>
                                    <th scope="col" class="px-6 py-4">Estado</th>
                                    @if(auth()->user()->hasRole(['medico']))
                                        <th scope="col" class="px-6 py-4">Acciones</th>
                                        <th scope="col" class="px-6 py-4">Descargar PDF</th>
                                        <th scope="col" class="px-6 py-4">Código</th>
                                    @endif
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($citas as $cita)
                                    <tr>
                                        @if(auth()->user()->hasRole(['medico']))
                                            <td class="px-6 py-4">
                                                @if($cita->consulta)
                                                    <button type="button" class="text-blue-500 hover:text-blue-700" onclick="showDetailsModal({{ $cita->consulta->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </td>
                                        @endif
                                        <td class="px-6 py-4">{{ $cita->usuarioMedico->nombres }} {{ $cita->usuarioMedico->apepat }}</td>
                                        <td class="px-6 py-4">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat . " (" . $cita->paciente->telefono . ")" }}</td>
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
                                                    @if($cita->consulta->estado == 'Finalizado')
                                                        <span class="text-green-500">Pagado</span>
                                                    @else
                                                        <a href="{{ route('consultas.edit', ['id' => $cita->consulta->id]) }}" class="text-blue-500 hover:text-blue-700">Editar Consulta</a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('consultas.create', ['citaId' => $cita->id]) }}" class="text-blue-500 hover:text-blue-700">Tomar Consulta</a>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4">
                                                @if($cita->consulta)
                                                    <a href="{{ route('consultas.descargarPorCodigo', ['codigo' => $cita->consulta->codigo]) }}" class="text-green-500 hover:text-green-700">Descargar PDF</a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($cita->consulta)
                                                    {{ $cita->consulta->codigo }}
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

    <!-- Background Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

    <!-- Modal -->
    <div id="detailsModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="text-center sm:mt-0 sm:text-left">
                            <h2 class="text-2xl text-cyan-500 mb-3 font-medium  flex items-center" id="modal-title">Detalles de la Consulta</h2>
                            <div class="mt-2">
                                <p class="text-sm text-gray-800 mb-1 tracking-wide" id="modal-content"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse">
                    <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="hideDetailsModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetailsModal(consultaId) {
            fetch(`/consultas/${consultaId}`)
                .then(response => response.json())
                .then(data => {
                    let modalContent = `
                        <p><strong>Médico:</strong> ${data.medico}</p>
                        <p><strong>Paciente:</strong> ${data.paciente}</p>
                        <p><strong>Enfermera:</strong> ${data.enfermera}</p>
                        <p><strong>Fecha:</strong> ${data.fecha}</p>
                        <p><strong>Hora:</strong> ${data.hora}</p>
                        <p><strong>Estado:</strong> ${data.estado}</p>
                        <p><strong>Motivo:</strong> ${data.motivo}</p>
                        <p><strong>Talla:</strong> ${data.talla}</p>
                        <p><strong>Temperatura:</strong> ${data.temperatura}</p>
                        <p><strong>Saturación de Oxígeno:</strong> ${data.saturacion_oxigeno}</p>
                        <p><strong>Frecuencia Cardíaca:</strong> ${data.frecuencia_cardiaca}</p>
                        <p><strong>Peso:</strong> ${data.peso}</p>
                        <p><strong>Tensión Arterial:</strong> ${data.tension_arterial}</p>
                        <p><strong>Padecimiento:</strong> ${data.padecimiento}</p>
                        <p><strong>Total a Pagar:</strong> $${data.total_pagar}</p>
                    `;
                    document.getElementById('modal-content').innerHTML = modalContent;
                    document.getElementById('overlay').classList.remove('hidden'); // Mostrar overlay
                    document.getElementById('detailsModal').classList.remove('hidden');
                });
        }

        function hideDetailsModal() {
            document.getElementById('overlay').classList.add('hidden'); // Ocultar overlay
            document.getElementById('detailsModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
