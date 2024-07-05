<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Citas</h1>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-neutral-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Médico</th>
                                    <th scope="col" class="px-6 py-4">Paciente</th>
                                    <th scope="col" class="px-6 py-4">Fecha</th>
                                    <th scope="col" class="px-6 py-4">Hora</th>
                                    <th scope="col" class="px-6 py-4">Activo</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
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
                                        <td class="px-6 py-4">{{ $cita->activo ? 'Sí' : 'No' }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Botón para editar la cita -->
                                            <button class="openEditModalButton text-blue-500 hover:text-blue-700" data-id="{{ $cita->id }}">
                                                Editar
                                            </button>
                                            <!-- Formulario para eliminar la cita -->
                                            <form action="{{ route('citas.eliminar', $cita->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay citas registradas -->
                        @if($citas->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay citas registradas.</p>
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
                    <form method="POST" action="{{ route('citas.store') }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Fecha -->
                            <div class="mt-4">
                                <x-input-label for="fecha" :value="__('Fecha')" />
                                <x-text-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" :value="old('fecha')" required autofocus />
                                <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                            </div>

                            <!-- Hora -->
                            <div class="mt-4">
                                <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="hora">Hora</label>
                                <select id="hora" name="hora" class="block mt-1 w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" required autofocus>
                                    <option value="" disabled selected>Selecciona una hora</option>
                                    @for ($i = 8; $i <= 13; $i++)
                                    @php
                                    $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                    $time = $hour . ':00';
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                    @endfor
                                </select>
                                @error('hora')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Paciente -->
                        <div class="mt-4">
                            <x-input-label for="paciente_id" :value="__('Paciente')" />
                            <select id="paciente_id" name="paciente_id" class="block mt-1 w-full" required>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('paciente_id')" class="mt-2" />
                        </div>

                        <!-- Médico -->
                        <input type="hidden" name="usuariomedicoid" value="{{ $usuario->id }}" />

                        <div class="flex items-center justify-end mt-4">
                            <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                {{ __('Registrar Cita') }}
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
                        <form id="editForm" method="POST" action="">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" id="editFormId" name="id" value="">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Fecha -->
                                <div class="mt-4">
                                    <x-input-label for="edit_fecha" :value="__('Fecha')" />
                                    <x-text-input id="edit_fecha" class="block mt-1 w-full" type="date" name="fecha" required />
                                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                                </div>

                                <!-- Hora -->
                                <div class="mt-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="hora">Hora</label>
                                    <select id="hora" name="hora" class="block mt-1 w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" required autofocus>
                                        <option value="" disabled selected>Selecciona una hora</option>
                                        @for ($i = 8; $i <= 13; $i++)
                                        @php
                                        $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                        $time = $hour . ':00';
                                        @endphp
                                        <option value="{{ $time }}">{{ $time }}</option>
                                        @endfor
                                    </select>
                                    @error('hora')
                                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Paciente -->
                            <input type="hidden" id="edit_paciente_id" name="paciente_id" />

                            <!-- Médico -->
                            <input type="hidden" name="usuariomedicoid" value="{{ $usuario->id }}" />

                            <div class="flex items-center justify-end mt-4">
                                <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">
                                    {{ __('Actualizar Cita') }}
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

    <!-- Calendar -->
    <div class="lg:flex lg:h-full lg:flex-col">
        <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none">
            <h1 class="text-base font-semibold leading-6 text-gray-900" id="calendar-month-year"></h1>
            <div class="flex items-center">
                <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
                    <button id="prev-month" type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50">
                        <span class="sr-only">Previous month</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button id="today" type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block">Today</button>
                    <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
                    <button id="next-month" type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50">
                        <span class="sr-only">Next month</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <button id="schedule-appointment" type="button" class="ml-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Agendar Cita</button>
            </div>
        </header>
        <div class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col">
            <div class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs font-semibold leading-6 text-gray-700 lg:flex-none">
                <div class="flex justify-center bg-white py-2"><span>M</span><span class="sr-only sm:not-sr-only">ON</span></div>
                <div class="flex justify-center bg-white py-2"><span>T</span><span class="sr-only sm:not-sr-only">UE</span></div>
                <div class="flex justify-center bg-white py-2"><span>W</span><span class="sr-only sm:not-sr-only">ED</span></div>
                <div class="flex justify-center bg-white py-2"><span>T</span><span class="sr-only sm:not-sr-only">HU</span></div>
                <div class="flex justify-center bg-white py-2"><span>F</span><span class="sr-only sm:not-sr-only">RI</span></div>
                <div class="flex justify-center bg-white py-2"><span>S</span><span class="sr-only sm:not-sr-only">AT</span></div>
                <div class="flex justify-center bg-white py-2"><span>S</span><span class="sr-only sm:not-sr-only">UN</span></div>
            </div>
            <div class="flex bg-gray-200 text-xs leading-6 text-gray-700 lg:flex-auto">
                <div id="calendar-days" class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px"></div>
                <div id="calendar-days-mobile" class="isolate grid w-full grid-cols-7 grid-rows-6 gap-px lg:hidden"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="shadow w-full rounded-lg bg-white overflow-hidden block p-8">
                    <h2 id="modal-title" class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Agenda tu cita</h2>
                    <form id="modal-form" method="POST" action="">
                        @csrf
                        <input type="hidden" id="cita-id" name="id">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Fecha -->
                            <div class="mt-4">
                                <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="fecha">Fecha</label>
                                <input id="fecha" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" name="fecha" min="{{ \Carbon\Carbon::today()->toDateString() }}" max="{{ \Carbon\Carbon::today()->addMonth()->toDateString() }}" required autofocus />
                                @error('fecha')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora -->
                            <div class="mt-4">
                                <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="hora">Hora</label>
                                <select id="hora" name="hora" class="block mt-1 w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" required autofocus>
                                    <option value="" disabled selected>Selecciona una hora</option>
                                    @for ($i = 8; $i <= 13; $i++)
                                    @php
                                    $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                    $time = $hour . ':00';
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                    @endfor
                                </select>
                                @error('hora')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Paciente -->
                            <div class="mt-4">
                                <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="pacienteid">Paciente</label>
                                <select id="pacienteid" name="pacienteid" class="block mt-1 w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" required>
                                    @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</option>
                                    @endforeach
                                </select>
                                @error('pacienteid')
                                <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Usuario Médico (Oculto) -->
                            <input type="hidden" name="usuariomedicoid" value="{{ $usuario->id }}" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2" id="close-modal">Cancelar</button>
                            <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">Registrar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthYearElement = document.getElementById('calendar-month-year');
            const calendarDaysElement = document.getElementById('calendar-days');
            const calendarDaysMobileElement = document.getElementById('calendar-days-mobile');
            const prevMonthButton = document.getElementById('prev-month');
            const nextMonthButton = document.getElementById('next-month');
            const todayButton = document.getElementById('today');
            const scheduleButton = document.getElementById('schedule-appointment');
            const modal = document.getElementById('modal');
            const closeModalButton = document.getElementById('close-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalForm = document.getElementById('modal-form');
            const citaIdInput = document.getElementById('cita-id');
            const fechaInput = document.getElementById('fecha');
            const horaSelect = document.getElementById('hora');
            const pacienteSelect = document.getElementById('pacienteid');

            let citas = []; // Inicializa el array de citas
            let currentDate = new Date();

            function fetchEvents() {
                fetch('{{ url('/get-events') }}')
                    .then(response => response.json())
                    .then(data => {
                        citas = data;
                        renderCalendar(currentDate);
                    });
            }

            function renderCalendar(date) {
                const year = date.getFullYear();
                const month = date.getMonth();
                const today = new Date();
                const firstDayOfMonth = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Set the month and year in the header
                monthYearElement.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' }).toUpperCase();

                // Clear previous calendar days
                calendarDaysElement.innerHTML = '';
                calendarDaysMobileElement.innerHTML = '';

                // Fill in the days
                for (let i = 0; i < firstDayOfMonth; i++) {
                    const emptyCell = '<div class="relative bg-gray-50 px-3 py-12 text-gray-500"></div>';
                    calendarDaysElement.innerHTML += emptyCell;
                    calendarDaysMobileElement.innerHTML += emptyCell;
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                    const citasForDay = citas.filter(cita => cita.event_date === dateString);
                    const dayCell = `<div class="relative bg-white px-3 py-12 ${isToday ? 'font-semibold text-white' : ''}">
                                      <time datetime="${dateString}" class="${isToday ? 'rounded-full bg-blue-500 p-1' : ''}">${day}</time>
                                      ${citasForDay.map(cita => `<div class="mt-1 text-sm text-blue-500">${cita.event_title} ${cita.event_time}</div>`).join('')}
                                   </div>`;
                    calendarDaysElement.innerHTML += dayCell;
                    calendarDaysMobileElement.innerHTML += dayCell;
                }
            }

            function changeMonth(offset) {
                currentDate.setMonth(currentDate.getMonth() + offset);
                renderCalendar(currentDate);
            }

            prevMonthButton.addEventListener('click', () => changeMonth(-1));
            nextMonthButton.addEventListener('click', () => changeMonth(1));
            todayButton.addEventListener('click', () => {
                currentDate = new Date();
                renderCalendar(currentDate);
            });

            scheduleButton.addEventListener('click', () => {
                modalTitle.textContent = 'Agenda tu cita';
                modalForm.action = '{{ route('citas.store') }}';
                citaIdInput.value = '';
                fechaInput.value = '';
                horaSelect.value = '';
                pacienteSelect.value = '';
                modalForm.method = 'POST';
                modal.classList.remove('hidden');
                document.getElementById('overlay').classList.remove('hidden');
            });

            closeModalButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                document.getElementById('overlay').classList.add('hidden');
            });

            document.querySelectorAll('.openEditModalButton').forEach(button => {
                button.addEventListener('click', function() {
                    const citaId = this.getAttribute('data-id');
                    fetch(`/secretaria/citas/editar/${citaId}`)
                        .then(response => response.json())
                        .then(data => {
                            const editForm = document.getElementById('editForm');
                            editForm.action = `/secretaria/citas/editar/${citaId}`;
                            document.getElementById('edit_fecha').value = data.fecha;
                            document.getElementById('edit_hora').value = data.hora;
                            document.getElementById('edit_paciente_id').value = data.paciente_id;
                            document.getElementById('editFormId').value = citaId;
                            document.getElementById('editModal').classList.remove('hidden');
                            document.getElementById('overlay').classList.remove('hidden');
                        });
                });
            });

            document.getElementById('closeEditModalButton').addEventListener('click', () => {
                document.getElementById('editModal').classList.add('hidden');
                document.getElementById('overlay').classList.add('hidden');
            });

            // Fetch and render events on initial load
            fetchEvents();
        });
    </script>
</x-app-layout>
