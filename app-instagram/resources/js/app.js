// app.js

import {createApp} from 'vue';
import('./bootstrap');
import router from './routes';

import App from './App.vue';

const app = createApp(App);

app.use(router);

app.mount('#app');

