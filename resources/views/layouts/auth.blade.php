<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'PinRuang') }} — Login</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin_assets/images/favicon/favicon.ico') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
  class="bg-gradient-to-br from-navy-900 via-navy-800 to-navy-950 font-sans min-h-screen antialiased flex items-center justify-center">
  @yield('content')
</body>

</html>