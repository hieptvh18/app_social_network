<template>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Overpass+Mono" rel="stylesheet">

    <div id="wrapper">
        <div class="main-content">
            <div class="header">
                <img src="https://i.imgur.com/zqpwkLQ.png" />
            </div>
            <div class="l-part">
                <input type="text" placeholder="Username" class="input-1" />
                <div class="overlap-text">
                    <input type="password" placeholder="Password" class="input-2" />
                    <a href="#">Forgot?</a>
                </div>
                <input type="button" value="Log in" class="btn" />
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
