<template>
    <div class="web-wrapper row">
        <!-- sidebar menu -->
        <Sidebar v-if="userDataLogin" :userData="userDataLogin" />
        <!-- main content insta -->
        <main
            class="page-content col-xs-12 col-md-9"
            style="position: absolute; right: 0; top: 0"
        >
            <router-view v-if="userDataLogin" :userData="userDataLogin"></router-view>
            <div class="modal-backdrop-cus"></div>
        </main>
    </div>
</template>
<style>
.modal-backdrop-cus{
    position: fixed;
    width: 100%;
    height: 100%;
    background: green;
    top: 0;
    left: 0;
    opacity: 0.2;
    z-index: 1;
    display: none;
}
.modal-backdrop-cus.active{
    display: block;
}
</style>
<script setup>
import { ref } from "vue";
import { getUser } from "../api/auth";

var userDataLogin = ref("");
var loading = ref(true);
// fetch data user login
getUser()
    .then((response) => {
        if ((response.data.success = true)) {
            userDataLogin.value = response.data.data;
            //  save global current user login
            window.userLogginIn = response.data.data;
        }
    })
    .catch((err) => {
        console.log("fetch error: " + err);
    })
    .then(() => {
        loading.value = false;
    });
</script>

<script>
import Sidebar from "../components/Sidebar/index.vue";

export default {
    components: { Sidebar },
    data() {
        return {};
    },
};
</script>
