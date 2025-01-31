@props(['title'=>'Products'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>{{ $title }}</title>
</head>

<body>
    <div class="opacity-10 relative" style="z-index:-1">
        <img class="w-full fixed top-0" src="{{ asset('storage/bg.jpg') }}" alt="background">
    </div>

    <x-navbar></x-navbar>

    <div class="z-50">
        {{ $slot }}
    </div>
</body>

</html>