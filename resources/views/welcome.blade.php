<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <div id="app">
        <router-view csrf="{{csrf_token()}}"></router-view>
    </div>
    <script src="http://localhost:6001/socket.io/socket.io.js"></script>
    <script src="{{ url('js/app.js') }}"></script>
    {{-- <script src="{{ mix('js/vendor.js') }}"></script> --}}
</html>


