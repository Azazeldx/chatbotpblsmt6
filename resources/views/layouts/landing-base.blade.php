<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ Storage::url($data['site_favicon']) }}">
    @if (isset($data['article']))
        <title>{{ $data['site_name'].' - '.$data['article']->title }}</title>
        <meta name="title" content="{{ $data['article']->metadata['meta_title'] ?? $data['article']->title }}">
        <meta name="description" content="{{ $data['article']->metadata['meta_desc'] ?? $data['article']->title }}">
        <meta property="og:title" content="{{ $data['article']->metadata['meta_title'] ?? $data['article']->title }}">
        <meta property="og:description" content="{{ $data['article']->metadata['meta_desc'] ?? $data['article']->title }}">
        <meta property="og:image" content="{{ Storage::url($data['article']->cover?->first()->image_path) }}">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:type" content="website">
    @else
        <title>{{ $data['site_name'].' - '.$data['page']->title }}</title>
        <meta name="title" content="{{ $data['site_name'] }}">
        <meta name="description" content="{{ $data['site_description'] }}">
    @endif

    @if (config('general-settings.features.ai', false))
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif

    {{-- CDN --}}
    <script defer src="https://kit.fontawesome.com/f87eaab4e6.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Styles --}}
    @yield('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('components.style')
</head>

<body class="break-words overflow-x-hidden">
    @if ($data['navigation']['header'])
        @include('sections.'.$data['navigation']['header']['layout_path'])
    @endif

    @yield('content')

    @if ($data['navigation']['footer'])
        @include('sections.'.$data['navigation']['footer']['layout_path'])
    @endif

    @if (config('general-settings.features.ai', false))
        @include('components.chatbot')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                once: true
            });
        });
    </script>
    <!-- Google tag (gtag.js) -->
    @if (config('general-settings.features.google_analytics'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.analytics_tag') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', {{ config('analytics.analytics_tag') }});
        </script>
    @endif

    @yield('js')
</body>

</html>
