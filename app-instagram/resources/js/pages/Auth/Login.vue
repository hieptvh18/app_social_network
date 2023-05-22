<script setup>
import LoginStyle from './login.css';
import {ref} from 'vue';
import axios from 'axios';
import {getUser, loginUsername} from '../../api/auth';

const form = ref({
    email:'',
    password:''
});

const error = {
    message:''
};

const handleLogin = async (e) =>{
    await loginUsername({
        email: form.value.email,
        password: form.value.password
    })
    .then(response=>{
        console.log(response);
        if(response.data.status == 'ok'){
            window.location.href = '/';
        }
    })
    .catch(err=>{
        console.log(err.response);
        if(err.response.status == 401){
            error.message = err.response.data.message
            console.log(error.message);
        }
    });
}
</script>

<template>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Overpass+Mono" rel="stylesheet">

    <div id="wrapper">
        <div class="login-page main-content">
            <div class="header">
                <img :src="'../../../../assets/images/in.png'" />
            </div>
            <div class="l-part">
                <form @submit.prevent="handleLogin">
                    <input v-model="form.email" type="email" placeholder="Email" name="email" class="input-1" />
                    <div class="overlap-text">
                        <input v-model="form.password" type="password" name="password" placeholder="Password" class="input-2" />
                        <a href="#">Forgot?</a>
                    </div>
                    <div class="error text-danger" >{{ error.message }}</div>
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
