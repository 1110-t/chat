<template>
    <div class="newRoom">
        <button class="newRoomButton" v-on:click="display">make room</button>
    </div>
    <transition name="fade">
        <div class="addForm" v-if="isDisplay" v-on:click="display">
            <form class="form" :class="{'vibration': isError}">
                <input type="hidden" name="_token" :value="csrf">
                <input type="text" name="name" v-model="name">
                <button id="submit" type="button" v-on:click="postRoom">make</button>
            </form>
        </div>
    </transition>
</template>

<script>
export default ({
    props: {
    },
    data(){
        return{
            isDisplay: 0,
            url:"/chat",
            error:{}
        }
    },
    props: {
        csrf:{type: String,required: true},
    },
    mounted(){
    },
    methods: {
        display: function(e){
            this.isDisplay = !this.isDisplay
        },
        postRoom:function(e){
            axios.post(this.url, {
                "name":this.name,
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
        }
    },
})
</script>

<style scoped>
    .newRoom{
      position: absolute;
      right: 0;
      display:flex;
      align-items:center;
      height: 100px;
      top:-100px;
    }
    .newRoomButton{
      height:30px;
      width:100px;
      position:relative;
      padding: 0 5px 5px 0;
      box-sizing: content-box;
      box-shadow: 5px 5px 5px -1px rgb(0 0 0 / 30%);
      font-weight:bold;
    }
    .newRoomButton:before{
      content: "";
      display: block;
      border-bottom: 1px solid black;
      width: 115px;
      bottom: 0;
      position: absolute;
      left: -5px;
    }
    .newRoomButton:after{
      content: "";
      display: block;
      border-right: 1px black solid;
      height: 40px;
      position:absolute;
      top: 0;
      right: 0px;
    }
    /* フェードイン・フェードアウト中の設定 */
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.3s ease-out;
    }
    .fade-enter-from {
      opacity: 0;
    }
    /* フェードイン開始時・フェードアウト終了時の設定 */
    .fade-leave-to {
        opacity: 0;
    }
    .addForm{
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        background-color: rgb(0 0 0 / 60%);
    }
    .addForm form{
        display: flex;
        flex-direction: column;
        padding: 0;
        width: 30%;
        min-width: 350px;
        margin: auto;
        padding-top: 100px;
    }
    .addForm form input{
        border:none;
    }
    .addForm form button{
        margin: 30px auto;
        color: white;
        border-right: 1px white solid;
        border-bottom: 1px white solid;
        box-shadow: 5px 5px 5px 0px rgb(255 255 255 / 30%);
        padding: 5px 15px;
        border-radius: 3px;
        font-weight: bold;
    }
</style>