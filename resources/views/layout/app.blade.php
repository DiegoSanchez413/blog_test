<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Blog Application</title>
  @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body>
  @include('partials.header')
  <div class="p-5">
    @yield('content')

  </div>
</body>

</html>