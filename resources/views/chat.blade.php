<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ mix('js/app.js') }}"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<header class="header">
</header>

<main class="main">
    <ul class="main__comments">
        @foreach($comments as $comment)
            <li class="main__comments__comment comment">
                <p class="comment__user">{{$comment->user}}</p>
                <p class="comment__text">{{$comment->comment}}</p>
            </li>
        @endforeach
    </ul>
</main>
<div class="formWrapper">
    <form action="/chat" class="form" method="POST">
        @csrf
        <input type="text" name="user"
        @if($user != null)
            readonly value = {{$user}}
        @else
            placeholder="ユーザー名を入力してください" 
        @endif
        class="form__user" id="user">
        <input type="hidden" name="room" id="room" value="1">
        <textarea name="comment" class="form__comment" cols="30" rows="3" placeholder="入力してください" id="comment"></textarea>
        <button id="submit" type="button">投稿</button>
    </form>
</div>

<div id="board">
</div>
<script>
    const button = document.getElementById("submit");
    const csrf = document.getElementsByTagName("meta")[0].getAttribute("content");
    button.addEventListener("click",function(e){
        const url = "/chat";
        const user = document.getElementById("user").value;
        const comment = document.getElementById("comment").value;
        const data = {user: user, comment: comment};
        fetch(url,{
            method:"POST",
            cache:"no-cache",
            headers: {
                "X-CSRF-TOKEN": csrf,
                "Content-Type":'application/json'
            },
            body:JSON.stringify(data)
        }).then((res) =>{
            return res.json();
        }).then((txt) => {
            if(txt.errors['user']){
                let user = document.querySelector(".form__user");
                user.classList.add("error");
            };
            if(txt.errors['comment'][0]){
                let comment = document.querySelector(".form__comment");
                comment.classList.add("error");
            };
        });
        return false;
    });

    window.Echo.channel("channelName").listen("PusherEvent", e => {
        let e_user = document.querySelector(".form__user");
        e_user.classList.remove("error");
        let e_comment = document.querySelector(".form__comment");
        e_comment.classList.remove("error");
        let comments = document.querySelector(".main__comments");
        let comment = document.createElement("li");
        comment.classList.add("main__comments__comment");
        comment.classList.add("comment");
        let user = document.createElement("p");
        user.textContent = e.posts.user;
        user.classList.add("comment__user");
        let text = document.createElement("p");
        text.textContent = e.posts.comment;
        text.classList.add("comment__text");
        comment.appendChild(user);
        comment.appendChild(text);
        comments.appendChild(comment);
        comments.scrollTo(0, comments.scrollHeight);
    });
</script>