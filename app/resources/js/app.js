// app.js
import { createPinia } from 'pinia';
import {createApp} from 'vue';
import * as Vue from 'vue';
import('./bootstrap');
import router from './routes';
// use vue cookie
import * as VueCookies from 'vue-cookies';
import { initializeApp } from "firebase/app";
import App from './App.vue';


window.Vue = Vue;
const app = createApp(App);

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyCK26fh8ECHqw85kD6ibLWbS-HG4BPiT5s",
    authDomain: "vuesocialnetwork-e97c9.firebaseapp.com",
    projectId: "vuesocialnetwork-e97c9",
    storageBucket: "vuesocialnetwork-e97c9.appspot.com",
    messagingSenderId: "687245698859",
    appId: "1:687245698859:web:8b7ec64f45b9ce519b876e"
  };

  // Initialize Firebase
initializeApp(firebaseConfig);

// using pinia to
app.use(createPinia())
app.use(router);
app.use(VueCookies);
router.app = app;

app.mount('#app');

