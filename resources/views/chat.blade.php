<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body id="appChat">
    <header class="header">
    </header>

    <main class="main">
        <ul class="main__comments">
            <test-vue :comments={{$comments}} :room="{{json_encode($room)}}" :csrf="{{json_encode(csrf_token())}}"></test-vue>
        </ul>
    </main>

    <div class="formWrapper">
        <form-vue :csrf="{{json_encode(csrf_token())}}" :user="{{json_encode($user)}}" :room="{{json_encode($room)}}"></form-vue>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>