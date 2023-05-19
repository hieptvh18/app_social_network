<script setup>
import {ref} from 'vue';
import axios from 'axios';

const form = ref({
    email:'',
    password:''
});

const handleLogin = async (e) =>{
    e.preventDefault();
    
    await axios.post('http://127.0.0.1:8000/api/v1/accounts/login',{
        email: form.value.email,
        password: form.value.password
    })
}
</script>

<template>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Overpass+Mono" rel="stylesheet">

    <div id="wrapper">
        <div class="main-content">
            <div class="header">
                <img src="https://i.imgur.com/zqpwkLQ.png" />
            </div>
            <div class="l-part">
                <form @submit="handleLogin">
                    <input v-model="form.email" type="email" placeholder="Email" name="email" class="input-1" />
                    <div class="overlap-text">
                        <input v-model="form.password" type="password" name="password" placeholder="Password" class="input-2" />
                        <a href="#">Forgot?</a>
                    </div>
                    <input type="submit" value="Log in" class="btn" />
                </form>
            </div>
        </div>
        <div class="sub-content">
            <div class="s-part">
                Don't have an account?<router-link :to="{name:'register'}">Sign up</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import LoginStyle from './login.css';

export default {
    components: {
        LoginStyle
    }
}
</script>
