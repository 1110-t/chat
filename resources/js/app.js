require('./bootstrap');

import { createApp } from 'vue';
import TestVue from './components/TestVue.vue';
import FormVue from './components/FormVue.vue';
import RoomVue from './components/RoomVue.vue';
import AddVue from './components/AddVue.vue';

// appChat
createApp({
    components:{
        TestVue,FormVue
    }
}).mount('#appChat')

// appRoom
createApp({
    components:{
        RoomVue,AddVue
    }
}).mount('#appRoom')