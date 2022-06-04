<template>
    <transition-group name="list" @before-enter="beforeEnter" @after-enter="afterEnter" @enter="Enter">
        <li v-for="comment in comments_s" :key="comment" class="main__comments__comment comment">
            <p class="comment__user">{{comment.user}}</p>
            <p class="comment__text">{{comment.comment}}</p>
        </li>
    </transition-group>
</template>

<script>
export default ({
    props: {
        comments: [],
        room:{type: Number,required: true},
    },
    data(){
        return{
            comments_s: this.comments
        }
    },
    mounted(){
        window.Echo.channel(this.room).listen("PusherEvent", e => {
            this.comments_s.push(e.posts);
        })
    },
    methods: {
        postComment: function(){
            console.log("aiueo")
        },
        beforeEnter(el){
            el.style.transitionDelay = '500ms'
        },
        Enter(el){
            let comments = document.querySelector(".main__comments");
            comments.scrollTo(0, comments.scrollHeight);
        },
        afterEnter(el) {
            console.log(el);
        }
    },
})
</script>