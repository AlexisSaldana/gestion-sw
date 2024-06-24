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
                        <table id="citas-table" class="min-w-full text-center text-sm whitespace-nowrap">
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
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $cita->usuarioMedico->nombres }} {{ $cita->usuarioMedico->apepat }}</td>
                                        <td class="px-6 py-4">{{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</td>
                                        <td class="px-6 py-4">{{ $cita->fecha }}</td>
                                        <td class="px-6 py-4">{{ $cita->hora }}</td>
                                        <td class="px-6 py-4">{{ $cita->activo ? 'Sí' : 'No' }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar la cita -->
                                            <a href="{{ route('citas.editar', $cita->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                            <!-- Formulario para eliminar la cita -->
                                            <form action="{{ route('citas.eliminar', $cita->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
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

    <!-- component -->
    <div class="antialiased sans-serif bg-gray-100 h-screen">
        <div x-data="app()" x-init="[initDate(), getNoOfDays(), fetchEvents()]" x-cloak>
            <div class="container mx-auto px-4 py-2 md:py-24">
                <div class="flex justify-between items-center mb-4">
                    <div class="font-bold text-gray-800 text-xl">
                        Agenda de Citas
                    </div>
                    <button 
                        type="button"
                        class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700"
                        @click="openEventModal = true; event_date = '';">
                        Agregar Cita
                    </button>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex items-center justify-between py-2 px-6">
                        <div>
                            <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                            <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                        </div>
                        <div class="border rounded-lg px-1" style="padding-top: 2px;">
                            <button 
                                type="button"
                                class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center" 
                                :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                :disabled="month == 0 ? true : false"
                                @click="month--; getNoOfDays()">
                                <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>  
                            </button>
                            <div class="border-r inline-flex h-6"></div>        
                            <button 
                                type="button"
                                class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1" 
                                :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                :disabled="month == 11 ? true : false"
                                @click="month++; getNoOfDays()">
                                <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>                                      
                            </button>
                        </div>
                    </div>    
                    <div class="-mx-1 -mb-1">
                        <div class="flex flex-wrap" style="margin-bottom: -40px;">
                            <template x-for="(day, index) in days" :key="index">    
                                <div style="width: 14.26%" class="px-2 py-2">
                                    <div
                                        x-text="day" 
                                        class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center">
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="flex flex-wrap border-t border-l">
                            <template x-for="blankday in blankdays">
                                <div 
                                    style="width: 14.28%; height: 120px"
                                    class="text-center border-r border-b px-4 pt-2"    
                                ></div>
                            </template>    
                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">    
                                <div style="width: 14.28%; height: 120px" class="px-4 pt-2 border-r border-b relative">
                                    <div
                                        x-text="date"
                                        class="inline-flex w-6 h-6 items-center justify-center text-center leading-none rounded-full transition ease-in-out duration-100"
                                        :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"    
                                    ></div>
                                    <div style="height: 80px;" class="overflow-y-auto mt-1">
                                        <div 
                                            class="absolute top-0 right-0 mt-2 mr-2 inline-flex items-center justify-center rounded-full text-sm w-6 h-6 bg-gray-700 text-white leading-none"
                                            x-show="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length"
                                            x-text="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length"></div>
                                        <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString() )">    
                                            <div
                                                class="px-2 py-1 rounded-lg mt-1 overflow-hidden border"
                                                :class="{
                                                    'border-blue-200 text-blue-800 bg-blue-100': event.event_theme === 'blue',
                                                    'border-red-200 text-red-800 bg-red-100': event.event_theme === 'red',
                                                    'border-yellow-200 text-yellow-800 bg-yellow-100': event.event_theme === 'yellow',
                                                    'border-green-200 text-green-800 bg-green-100': event.event_theme === 'green',
                                                    'border-purple-200 text-purple-800 bg-purple-100': event.event_theme === 'purple'
                                                }"
                                            >
                                                <p x-text="event.event_title" class="text-sm truncate leading-tight"></p>
                                                <p x-text="event.event_time" class="text-xs truncate leading-tight"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div style=" background-color: rgba(0, 0, 0, 0.8)" class="fixed z-40 top-0 right-0 left-0 bottom-0 h-full w-full" x-show.transition.opacity="openEventModal">
                <div class="p-4 max-w-xl mx-auto relative left-0 right-0 overflow-hidden mt-24">
                    <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                        x-on:click="openEventModal = !openEventModal">
                        <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                        </svg>
                    </div>
                    <div class="shadow w-full rounded-lg bg-white overflow-hidden block p-8">
                        <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2">Agenda tu cita</h2>
                        <form method="POST" action="{{ route('citas.store') }}">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Fecha -->
                                <div class="mt-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="fecha">Fecha</label>
                                    <input id="fecha" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" name="fecha" x-model="event_date" min="{{ \Carbon\Carbon::today()->toDateString() }}" max="{{ \Carbon\Carbon::today()->addMonth()->toDateString() }}" required autofocus />
                                    @error('fecha')
                                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Hora -->
                                <div class="mt-4">
                                    <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide" for="hora">Hora</label>
                                    <select id="hora" name="hora" class="block mt-1 w-full bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" x-model="event_time" required autofocus>
                                        <option value="" disabled selected>Selecciona una hora</option>
                                        @for ($i = 8; $i <= 14; $i++)
                                            @php
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                $time1 = $hour . ':00';
                                                $time2 = $hour . ':30';
                                            @endphp
                                            <option value="{{ $time1 }}">{{ $time1 }}</option>
                                            @if($i < 16)
                                                <option value="{{ $time2 }}">{{ $time2 }}</option>
                                            @endif
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
                                <button type="button" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 border border-gray-300 rounded-lg shadow-sm mr-2" @click="openEventModal = !openEventModal">Cancelar</button>
                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded-lg shadow-sm">Registrar Cita</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            function app() {
                return {
                    month: '',
                    year: '',
                    no_of_days: [],
                    blankdays: [],
                    days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    events: [],
                    event_title: '',
                    event_date: '',
                    event_time: '',
                    event_theme: 'blue',
                    themes: [
                        { value: "blue", label: "Blue Theme" },
                        { value: "red", label: "Red Theme" },
                        { value: "yellow", label: "Yellow Theme" },
                        { value: "green", label: "Green Theme" },
                        { value: "purple", label: "Purple Theme" }
                    ],
                    openEventModal: false,
                    initDate() {
                        let today = new Date();
                        this.month = today.getMonth();
                        this.year = today.getFullYear();
                        this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                    },
                    isToday(date) {
                        const today = new Date();
                        const d = new Date(this.year, this.month, date);
                        return today.toDateString() === d.toDateString();
                    },
                    showEventModal(date) {
                        this.openEventModal = true;
                        this.event_date = new Date(this.year, this.month, date).toISOString().slice(0, 10); // Formato yyyy-mm-dd
                    },
                    addEvent() {
                        if (this.event_title === '' || this.event_time === '') return;
                        const newEvent = {
                            event_date: this.event_date,
                            event_title: this.event_title,
                            event_time: this.event_time,
                            event_theme: this.event_theme
                        };
                        this.events.push(newEvent);
                        this.event_title = '';
                        this.event_date = '';
                        this.event_time = '';
                        this.event_theme = 'blue';
                        this.openEventModal = false;
                        this.saveEventToDatabase(newEvent);
                    },
                    getNoOfDays() {
                        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                        let dayOfWeek = new Date(this.year, this.month, 1).getDay();
                        let blankdaysArray = [];
                        for (let i = 1; i <= dayOfWeek; i++) {
                            blankdaysArray.push(i);
                        }
                        let daysArray = [];
                        for (let i = 1; i <= daysInMonth; i++) {
                            daysArray.push(i);
                        }
                        this.blankdays = blankdaysArray;
                        this.no_of_days = daysArray;
                    },
                    fetchEvents() {
                        fetch('/get-events')
                            .then(response => response.json())
                            .then(data => {
                                this.events = data;
                            });
                    },
                    saveEventToDatabase(event) {
                        fetch('/api/save-event', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(event)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Event saved:', data);
                        });
                    }
                }
            }
        </script>
    </div>
</x-app-layout>
