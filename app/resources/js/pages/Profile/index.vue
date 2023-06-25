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
                    <router-link
                        :to="{ name: 'account-edit' }"
                        v-if="myProfile"
                    >
                        <button class="btn btn-light mr-3">Edit profile</button>
                    </router-link>

                    <button
                        class="btn"
                        :class="{
                            'btn-secondary': isUserFollowed,
                            'btn-success': !isUserFollowed,
                        }"
                        :data-follow="userDataFromParam.username"
                        v-if="!myProfile"
                        @click="handleFollow(userDataFromParam.id)"
                    >
                        {{ isUserFollowed ? "UnFollow" : "Follow +" }}
                    </button>

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
                    <div class="count-follower mr-3" @click="showListFollow">
                        <span class="font-weight-bold">{{
                            userDataFromParam.follower
                        }}</span>
                        followers
                    </div>
                    <div class="count-following" @click="showListFollow">
                        <span class="font-weight-bold">{{
                            userDataFromParam.following
                        }}</span>
                        following
                    </div>
                </div>
                <div class="content-profile-fullname">
                    <div class="profile-username">
                        <b class="fw-bold">{{ userDataFromParam.name }}</b>
                    </div>
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
        <!-- gallery list -->
        <GalleryItems
            v-if="userDataFromParam.posts"
            :posts="userDataFromParam.posts"
        />
    </div>
    <ModalLoading v-if="loading" />
</template>
<style scoped src="./index.css"></style>

<script setup>
import { useRoute } from "vue-router";
import { getUser } from "../../api/auth";
import { getUserByUsername, followUser, unFollowUser } from "../../api/user";
import { ref } from "vue";

var userLoggin = ref({});
var userDataFromParam = ref({});
var loading = ref(true);
var myProfile = ref(true);
var isUserFollowed = ref(false);

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

// get user data from username param
let formdata = new FormData();
formdata.username = username;
const getUserDataFromParam = () => {
    getUserByUsername(formdata)
        .then((response) => {
            console.log(response);
            if (response.data.success == true) {
                userDataFromParam.value = response.data.data;
                // compare is my profile or guest profile
                if (response.data.data.id != userLoggin.id) {
                    myProfile.value = false;
                }
                isUserFollowed.value = isFollowed();
            } else {
                window.location.href = "/404.html";
            }
        })
        .catch((err) => {
            console.log(err);
        })
        .then(() => (loading.value = false));
};
getUserDataFromParam();

// handle follows
const handleFollow = (following_id) => {
    console.log('type: '+isUserFollowed.value);
    if (isUserFollowed.value) {
        unFollow(following_id);
    } else {
        follow(following_id);
    }
};

// follow action
const follow = (following_id) => {
    let dataFollow = {
        user_id: userLoggin.id,
        following_id: following_id,
    };
    followUser(dataFollow)
        .then((res) => {
            if (res.data.success) {
                // re render data
                getUserDataFromParam();

                isUserFollowed.value = isFollowed();
            }
        })
        .catch((err) => {console.log(err);});
};

// unfollow action
const unFollow = (following_id) => {
    let dataUnFollow = {
        user_id: userLoggin.id,
        following_id: following_id,
    };
    unFollowUser(dataUnFollow)
        .then((res) => {
            if (res.data.success) {
                getUserDataFromParam();
                isUserFollowed.value = isFollowed();
            }
        })
        .catch((err) => {console.log(err);});
};

const isFollowed = () => {
    let userLoginId = userLoggin.id;
    let isFollowMe = false;
    let currentFollowing = userDataFromParam.value.follower_list;
    console.log(currentFollowing);
    if (currentFollowing.length) {
        isFollowMe = currentFollowing.filter(
            (val) => val.following_id == userLoginId
        )
            ? true
            : false;
    }
    return isFollowMe;
};
</script>

<script>
import ModalLoading from "../../components/ModalLoading.vue";
import GalleryItems from "../../components/Profile/GalleryItems.vue";

export default {
    components: { ModalLoading, GalleryItems },
    data() {
        return {
            userData: this.userData,
        };
    },
    props: {
        userData: Object,
    },
    methods: {
        showListFollow(type='followers'){
            if(type == 'followers'){

            }else{

            }
        }
    },
};
</script>
