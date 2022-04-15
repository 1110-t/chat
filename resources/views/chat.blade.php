<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ mix('js/app.js') }}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
<header class="header">
</header>

<main class="main">
    <ul class="main__comments" id="app">
        <test-vue :comments={{$comments}}></test-vue>
    </ul>
</main>

<div class="formWrapper" id="app2">
    <form-vue :csrf="{{json_encode(csrf_token())}}" :user="{{json_encode($user)}}"></form-vue>
</div>

</body>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    // const button = document.getElementById("submit");
    // const csrf = document.getElementsByTagName("meta")[0].getAttribute("content");
    // button.addEventListener("click",function(e){
    //     const url = "/chat/aiueo";
    //     const user = document.getElementById("user").value;
    //     const comment = document.getElementById("comment").value;
    //     const data = {user: user, comment: comment};
    //     fetch(url,{
    //         method:"POST",
    //         cache:"no-cache",
    //         headers: {
    //             "X-CSRF-TOKEN": csrf,
    //             "Content-Type":'application/json'
    //         },
    //         body:JSON.stringify(data)
    //     }).then((res) =>{
    //         return res.json();
    //     }).then((txt) => {
    //         if(txt.errors){
    //             // 0.5秒間だけフォームを震わせる
    //             let form = document.querySelector(".form");
    //             form.classList.add("vibration");
    //             setTimeout(function(){
    //                 form.classList.remove("vibration");
    //             },500);
    //             if(txt.errors['user']){
    //                 let user = document.querySelector(".form__user");
    //                 user.classList.add("error");
    //             };
    //             if(txt.errors['comment'][0]){
    //                 let comment = document.querySelector(".form__comment");
    //                 comment.classList.add("error");
    //             };
    //         };
    //     });
    //     return false;
    // });

    // window.Echo.channel("channelName").listen("PusherEvent", e => {
    //     let e_user = document.querySelector(".form__user");
    //     e_user.classList.remove("error");
    //     let e_comment = document.querySelector(".form__comment");
    //     e_comment.classList.remove("error");
    //     let comments = document.querySelector(".main__comments");
    //     let comment = document.createElement("li");
    //     comment.classList.add("hidden");
    //     setTimeout(function(){
    //         comment.classList.remove("hidden");
    //     },50);
    //     comment.classList.add("main__comments__comment");
    //     comment.classList.add("comment");
    //     let user = document.createElement("p");
    //     user.textContent = e.posts.user;
    //     user.classList.add("comment__user");
    //     let text = document.createElement("p");
    //     text.textContent = e.posts.comment;
    //     text.classList.add("comment__text");
    //     // ユーザー名の入力欄を固定にする
    //     document.querySelector(".form__user").setAttribute("readonly","")
    //     // チャットを追加する
    //     comment.appendChild(user);
    //     comment.appendChild(text);
    //     comments.appendChild(comment);
    //     // 今書いているチャットを削除する
    //     e_comment.value = "";
    //     // スクロールを一番下に持ってくる
    //     comments.scrollTo(0, comments.scrollHeight);
    // });
</script>