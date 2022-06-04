<template>
    <form class="form" :class="{vibration: isError}">
        <input type="hidden" name="_token" :value="csrf">
        <input type="text" name="user" class="form__user" id="user" :class="{error: error.user}" v-if="user!=null" readonly :value="user">
        <input type="text" name="user" class="form__user" id="user" :class="{error: error.user}" v-model="preUser" v-else placeholder="ユーザー名を入力してください">
        <input type="hidden" name="room" id="room" v-model="room">
        <textarea name="comment" v-model="comment" class="form__comment" :class="{error: error.comment}" cols="30" rows="3" placeholder="入力してください" id="comment"></textarea>
        <button id="submit" type="button" v-on:click="postComment">投稿</button>
    </form>
</template>

<script>
export default ({
    data() {
        return {
            isError: false,
            error:{},
            preUser:"",
            comment:"",
        }
    },
    props: {
        url:{type: String,required: true,default:"/chat/aiueo"},
        csrf:{type: String,required: true},
        room:{type: String,required: true},
        user:{type: String,required: true},
    },
    methods: {
        postComment: function(e){
            let postUser = "";
            if(this.user != null){
                postUser = this.user;
            } else{
                postUser = this.preUser;
            };
            axios.post(this.url, {
                "user":postUser,
                "comment":this.comment,
                "room_id":this.room
            },{
                headers:{
                    "X-CSRF-TOKEN":this.csrf,
                    "Content-Type":'application/json'
                }
            }).then((txt) => {
                console.log(txt);
                this.error = {};
                this.comment = "";
            }).catch(error => {
                this.isError = true;
                // ユーザーかコメントのエラーを処理する
                let e = error.response.data;
                for(let i in e.errors){
                    if(e.errors[i]){
                        this.error[i] = true;
                    };
                };
                setTimeout(()=>{
                    this.isError = false;
                },500);
            });
        },
    },
})
</script>