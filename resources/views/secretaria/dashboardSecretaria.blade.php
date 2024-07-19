<x-app-layout>
    <div class="m-5">
        @include('estadistica')
    </div>

    <div class="max-w-full mx-auto sm:px-5 lg:px-5">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                    <div class="flex my-4 mx-4 items-center justify-between">
                        <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Pacientes</h1>
                        <button id="openAddModalButton" class="ml-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                            {{ __('Agregar Paciente') }}
                        </button>
                    </div>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('dashboardSecretaria') }}" class="flex my-4 mx-4 items-center">
                        <div class="flex text-center border rounded-md items-center px-2">
                            <input type="text" name="busqueda" placeholder="Buscar paciente" class="border-0" value="{{ request('busqueda') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray" class="size-5">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                            </svg>
                        </div>                        
                        <button type="submit" class="ml-4 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                            Buscar
                        </button>
                        <button type="reset" onclick="window.location='{{ route('dashboardSecretaria') }}'" class="ml-4 px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
                            Reiniciar
                        </button>
                    </form>
                    
                    <!-- Table -->
                    <table class="min-w-full text-center text-sm whitespace-nowrap">
                        <!-- Table head -->
                        <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nombres</th>
                                <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                <th scope="col" class="px-6 py-4">Fecha de Nacimiento</th>
                                <th scope="col" class="px-6 py-4">Telefono</th>
                                <th scope="col" class="px-6 py-4">Acciones</th>
                            </tr>
                        </thead>

                        <!-- Table body -->
                        <tbody>
                            @foreach($pacientes as $paciente)
                                <tr>
                                    <td class="px-6 py-4">{{ $paciente->nombres }}</td>
                                    <td class="px-6 py-4">{{ $paciente->apepat }}</td>
                                    <td class="px-6 py-4">{{ $paciente->apemat }}</td>
                                    <td class="px-6 py-4">{{ $paciente->fechanac }}</td>
                                    <td class="px-6 py-4">{{ $paciente->telefono }}</td>
                                    <td class="px-6 py-4">
                                        <!-- Botón para editar el paciente -->
                                        <button class="openEditModalButton text-blue-500 hover:text-blue-700" data-id="{{ $paciente->id }}">
                                            Editar
                                        </button>
                                        @if(auth()->user()->hasRole(['medico', 'admin']))
                                            <!-- Formulario para eliminar el paciente -->
                                            <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Mensaje si no hay pacientes registrados -->
                    @if($pacientes->isEmpty())
                        <p class="text-center text-gray-500 mt-4">No hay pacientes registrados.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Background Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="px-4 py-5 sm:p-6">
                    <div class="bg-white dark:bg-neutral-700">
                        <form method="POST" action="{{ route('registrarPaciente.store') }}">
                            @csrf

                            <!-- Nombres -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="nombres" :value="__('Nombres')" />
                                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>

                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label for="apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>

                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus autocomplete="tel" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Registrar Paciente') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2" id="closeAddModalButton">
                        {{ __('Cerrar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="px-4 py-5 sm:p-6">
                    <div class="bg-white dark:bg-neutral-700">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PATCH')

                            <!-- Nombres -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="edit_nombres" :value="__('Nombres')" />
                                <x-text-input id="edit_nombres" class="block mt-1 w-full" type="text" name="nombres" required autofocus />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label for="edit_apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="edit_apepat" class="block mt-1 w-full" type="text" name="apepat" required autofocus />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>

                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label for="edit_apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="edit_apemat" class="block mt-1 w-full" type="text" name="apemat" required autofocus />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label for="edit_fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="edit_fechanac" class="block mt-1 w-full" type="date" name="fechanac" required />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>

                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus autocomplete="tel" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Actualizar Paciente') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2" id="closeEditModalButton">
                        {{ __('Cerrar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.getElementById('openAddModalButton').addEventListener('click', function() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('overlay').classList.remove('hidden');
        });

        document.getElementById('closeAddModalButton').addEventListener('click', function() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('overlay').classList.add('hidden');
        });

        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('overlay').classList.add('hidden');
        });

        document.querySelectorAll('.openEditModalButton').forEach(button => {
            button.addEventListener('click', function() {
                const pacienteId = this.getAttribute('data-id');
                fetch(`/secretaria/pacientes/editar/${pacienteId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_nombres').value = data.nombres;
                        document.getElementById('edit_apepat').value = data.apepat;
                        document.getElementById('edit_apemat').value = data.apemat;
                        document.getElementById('edit_fechanac').value = data.fechanac;
                        document.getElementById('telefono').value = data.telefono;
                        document.getElementById('editForm').action = `/secretaria/pacientes/editar/${pacienteId}`;
                        document.getElementById('editModal').classList.remove('hidden');
                        document.getElementById('overlay').classList.remove('hidden');
                    });
            });
        });

        document.getElementById('closeEditModalButton').addEventListener('click', function() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('overlay').classList.add('hidden');
        });
    </script>
</x-app-layout>