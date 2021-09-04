<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}">
        <title>Larvel & vueJs</title>
        <link href="{{ mix('admin/css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('admin/css/style.css') }}" rel="stylesheet">
    </head>
    <body class="c-app">
        <div id="app"></div>
        <script src="{{ mix('/admin/js/app.js') }}"></script>
    </body>
</html>