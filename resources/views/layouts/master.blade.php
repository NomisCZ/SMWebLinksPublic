<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
    <meta name="author" content="{{ env('APP_AUTHOR') }}">
    <title>{{ env('APP_NAME') }} {{ isset($title) ? '| '.$title : '' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    @yield('content')
    @stack('scripts')

</body>
</html>
