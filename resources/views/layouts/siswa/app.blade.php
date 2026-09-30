<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Welcome to BUBA</title>
</head>

<body>
    <div class="w-full min-h-screen overflow-x-hidden">
        <main>
            <img src="{{ asset('images/backgroundSplash.png') }}" alt="" class="w-full h-full object-cover">
            @yield('content')
        </main>
    </div>
</body>

</html>
