<template :key="keyParentComponent">
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
                        class="btn mr-3"
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

                    <router-link
                        :to="{
                            name: 'chatdetail',
                            params: { id: userDataFromParam.id },
                        }"
                    >
                        <button v-if="!myProfile" class=" mr-3 btn btn-warning">
                            <span>Chat</span>
                        </button>
                    </router-link>

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
                    <div
                        class="count-follower mr-3"
                        @click="showModal('follower')"
                    >
                        <span class="font-weight-bold">{{
                            userDataFromParam.follower_list.length
                        }}</span>
                        followers
                    </div>
                    <div
                        class="count-following"
                        @click="showModal('following')"
                    >
                        <span class="font-weight-bold">{{
                            userDataFromParam.following_list.length
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

                <!-- modal -->
                <ModalDynamic
                    v-if="isModalVisible"
                    v-show="isModalVisible"
                    @close="closeModal"
                >
                    <template v-slot:header>
                        {{ dataTitleModal }}
                    </template>
                    <template v-slot:body>
                        <div v-html="dataBodyModal"></div>
                    </template>
                </ModalDynamic>
            </div>
        </div>
        <div class="content-stories mt-5 pb-5">
            <Stories :isMyProfile="myProfile" />
        </div>

        <!-- list post -->
        <GalleryItems
            v-if="userDataFromParam.posts"
            :posts="userDataFromParam.posts"
            :isMyProfile="myProfile"
            @reloadComponent="reloadComponent"
            :key="keyParentComponent"
        />
    </div>
    <ModalLoading v-if="loading" />
</template>
<style scoped src="./index.css"></style>
<style>
/* modal follow */
.img-avatar{
    min-width: 30px;
    border-radius: 50%;
    overflow: hidden;
}
</style>
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
var isModalVisible = ref(false);
var dataBodyModal = ref("");
var dataTitleModal = ref("");
var keyParentComponent = ref(0);

const route = useRoute();
let username = route.params.username;
const baseUrl = window.location.origin;

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
const getUserDataFromParam = () => {
    getUserByUsername(username)
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
    console.log("type: " + isUserFollowed.value);
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
        .catch((err) => {
            console.log(err);
        });
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
        .catch((err) => {
            console.log(err);
        });
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

// handle display list follow
const handleShowListFollow = (type) => {
    if (type == "follower") {
        dataTitleModal.value = "Followers";
        let listFollower = userDataFromParam.value.follower_list;
        if (listFollower.length) {
            let elList = `<div class="list-follows">`;
            listFollower.forEach((val, index) => {
                elList += '<div class=" d-flex align-items-center mb-3">';
                let avatarEl = '<img alt="avatar"/>';
                if (val.avatar) {
                    avatarEl = `<img alt="avatar" src="${val.avatar}" style="width:30px"/>`;
                }
                elList += '<div class="img-avatar mr-2">' + avatarEl + "</div>";
                elList += `<div class="name">
                            <div class="font-weight-bold"><a href="${baseUrl}/${val.username}">${val.username}<a/></div>
                                <div>${val.name}</div>
                            </div>`;
                elList += "</div>";
                elList += `</div>`;

                dataBodyModal.value = elList;
            });
        } else {
            dataBodyModal.value = "No follower";
        }
    } else {
        dataTitleModal.value = "Following";
        let listFollowing = userDataFromParam.value.following_list;
        let elList = `<div class="list-follows">`;
        if (listFollowing.length) {
            listFollowing.forEach((val, index) => {
                elList += '<div class=" d-flex align-items-center mb-3">';
                let avatarEl = '<img alt="avatar"/>';
                if (val.avatar) {
                    avatarEl = `<img alt="avatar" src="${val.avatar}" style="width:30px"/>`;
                }
                elList += '<div class="img-avatar mr-2">' + avatarEl + "</div>";
                elList += `<div class="name">
                                <div class="font-weight-bold"><a href="${baseUrl}/${val.username}">${val.username}<a/></div>
                                <div>${val.name}</div>
                            </div>`;
                elList += "</div>";
                elList += `</div>`;
                dataBodyModal.value = elList;
            });
        } else {
            dataBodyModal.value = "No following";
        }
    }
};

const showModal = (type) => {
    isModalVisible.value = true;
    handleShowListFollow(type);
};
const closeModal = (type) => {
    isModalVisible.value = false;
};
// reload component when change data
const reloadComponent = () => {
    keyParentComponent.value = 1;
    getUserDataFromParam();
};
</script>

<script>
import ModalLoading from "../../components/ModalLoading.vue";
import GalleryItems from "../../components/Profile/GalleryItems.vue";
import Stories from "../../components/Profile/Stories.vue";
import ModalDynamic from "../../components/ModalDynamic/index.vue";

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
    methods: {},
};
</script>
