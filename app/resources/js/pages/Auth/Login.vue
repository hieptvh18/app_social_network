<style scoped src="./login.css"></style>
<script>
import { ref } from "vue";
import { getUser, loginUsername } from "../../api/auth";

export default {
    data() {
        return {
            username: "",
            password: "",
            message: "",
            errors: {},
        };
    },
    methods: {
        handleLogin(e) {
            if (this.validateForm()) {
                this.loginPost();
            }
        },
        validateForm() {
            if (!this.username) {
                this.errors.username = "Username is required!";
            } else {
                let usernamePattern = /^\w{4,14}$/; // not space, 4-14 character
                if (!usernamePattern.test(this.username)) {
                    this.errors.username =
                        "Username is not valid(4-14 charactor)!";
                } else delete this.errors["username"];
            }

            // password
            if (!this.password) {
                this.errors.password = "Password is required";
            } else delete this.errors["password"];

            if (Object.keys(this.errors).length) {
                return false;
            }
            return true;
        },
        async loginPost() {
            await loginUsername({
                username: this.username,
                password: this.password,
            })
                .then((response) => {
                    if (response.data.status == "ok") {
                        window.localStorage.setItem(
                            "tokenLogin",
                            response.data.data.token
                        );
                        window.location.href = "/";
                    }
                })
                .catch((err) => {
                    if (err.response.status == 401) {
                        this.message = err.response.data.message;
                        console.log(this.message);
                    }
                });
        },
    },
};
</script>

<template>
    <div class="wrapper-login">
        <link
            href="https://fonts.googleapis.com/css?family=Indie+Flower|Overpass+Mono"
            rel="stylesheet"
        />

        <div id="wrapper">
            <div class="login-page main-content">
                <div class="header">
                    <router-link :to="{ path: 'home' }">
                        <img :src="'../../../../assets/images/in.png'" />
                    </router-link>
                </div>
                <div class="l-part">
                    <form @submit.prevent="handleLogin">
                        <input
                            v-model="username"
                            type="text"
                            placeholder="Username"
                            name="username"
                            class="input-1"
                        />
                        <small class="text text-danger">{{
                            errors.username ?? errors.username
                        }}</small>
                        <div class="overlap-text">
                            <input
                                v-model="password"
                                type="password"
                                name="password"
                                placeholder="Password"
                                class="input-2"
                            />
                            <a href="#">Forgot?</a>
                        </div>
                        <small class="text text-danger">{{
                            errors.password ?? errors.password
                        }}</small>
                        <div class="error text-danger">{{ message }}</div>
                        <input type="submit" value="Log in" class="btn" />
                    </form>
                </div>
            </div>
            <div class="sub-content">
                <div class="s-part">
                    Don't have an account?<router-link
                        :to="{ name: 'register' }"
                        >Sign up</router-link
                    >
                </div>
            </div>
        </div>
        <footer class="text-center">
            @contact to <a href = "mailto: hipbu18@gmail.com">hipbu18@gmail.com</a> for work!
        </footer>
    </div>
</template>
