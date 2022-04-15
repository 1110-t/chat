require('./bootstrap');

import { createApp } from 'vue';
import TestVue from './components/TestVue.vue';
import FormVue from './components/FormVue.vue';

const app1 = createApp({})
app1.component('test-vue', TestVue);
app1.mount('#app');
const app2 = createApp({})
app2.component('form-vue', FormVue);
app2.mount('#app2');