<x-app-layout>
    <div class="py-5 mx-5">
        <div class="max-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Usuarios</h1>
                            <button id="openAddModalButton" class="ml-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                                {{ __('Agregar Usuario') }}
                            </button>
                        </div>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('usuarios') }}" class="flex my-4 mx-4 items-center">
                            <div class="flex text-center border rounded-md items-center px-2">
                                <input type="text" name="busqueda" placeholder="Buscar usuario" class="border-0" value="{{ request('busqueda') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray" class="size-5">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <select name="rol" class="ml-4 px-4 py-2 border rounded-md">
                                <option value="">Todos los Roles</option>
                                <option value="medico" {{ request('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                                <option value="secretaria" {{ request('rol') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                                <option value="enfermera" {{ request('rol') == 'enfermera' ? 'selected' : '' }}>Enfermera</option>
                            </select>
                            <button type="submit" class="ml-4 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                                Buscar
                            </button>
                            <button type="reset" onclick="window.location='{{ route('usuarios') }}'" class="ml-4 px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
                                Reiniciar
                            </button>
                        </form>

                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 bg-neutral-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4">Correo</th>
                                    <th scope="col" class="px-6 py-4">Telefono</th>
                                    <th scope="col" class="px-6 py-4">Rol</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($usuarios as $usuario)
                                    <tr>
                                        <td class="px-6 py-4">{{ $usuario->nombres }}</td>
                                        <td class="px-6 py-4">{{ $usuario->apepat }}</td>
                                        <td class="px-6 py-4">{{ $usuario->apemat }}</td>
                                        <td class="px-6 py-4">{{ $usuario->email }}</td>
                                        <td class="px-6 py-4">{{ $usuario->telefono }}</td>
                                        <td class="px-6 py-4">{{ $usuario->rol }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Botón para editar el usuario -->
                                            <button class="openEditModalButton text-blue-500 hover:text-blue-700" data-id="{{ $usuario->id }}">
                                                Editar
                                            </button>
                                            @if(auth()->user()->hasRole(['medico', 'admin']))
                                                <!-- Botón para eliminar el usuario -->
                                                <form action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="deleteButton text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay usuarios registrados -->
                        @if($usuarios->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay usuarios registrados.</p>
                        @endif
                    </div>
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
                        <form method="POST" action="{{ route('usuarios.store') }}">
                            @csrf

                            <!-- Nombres -->
                            <div class="mt-4 col-span-2">
                                <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="nombres" :value="__('Nombres')" />
                                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>

                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>

                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus autocomplete="tel" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>

                                <!-- Rol -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="rol" :value="__('Rol')" />
                                    <select id="rol" name="rol" class="block mt-1 w-full" required>
                                        <option value="medico" {{ old('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                                        <option value="secretaria" {{ old('rol') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                                        <option value="enfermera" {{ old('rol') == 'enfermera' ? 'selected' : '' }}>Enfermera</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                                </div>
                                
                                <!-- Correo Electrónico -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Contraseña -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="password" :value="__('Contraseña')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Registrar Usuario') }}
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
                                <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_nombres" :value="__('Nombres')" />
                                <x-text-input id="edit_nombres" class="block mt-1 w-full" type="text" name="nombres" required autofocus />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="edit_apepat" class="block mt-1 w-full" type="text" name="apepat" required autofocus />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>

                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="edit_apemat" class="block mt-1 w-full" type="text" name="apemat" required autofocus />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="edit_fechanac" class="block mt-1 w-full" type="date" name="fechanac" required />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>

                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_telefono" :value="__('Teléfono')" />
                                    <x-text-input id="edit_telefono" class="block mt-1 w-full" type="text" name="telefono" required autofocus autocomplete="tel" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>

                                <!-- Rol -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_rol" :value="__('Rol')" />
                                    <select id="edit_rol" name="rol" class="block mt-1 w-full" required>
                                        <option value="medico">Médico</option>
                                        <option value="secretaria">Secretaria</option>
                                        <option value="enfermera">Enfermera</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                                </div>
                                
                                <!-- Correo Electrónico -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="edit_email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="edit_email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Contraseña -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="password" :value="__('Contraseña')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mt-4">
                                    <x-input-label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Actualizar Usuario') }}
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
            const usuarioId = this.getAttribute('data-id');
            fetch(`/secretaria/usuarios/editar/${usuarioId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nombres').value = data.nombres;
                    document.getElementById('edit_apepat').value = data.apepat;
                    document.getElementById('edit_apemat').value = data.apemat;
                    document.getElementById('edit_fechanac').value = data.fechanac;
                    document.getElementById('edit_telefono').value = data.telefono;
                    document.getElementById('edit_rol').value = data.rol;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('editForm').action = `/secretaria/usuarios/editar/${usuarioId}`;
                    document.getElementById('editModal').classList.remove('hidden');
                    document.getElementById('overlay').classList.remove('hidden');
                });
        });
    });

    document.getElementById('closeEditModalButton').addEventListener('click', function() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('overlay').classList.add('hidden');
    });

    // Add SweetAlert for delete confirmation
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const form = this.closest('form');
            if (form) {
                Swal.fire({
                    title: '¿Está seguro de querer eliminar el usuario?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });

    // SweetAlert for success messages
    @if(session('status'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('status') }}'
        });
    @endif

    // SweetAlert for error messages
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    @endif
    </script>
</x-app-layout>
