<!-- resources/views/components/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Livewire Todo App' }}</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen py-8">
    {{ $slot }}
</div>
@livewireScripts
</body>
</html>
