<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{ mix('css/app.css')}}" />
    <link rel="stylesheet" href="{{ mix('css/style.css')}}" />

</head>

<body>
    <div id="root"></div>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>