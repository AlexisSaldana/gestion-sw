<x-app-layout>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                            <div class="flex my-4 mx-4 items-center justify-between">
                                <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Médicos</h1>
                                <a href="{{ route('medicos.agregar') }}">
                                    <x-primary-button>
                                        {{ __('Agregar Médico') }}
                                    </x-primary-button>
                                </a>
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
                                        <th scope="col" class="px-6 py-4">Activo</th>
                                        <th scope="col" class="px-6 py-4">Acciones</th>
                                    </tr>
                                </thead>

                                <!-- Table body -->
                                <tbody>
                                    @foreach($medicos as $medico)
                                        <tr class="border-b dark:border-neutral-600">
                                            <td class="px-6 py-4">{{ $medico->nombres }}</td>
                                            <td class="px-6 py-4">{{ $medico->apepat }}</td>
                                            <td class="px-6 py-4">{{ $medico->apemat }}</td>
                                            <td class="px-6 py-4">{{ $medico->email }}</td>
                                            <td class="px-6 py-4">{{ $medico->telefono }}</td>
                                            <td class="px-6 py-4">{{ $medico->activo }}</td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('medicos.editar', $medico->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                                <form action="{{ route('medicos.eliminar', $medico->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($medicos->isEmpty())
                                <p class="text-center text-gray-500 mt-4">No hay médicos registrados.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
