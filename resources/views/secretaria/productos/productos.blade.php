<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Productos</h1>
                            <button id="openAddModalButton" class="ml-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">
                                {{ __('Agregar Producto') }}
                            </button>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Precio</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($productos as $producto)
                                    <tr>
                                        <td class="px-6 py-4">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-4">{{ $producto->precio }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Botón para editar el producto -->
                                            <button class="openEditModalButton text-blue-500 hover:text-blue-700" data-id="{{ $producto->id }}">
                                                Editar
                                            </button>
                                            <!-- Formulario para eliminar el producto -->
                                            <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
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
                                <x-text-input id="precio" class="block mt-1 w-full" type="number" name="precio" :value="old('precio')" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
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
                                <x-text-input id="edit_precio" class="block mt-1 w-full" type="number" name="precio" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
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
    </script>
</x-app-layout>
