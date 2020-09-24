<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link  rel="icon"   href="https://www.flaticon.es/svg/static/icons/svg/1818/1818696.svg" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('plugins/select2-4.0.13/dist/js/select2.full.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2-4.0.13/dist/css/select2.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <div class="mt-5">
            @yield('contenido')
        </div>
    </div>

    @yield('script')
</body>

</html>