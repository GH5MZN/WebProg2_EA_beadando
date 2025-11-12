<!DOCTYPE html><!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])><html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

    <head>    <head>

        <meta charset="utf-8">        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta name="viewport" content="width=device-width, initial-scale=1">



        {{-- Inline script to detect system dark mode preference and apply it immediately --}}        {{-- Inline script to detect system dark mode preference and apply it immediately --}}

        <script>        <script>

            (function() {            (function() {

                const appearance = '{{ $appearance ?? "system" }}';                const appearance = '{{ $appearance ?? "system" }}';



                if (appearance === 'system') {                if (appearance === 'system') {

                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;



                    if (prefersDark) {                    if (prefersDark) {

                        document.documentElement.classList.add('dark');                        document.documentElement.classList.add('dark');

                    }                    }

                }                }

            })();            })();

        </script>        </script>



        {{-- Inline style to set the HTML background color based on our theme in app.css --}}        {{-- Inline style to set the HTML background color based on our theme in app.css --}}

        <style>        <style>

            html {            html {

                background-color: oklch(1 0 0);                background-color: oklch(1 0 0);

            }            }



            html.dark {            html.dark {

                background-color: oklch(0.145 0 0);                background-color: oklch(0.145 0 0);

            }            }

        </style>        </style>



        <title inertia>{{ config('app.name', 'Laravel') }}</title>        <title inertia>{{ config('app.name', 'Laravel') }}</title>



        <link rel="icon" href="/favicon.ico" sizes="any">        <link rel="icon" href="/favicon.ico" sizes="any">

        <link rel="icon" href="/favicon.svg" type="image/svg+xml">        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <link rel="apple-touch-icon" href="/apple-touch-icon.png">        <link rel="apple-touch-icon" href="/apple-touch-icon.png">



        <link rel="preconnect" href="https://fonts.bunny.net">        <link rel="preconnect" href="https://fonts.bunny.net">

        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

                

        <!-- Bootstrap CSS -->        <!-- Bootstrap CSS -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

                

        <!-- F1 Custom Styles -->        <!-- F1 Custom Styles -->

        <link href="{{ asset('css/f1-styles.css') }}" rel="stylesheet">        <link href="{{ asset('css/f1-styles.css') }}" rel="stylesheet">



        {{-- @viteReactRefresh --}}        {{-- @viteReactRefresh --}}

        {{-- @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"]) --}}        {{-- @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"]) --}}

        @inertiaHead        @inertiaHead

    </head>    </head>

    <body class="font-sans antialiased">    <body class="font-sans antialiased">

        @inertia        @inertia

                

        <!-- Bootstrap JS -->        <!-- Bootstrap JS -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>    </body>

</html></html>
