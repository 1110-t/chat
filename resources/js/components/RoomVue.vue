<template>
    <ul class="rooms">
    <add :csrf="csrf"></add>
    <transition-group name="list"
    @before-enter="beforeEnter"
    @after-enter="afterEnter"
    @enter-cancelled="afterEnter">
        <li v-for="(content,index) in contents"
            :key="content"
            :data-index="index"
            class="room"
        >
        <a class="link" :href="'./chat/'+content.id">
          <h3 class="title">{{content.name}}</h3>
        </a>
        </li>
    </transition-group>
    </ul>
</template>

<script>
import add from './AddVue.vue'
export default ({
    props: {
        rooms: [],
        csrf:[]
    },
    components: {
      add
    },
    data(){
        return{
            contents:[]
        }
    },
    mounted(){
      setTimeout(()=>{
        this.contents = this.rooms;
      },300);
      window.Echo.channel("Room").listen("RoomEvent", e => {
          this.contents.push(e.posts);
      });
    },
    methods: {
      beforeEnter(el){
        el.style.transitionDelay = 100 * parseInt(el.dataset.index, 10) + 'ms'
      },
      afterEnter(el) {
        el.style.transitionDelay = ''
      }
    }
})
</script>

<style scoped>
    .list-enter-active {
      transition: all 0.3s ease;
    }
    .list-enter-from {
      transform: translateY(30px);
      opacity: 0;
    }
    .list-enter-to{
      opacity: 1;
    }
    .rooms{
      max-width:80%;
      padding: 0;
      position:relative;
      display: grid;
      gap: 30px 30px;
      grid-template-columns: repeat(auto-fill, minmax(min-content, 300px));
      grid-template-rows: max-content max-content 1fr auto;
    }
    .room{
      width: 300px;
      height: 150px;
      box-shadow: 5px 5px 5px 0px rgb(0 0 0 / 30%);
    }
    .title{
      padding: 10px;
      box-sizing: content-box;
    }
    .link{
      width:100%;
      height:100%;
      display:block;
    }
</style>