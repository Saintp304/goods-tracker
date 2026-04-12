<!DOCTYPE html>
<html lang="en" class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />  <title>{{ $title ?? 'Goods Tracker' }}</title>
<style>
body {
font-family: 'Inter', system-ui, sans-serif;
}
</style>
<link rel="icon" type="image/png" href="{{ asset('images/roomify logo.png') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles
</head>
<body>
<main class="overflow-hidden">
@livewire('nav')
{{ $slot }}
@livewire('footer')
</main>
@livewireScripts

</body>
</html>