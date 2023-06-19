<template>
    <div v-if="!loading" class="profile m-5">
        <div class="content-profile d-flex align-items-center">
            <div class="content-profile__img">
                <img
                    :src="userDataFromParam.avatar"
                    :alt="userDataFromParam.name"
                />
            </div>
            <div class="content-profile-main ml-4">
                <div class="content-profile-top d-inline">
                    <span class="name mr-3">{{
                        userDataFromParam.username
                    }}</span>
                    <router-link :to="{ name: 'account-edit' }" v-if="myProfile" >
                        <button class="btn btn-light mr-3">Edit profile</button>
                    </router-link>

                    <button class="btn btn-success" :data-follow="userDataFromParam.username" v-if="!myProfile" @click="follow(userDataFromParam.username)">Follow + </button>

                    <button v-if="myProfile"><i class="fa fa-cog"></i></button>
                </div>
                <div class="content-profile-count d-flex mb-3">
                    <span class="count-post mr-3"
                        ><span class="font-weight-bold">{{
                            userDataFromParam.posts.length
                                ? userDataFromParam.posts.length
                                : 0
                        }}</span>
                        post</span
                    >
                    <div class="count-follower mr-3">
                        <span class="font-weight-bold">133</span> followers
                    </div>
                    <div class="count-following">
                        <span class="font-weight-bold">133</span> following
                    </div>
                </div>
                <div class="content-profile-fullname">
                    <span>{{ userDataFromParam.name }}</span>
                    <span>{{
                        userDataFromParam.bio ?? userDataFromParam.bio
                    }}</span>
                </div>
            </div>
        </div>
        <div class="content-stories mt-5 pb-5">
            <div class="story-headers d-flex mb-3">
                <div class="story-headers__item mr-4">
                    <div class="avatar active">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg"
                            alt=""
                        />
                    </div>
                    <div class="story-name">thu_thao2</div>
                </div>

                <div class="story-headers__item mr-4">
                    <div class="avatar active">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg"
                            alt=""
                        />
                    </div>
                    <div class="story-name">thu_thao2</div>
                </div>

                <!-- add new story -->
                <div class="story-headers__item text-center" v-if="myProfile">
                    <div
                        class="avatar add-new d-flex justify-content-center align-items-center"
                    >
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="story-name font-weight-bold">new</div>
                </div>
            </div>
        </div>
        <div class="content-gallery">
            <div class="gallery__header">Posts</div>
            <div class="gallery__items d-flex">
                <div class="gallery__item">
                    <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQj0P5UaXPM-iOOHh9o9JrktCiqXnfpzlCsqA&usqp=CAU"
                        alt=""
                    />
                </div>
                <div class="gallery__item">
                    <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQj0P5UaXPM-iOOHh9o9JrktCiqXnfpzlCsqA&usqp=CAU"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </div>
    <ModalLoading v-if="loading" />
</template>
<style scoped src="./index.css"></style>

<script setup>
import { useRoute } from "vue-router";
import { getUser } from "../../api/auth";
import { getUserByUsername } from "../../api/user";
import { ref } from "vue";

var userLoggin = ref({});
var userDataFromParam = ref({});
var loading = ref(true);
var myProfile = ref(true);

const route = useRoute();
let username = route.params.username;

const getUserLoggin = getUser()
    .then((response) => {
        if (response.statusText == "OK") {
            userLoggin = response.data.data;
        }
    })
    .catch((err) => {
        console.log(err);
    });
// .then(()=> loading.value = false)

let formdata = new FormData();
formdata.username = username;
const getUserDataFromParam = getUserByUsername(formdata)
    .then((response) => {
        console.log(response);
        if (response.data.success == true) {
            userDataFromParam.value = response.data.data;
            // compare is my profile or guest profile
            if (response.data.data.id != userLoggin.id) {
                myProfile.value = false;
            }
        } else {
            window.location.href = "/404.html";
        }
    })
    .catch((err) => {
        console.log(err);
    })
    .then(() => (loading.value = false));
</script>

<script>
import ModalLoading from "../../components/ModalLoading.vue";

export default {
    components: { ModalLoading },
    data() {
        return {};
    },
    props:{
        userData:Object
    },
    methods: {
        getUserData(){
            console.log('props data from layout');
            console.log(this.userData);
        },
        follow(username){
            console.log(username);
        }
    },
    beforeMount(){
        this.getUserData();
    }
};
</script>
