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

    <x-navbar></x-navbar>

    <div class="mt-20">
        {{ $slot }}
    </div>
</body>

</html>