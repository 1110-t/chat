<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body id="appRoom">
<header class="header">
    <h1 class="header__title">Chatty</h1>
    <add-vue :csrf="{{json_encode(csrf_token())}}"></add-vue>
</header>

<main class="main">
    <room-vue :rooms="{{json_encode($rooms)}}" :csrf="{{json_encode(csrf_token())}}"></room-vue>
</main>

</body>
<script src="{{ asset('js/app.js') }}"></script>