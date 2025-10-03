<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || '{{ $pc_theme_layout ?? 'light' }}';
            const html = document.documentElement;

            if (savedTheme === 'dark') {
                html.setAttribute('data-bs-theme', 'dark');
                html.setAttribute('data-pc-theme', 'dark');
                html.style.backgroundColor = '#212529';
            } else {
                html.setAttribute('data-bs-theme', 'light');
                html.setAttribute('data-pc-theme', 'light');
                html.style.backgroundColor = '#f8f9fa';
            }

            // Reveal body after theme applied
            document.addEventListener('DOMContentLoaded', function() {
                document.body.style.visibility = 'visible';
            });
        })();
    </script>

    <!-- Hide body initially to prevent flash -->
    <style>
        body {
            visibility: hidden;
            transition: none !important;
        }
    </style>

    <!-- Template Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

    @stack('styles')

    <!-- Optional tech-stack JS -->
    <script src="{{ asset('assets/js/tech-stack.js') }}"></script>

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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoG6V+fS0Z5iQF4WQbqImc1eLm9B2w5vR1zK9tH3D4g0b0Z" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Conditional Template Scripts -->
    @if (!empty($pc_theme_layout))
        <script>
            if (!localStorage.getItem('theme')) {
                layout_change('{{ $pc_theme_layout }}');
            }
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
    <script>
        function layout_change(theme) {
            const html = document.documentElement;
            if (theme === 'dark') {
                html.setAttribute('data-bs-theme', 'dark');
                html.setAttribute('data-pc-theme', 'dark');
                html.style.backgroundColor = '#212529';
            } else {
                html.setAttribute('data-bs-theme', 'light');
                html.setAttribute('data-pc-theme', 'light');
                html.style.backgroundColor = '#f8f9fa';
            }
            localStorage.setItem('theme', theme);
        }
    </script>


    @stack('scripts')

</body>

</html>
