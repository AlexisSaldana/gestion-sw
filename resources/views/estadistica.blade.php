<div class="font-poppins">
  <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

    <!-- Total de todas las consultas -->
    <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
      <dt>
        <div class="absolute rounded-md bg-cyan-500 p-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        </div>
        <p class="ml-16 truncate text-sm font-medium text-gray-700">Total</p>
      </dt>
      <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900">{{"$" . $totalPagadoFinalizado }}</p>
        </p>
        <div class="absolute inset-x-0 bottom-0 bg-gray-200 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="#" class="font-medium text-cyan-500 hover:text-cyan-700">Ingresos Totales</a>
          </div>
        </div>
      </dd>
    </div>

    <!-- Total de pacientes -->
    <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
      <dt>
        <div class="absolute rounded-md bg-cyan-500 p-3">
          <svg class="h-6 w-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
          </svg>
        </div>
        <p class="ml-16 truncate text-sm font-medium text-gray-700">Pacientes</p>
      </dt>
      <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900">{{ $totalPacientesActivos }}</p>
        </p>
        <div class="absolute inset-x-0 bottom-0 bg-gray-200 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="{{ route('dashboardSecretaria') }}" class="font-medium text-cyan-500 hover:text-cyan-700">Ver Pacientes</a>
          </div>
        </div>
      </dd>
    </div>

    <!-- Total de citas -->
    <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
      <dt>
        <div class="absolute rounded-md bg-cyan-500 p-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
          </svg>
        </div>
        <p class="ml-16 truncate text-sm font-medium text-gray-700">Citas</p>
      </dt>
      <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900">{{ $totalCitasActivas }}</p>
        </p>
        <div class="absolute inset-x-0 bottom-0 bg-gray-200 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="{{ route('citas') }}" class="font-medium text-cyan-500 hover:text-cyan-700">Ver Citas</a>
          </div>
        </div>
      </dd>
    </div>

    <!-- Total de usuarios -->
    <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
      <dt>
        <div class="absolute rounded-md bg-cyan-500 p-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
        </svg>
        </div>
        <p class="ml-16 truncate text-sm font-medium text-gray-700">Usuarios</p>
      </dt>
      <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900">{{ $totalUsuariosActivos }}</p>
        </p>
        <div class="absolute inset-x-0 bottom-0 bg-gray-200 px-4 py-4 sm:px-6">
          <div class="text-sm">
            <a href="{{ route('usuarios') }}" class="font-medium text-cyan-500 hover:text-cyan-700">Ver Usuarios</a>
          </div>
        </div>
      </dd>
    </div>
  </dl>
</div>

<div class="font-poppins relative flex flex-col rounded-xl bg-white bg-clip-border shadow-xl mt-5">
  <div class="relative mx-4 mt-4 flex flex-col gap-4 overflow-hidden bg-transparent bg-clip-border text-gray-700 shadow-none md:flex-row md:items-center">
    <div class="w-max rounded-lg bg-cyan-500 p-5 text-white">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3"/>
      </svg>
    </div>
    <div>
      <h6 class="block text-base font-semibold leading-relaxed tracking-normal text-cyan-500 antialiased">
        Estadísticas de Care Center
      </h6>
      <p class="block max-w-sm text-sm font-normal leading-normal text-gray-700 antialiased">
        Visualiza todas las estadísticas día tras día.
      </p>
    </div>
  </div>

  <!-- Select para elegir qué gráfica mostrar -->
  <div class="mx-4 mt-4">
    <label for="chartSelect" class="block text-sm font-medium text-gray-700">Selecciona el tipo de gráfica</label>
    <select id="chartSelect" class="p-1 mt-1 block w-full rounded-md border-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      <option value="citas">Citas por Día</option>
      <option value="pagado">Ingresos por Día</option>
      <option value="pacientes">Pacientes por Día</option>
    </select>
  </div>

  <div class="pt-6 px-2 pb-0 flex-grow">
    <div id="chart" style="height: 100%;"></div>
  </div>  
</div>

<script>
const citasData = {!! $citasDataJson !!};
const pagadoData = {!! $pagadoDataJson !!};
const pacientesData = {!! $pacientesDataJson !!};

const chartConfig = {
  series: [{
    name: "Citas por Día",
    data: citasData.map(item => item.total), // Usar los totales de citas por día
  }],
  chart: {
    type: "line",
    height: 400,
    toolbar: {
      show: false,
    },
  },
  title: {
    show: false,
  },
  dataLabels: {
    enabled: false,
  },
  colors: ["#4e73df"], // Color de la línea
  stroke: {
    lineCap: "round",
    curve: "smooth",
    width: 2,
  },
  markers: {
    size: 4, // Tamaño de los puntos en la gráfica
    colors: ["#4e73df"], 
  },
  xaxis: {
    type: 'datetime',
    categories: citasData.map(item => item.date), // Usar las fechas para el eje X
    labels: {
      style: {
        colors: "gray-700",
        fontSize: "12px",
        fontFamily: "inherit",
        fontWeight: 600,
      },
      format: 'dd MMM', // Formato de las fechas en el eje X
    },
  },
  yaxis: {
    tickAmount: 10, 
    min: 0,
    max: Math.ceil(Math.max(...citasData.map(item => item.total)) / 10) * 10,
    labels: {
      style: {
        colors: "gray-700",
        fontSize: "12px",
        fontFamily: "inherit",
        fontWeight: 600,
      },
      formatter: function(value) {
        return Math.round(value);
      }
    },
  },
  grid: {
    show: true,
    borderColor: "#dddddd",
    strokeDashArray: 5,
    xaxis: {
      lines: {
        show: true,
      },
    },
    padding: {
      top: 5,
      right: 20,
    },
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: 'light',
      type: "vertical",
      shadeIntensity: 0.3,
      gradientToColors: ["#4e73df"],
      opacityFrom: 0.7,
      opacityTo: 0.1,
      stops: [0, 100]
    }
  },
  tooltip: {
    theme: "dark",
    x: {
      format: 'dd MMM' // Formato de la fecha en el tooltip
    },
  },
};

const chart = new ApexCharts(document.querySelector("#chart"), chartConfig);
chart.render();

document.getElementById('chartSelect').addEventListener('change', function() {
  const selectedValue = this.value;

  let selectedData;
  let selectedName;

  if (selectedValue === 'citas') {
    selectedData = citasData;
    selectedName = "Citas por Día";
  } else if (selectedValue === 'pagado') {
    selectedData = pagadoData;
    selectedName = "Ingresos por Día";
  } else if (selectedValue === 'pacientes') {
    selectedData = pacientesData;
    selectedName = "Pacientes por Día";
  }

  chart.updateOptions({
    series: [{
      name: selectedName,
      data: selectedData.map(item => item.total), 
    }],
    yaxis: {
      max: Math.ceil(Math.max(...selectedData.map(item => item.total)) / 10) * 10, 
    },
    xaxis: {
      categories: selectedData.map(item => item.date), // Cambia de 'month' a 'date'
    }
  });
});

</script>
