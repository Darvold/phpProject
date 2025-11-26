<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>phpProject</title>
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
</head>
<body>
<div id="auth"></div>

@vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>
