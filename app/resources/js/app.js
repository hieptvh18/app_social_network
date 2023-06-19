// app.js

import {createApp} from 'vue';
import * as Vue from 'vue';
import('./bootstrap');
import router from './routes';
// use vue cookie
import * as VueCookies from 'vue-cookies';
// using antdesign ui lib
import Antd from 'ant-design-vue';
// import 'ant-design-vue/dist/antd.css';

import App from './App.vue';


window.Vue = Vue;
const app = createApp(App);

app.use(router);
app.use(VueCookies);
router.app = app;
// app.use(Antd);

app.mount('#app');

