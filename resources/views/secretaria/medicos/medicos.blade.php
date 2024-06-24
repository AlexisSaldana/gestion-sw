<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Usuarios</h1>
                            <button id="openAddModalButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Agregar Usuario') }}
                            </button>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4">Correo</th>
                                    <th scope="col" class="px-6 py-4">Telefono</th>
                                    <th scope="col" class="px-6 py-4">Rol</th>
                                    <th scope="col" class="px-6 py-4">Activo</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($usuarios as $usuario)
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $usuario->nombres }}</td>
                                        <td class="px-6 py-4">{{ $usuario->apepat }}</td>
                                        <td class="px-6 py-4">{{ $usuario->apemat }}</td>
                                        <td class="px-6 py-4">{{ $usuario->email }}</td>
                                        <td class="px-6 py-4">{{ $usuario->telefono }}</td>
                                        <td class="px-6 py-4">{{ $usuario->rol }}</td>
                                        <td class="px-6 py-4">{{ $usuario->activo }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Botón para editar el usuario -->
                                            <button class="openEditModalButton text-blue-500 hover:text-blue-700" data-id="{{ $usuario->id }}">
                                                Editar
                                            </button>
                                            <!-- Formulario para eliminar el usuario -->
                                            <form action="{{ route('medicos.eliminar', $usuario->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
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
                        <form method="POST" action="{{ route('medicos.store') }}">
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

                                <!-- Rol -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label for="rol" :value="__('Rol')" />
                                    <select id="rol" name="rol" class="block mt-1 w-full" required>
                                        <option value="medico" {{ old('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                                        <option value="secretaria" {{ old('rol') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                                        <option value="colaborador" {{ old('rol') == 'colaborador' ? 'selected' : '' }}>Médico Colaborador</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                                </div>
                                
                                <!-- Correo Electrónico -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Contraseña -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Contraseña')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mt-4">
                                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
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
                                    <x-input-label for="edit_telefono" :value="__('Teléfono')" />
                                    <x-text-input id="edit_telefono" class="block mt-1 w-full" type="text" name="telefono" required autofocus autocomplete="tel" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>

                                <!-- Rol -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label for="edit_rol" :value="__('Rol')" />
                                    <select id="edit_rol" name="rol" class="block mt-1 w-full" required>
                                        <option value="medico">Médico</option>
                                        <option value="secretaria">Secretaria</option>
                                        <option value="colaborador">Médico Colaborador</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                                </div>
                                
                                <!-- Correo Electrónico -->
                                <div class="mt-4 col-span-2">
                                    <x-input-label for="edit_email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="edit_email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Contraseña -->
                                <div class="mt-4">
                                    <x-input-label for="password" :value="__('Contraseña')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mt-4">
                                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
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
                fetch(`/secretaria/medicos/editar/${usuarioId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_nombres').value = data.nombres;
                        document.getElementById('edit_apepat').value = data.apepat;
                        document.getElementById('edit_apemat').value = data.apemat;
                        document.getElementById('edit_fechanac').value = data.fechanac;
                        document.getElementById('edit_telefono').value = data.telefono;
                        document.getElementById('edit_rol').value = data.rol;
                        document.getElementById('edit_email').value = data.email;
                        document.getElementById('editForm').action = `/secretaria/medicos/editar/${usuarioId}`;
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
