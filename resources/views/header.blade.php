<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Care Center</title>

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl posición-relativa d-flex align-items-center">
      <a href="{{ route('welcome') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('img/logo.png') }}" alt="">
        <h1 class="sitename">Care Center</h1>
      </a>
      <a class="text-white tracking-wide font-semibold rounded-xl px-3 bg-cyan-700 py-2 hover:bg-cyan-900" href="{{ route('login') }}">Iniciar Sesión</a>
    </div>
  </header>

  @if (session('error'))
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}'
      });
    </script>
  @endif

</body>
</html>