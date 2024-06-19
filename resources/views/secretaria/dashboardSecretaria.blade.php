<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Pacientes</h1>
                            <a href="{{ route('agregarPaciente') }}">
                                <x-primary-button>
                                    {{ __('Agregar Paciente') }}
                                </x-primary-button>
                            </a>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombres</th>
                                    <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4">Fecha de Nacimiento</th>
                                    <th scope="col" class="px-6 py-4">Activo</th>
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
                                        <td class="px-6 py-4">{{ $paciente->activo }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar el paciente -->
                                            <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                            <!-- Formulario para eliminar el paciente -->
                                            <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
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
    </div>
</x-app-layout>