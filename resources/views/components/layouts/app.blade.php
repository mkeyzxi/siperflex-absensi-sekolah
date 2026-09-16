<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIPERFLEX' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo-transparan.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo-transparan.png') }}">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="{{ $title ?? 'SIPERFLEX' }}">
    <meta property="og:description" content="Sistem Informasi Presensi dan Refleksi Fleksibel untuk Sekolah.">
    <meta property="og:image" content="{{ asset('logo-login.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-neutral-bg text-neutral-900 font-sans antialiased min-h-screen">
    {{ $slot }}
</body>

</html>
