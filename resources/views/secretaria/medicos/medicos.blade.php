<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Usuarios</h1>
                            <a href="{{ route('medicos.agregar') }}">
                                <x-primary-button>
                                    {{ __('Agregar Usuario') }}
                                </x-primary-button>
                            </a>
                        </div>
                        <!-- Table -->
                        <table id="usuarios-table" class="min-w-full text-center text-sm whitespace-nowrap">
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
                                        <!-- Enlace para editar el usuario -->
                                        <a href="{{ route('medicos.editar', $usuario->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                        <!-- Formulario para eliminar el usuario -->
                                        <form action="{{ route('medicos.eliminar', $usuario->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
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
</x-app-layout>
