<x-app-layout>
    <div class="py-5 mx-5">
        <div class="max-w-full mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Productos</h1>
                            <button id="openAddModalButton" class="ml-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                                {{ __('Agregar Producto') }}
                            </button>
                        </div>

                        <!-- Search Form -->
                        <form method="GET" action="{{ route('productos') }}" class="flex my-4 mx-4 items-center">
                            <div class="flex text-center border rounded-md items-center px-2">
                            <input type="text" name="busqueda" placeholder="Buscar producto" class="border-0" value="{{ request('busqueda') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray" class="size-5">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                                </svg>
                            </div>                        
                            <button type="submit" class="ml-4 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                                Buscar
                            </button>
                            <button type="reset" onclick="window.location='{{ route('productos') }}'" class="ml-4 px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">
                                Reiniciar
                            </button>
                        </form>

                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Precio</th>
                                    <th scope="col" class="px-6 py-4">Cantidad</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($productos as $producto)
                                    <tr>
                                        <td class="px-6 py-4">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-4">{{ $producto->precio }}</td>
                                        <td class="px-6 py-4">{{ $producto->cantidad }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Botón para editar el producto -->
                                            <button class="openEditModalButton text-blue-500 hover:text-blue-700" data-id="{{ $producto->id }}">
                                                Editar
                                            </button>
                                            @if(auth()->user()->hasRole(['medico', 'admin']))
                                                <!-- Formulario para eliminar el producto -->
                                                <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST" class="inline-block">
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
                        <!-- Mensaje si no hay productos registrados -->
                        @if($productos->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay productos registrados.</p>
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
                        <form method="POST" action="{{ route('productos.store') }}">
                            @csrf

                            <!-- Nombre -->
                            <div class="mt-4">
                                <x-input-label for="nombre" :value="__('Nombre')" />
                                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <!-- Precio -->
                            <div class="mt-4">
                                <x-input-label for="precio" :value="__('Precio')" />
                                <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio')" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                            </div>

                            <!-- Cantidad -->
                            <div class="mt-4">
                                <x-input-label for="cantidad" :value="__('Cantidad')" />
                                <x-text-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad" :value="old('cantidad')" required />
                                <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Registrar Producto') }}
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

                            <!-- Nombre -->
                            <div class="mt-4">
                                <x-input-label for="edit_nombre" :value="__('Nombre')" />
                                <x-text-input id="edit_nombre" class="block mt-1 w-full" type="text" name="nombre" required autofocus />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <!-- Precio -->
                            <div class="mt-4">
                                <x-input-label for="edit_precio" :value="__('Precio')" />
                                <x-text-input id="edit_precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                            </div>

                            <!-- Cantidad -->
                            <div class="mt-4">
                                <x-input-label for="edit_cantidad" :value="__('Cantidad')" />
                                <x-text-input id="edit_cantidad" class="block mt-1 w-full" type="number" name="cantidad" required />
                                <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Actualizar Producto') }}
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
                const productoId = this.getAttribute('data-id');
                fetch(`/secretaria/productos/editar/${productoId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_nombre').value = data.nombre;
                        document.getElementById('edit_precio').value = data.precio;
                        document.getElementById('edit_cantidad').value = data.cantidad;
                        document.getElementById('editForm').action = `/secretaria/productos/editar/${productoId}`;
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
                        title: '¿Está seguro de querer eliminar el producto?',
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
