<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <!-- component -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <div class="bg-no-repeat bg-cover bg-center relative"
        style="background-image: url('images/scene1.jpg');">
        <div class="absolute"></div>
        <div class="min-h-screen sm:flex sm:flex-row  mx-0 justify-center">
            <div class="flex-col flex  self-center p-10 sm:max-w-5xl xl:max-w-2xl  z-10">
                <div class="self-start hidden lg:flex flex-col  text-white">
                    {{-- <img src="" class="mb-3"> --}}
                    <h1 class="mb-3 font-bold text-5xl">Hi ! Welcome in EvenXt  </h1>
                    <p class="pr-3">Don't miss out! Explore upcoming events and secure your spot at the hottest ones with our easy-to-use ticketing system.</p>
                </div>
            </div>
            <div class="flex justify-center self-center  z-10">
                <div class="p-12  bg-white bg-opacity-50  mx-auto rounded-2xl lg:w-[30vw] lg:mb-0 mb-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>



</body>

</html>
