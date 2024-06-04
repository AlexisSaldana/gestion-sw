@include("header")
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienvenido</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
   
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-white">
    <div class="container mx-auto px-4 py-24 flex items-center justify-center">
        <div class="max-w-xl">
            <span class="text-gray-500 uppercase tracking-wide">App Medica</span>
            <h1 class="text-6xl font-bold text-gray-900 mt-2 mb-6">Bienvenido a tu aplicacion de Citas Medicas.</h1>
            <p class="text-gray-700 mb-8">AGENDA YA TUS CITAS!</p>
        </div>
        <div>
            <img class="w-96 h-auto" src="https://ciosad.com.co/wp-content/uploads/2020/11/citas-01-1024x1024.png" alt="Showcase Image">
        </div>
    </div>
</body>
</html>

@include("footer")