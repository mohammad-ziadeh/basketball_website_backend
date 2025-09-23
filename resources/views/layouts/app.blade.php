<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- Template Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">


    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    @stack('styles')
    <!-- Optional tech-stack JS -->
    <script src="{{ asset('assets/js/tech-stack.js') }}"></script>
</head>

<body class="font-sans antialiased">

    @include('layouts.header')
    @include('layouts.side-bar')

    <main class="pc-container">
        <div class="pc-content">
            {{ $slot }}
        </div>
    </main>

    @include('layouts.footer')

    <!-- Required JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <!-- Conditional Template Scripts -->
    @if (!empty($pc_dark_layout))
        <script>
            layout_change('{{ $pc_dark_layout }}');
        </script>
    @endif

    @if (!empty($pc_theme_contrast))
        <script>
            layout_theme_contrast_change('{{ $pc_theme_contrast }}');
        </script>
    @endif

    @if (!empty($pc_box_container))
        <script>
            change_box_container('{{ $pc_box_container }}');
        </script>
    @endif

    @if (!empty($pc_caption_show))
        <script>
            layout_caption_change('{{ $pc_caption_show }}');
        </script>
    @endif

    @if (!empty($pc_rtl_layout))
        <script>
            layout_rtl_change('{{ $pc_rtl_layout }}');
        </script>
    @endif

    @if (!empty($pc_preset_theme))
        <script>
            preset_change('{{ $pc_preset_theme }}');
        </script>
    @endif

    @if (!empty($pc_theme_layout))
        <script>
            main_layout_change('{{ $pc_theme_layout }}');
        </script>
    @endif

    <!-- Stack for page-specific scripts -->
    @stack('scripts')
</body>

</html>
