<template>
    <div class="list-post">
        <!-- <div v-for="(post, key) in postListing" class="list-post__items"> -->
            <!-- <div class="item mb-2" v-bind:key="key"> -->
            <!-- loading data with layzyload -->
            <LazyList
                :data="postListing"
                :itemsPerRender="15"
                containerClasses="list-post__items"
                defaultLoadingColor="#222"
            >
                <template v-slot="{ item }" class="item mb-2">
                    <div class="item__top">
                        <div
                            class="item-profile-box d-flex justify-content-between p-2 align-items-center"
                        >
                            <div class="item-profile d-flex align-items-center">
                                <div class="profile-avatar mr-2">
                                    <router-link
                                        :to="{
                                            name: 'profile',
                                            params: {
                                                username: item.author.username,
                                            },
                                        }"
                                    >
                                        <img
                                            :style="{ width: '100%' }"
                                            :src="item.author.avatar"
                                        />
                                    </router-link>
                                </div>
                                <div class="profile-name">
                                    <a href="./profile-following.html"
                                        ><router-link
                                            :to="{
                                                name: 'profile',
                                                params: {
                                                    username:
                                                        item.author.username,
                                                },
                                            }"
                                            >{{
                                                item.author.username
                                            }}</router-link
                                        ></a
                                    >
                                </div>
                            </div>
                            <div class="bars">...</div>
                        </div>
                    </div>
                    <div class="item__content">
                        <div class="content-photos">
                            <div class="photos__gallery">
                                <!-- using swiper slider-->
                                <swiper
                                    :navigation="true"
                                    :modules="modules"
                                    class="mySwiper"
                                >
                                    <swiper-slide
                                        v-for="(image, keyImg) in item.images"
                                    >
                                        <img
                                            @click="showPostDetail(item.id)"
                                            :style="{ width: '100%' }"
                                            :src="image.image"
                                            :alt="item.captions"
                                        />
                                    </swiper-slide>
                                </swiper>
                            </div>
                            <div class="photos__content pb-2 pl-2 pr-2">
                                <div
                                    class="photos__icon d-flex align-items-center"
                                >
                                    <ButtonLike
                                        v-if="item.id"
                                        :isLike="checkLiked(item)"
                                        :post="item"
                                    />

                                    <div
                                        class="icon-comment"
                                        @click="showPostDetail(item.id)"
                                    >
                                        <i
                                            class="fa-regular fa-comment mr-2"
                                        ></i>
                                        <span v-if="item.comments_count"
                                            >{{
                                                item.comments_count
                                            }}
                                            comments</span
                                        >
                                    </div>
                                </div>
                                <div class="photos__caption">
                                    <span class="font-weight-bold">{{
                                        item.author.username
                                    }}</span>
                                    {{ item.captions ?? item.captions }}
                                </div>
                                <!-- <a href class="show-comment text-secondary">more</a> -->
                                <div class="photos__created-at text-secondary">
                                    {{ item.created_at }}
                                </div>

                                <FormComment :postId="item.id" />
                            </div>
                        </div>
                    </div>
                    <div class="item__footer"></div>
                </template>

                <!-- </div> -->
            </LazyList>
        <!-- </div> -->
        <!-- show detail post with modal dynamic -->
        <ModalPostDetail
            v-if="postId && isShowModalPost"
            @closeModal="closeModal"
            :postId="postId"
            :isShowModalPost="isShowModalPost"
        />
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Navigation } from "swiper/modules";
import { ref } from "vue";
import FormComment from "./FormComment.vue";
import ModalPostDetail from "./ModalPostDetail.vue";
import ButtonLike from "./ButtonLike.vue";
import LazyList from "lazy-load-list/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
export default {
    components: {
        Swiper,
        SwiperSlide,
        FormComment,
        ModalPostDetail,
        ButtonLike,
        LazyList,
    },
    data() {
        return {
            loader: false,
            postId: "",
            isShowModalPost: false,
        };
    },
    methods: {
        showPostDetail(postId) {
            this.postId = postId;
            this.isShowModalPost = true;
        },
        closeModal() {
            this.isShowModalPost = false;
        },
    },
    props: ["postListing"],
    setup(props) {
        let isLiked = false;
        const listMyComment = [];

        // check liked
        const checkLiked = (post) => {
            let currenUserId = window.userLogginIn.id;
            let result = post.likes.filter(
                (val) => val.user_id == currenUserId
            );

            result.length ? (isLiked = true) : (isLiked = false);

            return result.length;
        };

        return {
            modules: [Navigation],
            checkLiked,
            isLiked,
            listMyComment,
        };
    },
};
</script>
<style scoped>
.icon__likes i.active {
    color: red;
}
.photos__icon div {
    cursor: pointer;
}
.photos__icon i {
    font-size: 25px;
}
.icon__likes .liked {
    color: red;
}
.list-post .item {
    border-radius: 5px;
    background: #e7e7e7;
}
.photos__gallery {
    cursor: pointer;
    height: 578px;
}
.photos__gallery img {
    height: 100%;
    object-fit: cover;
}

.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;

    /* Center slide text vertically */
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.swiper-button-prev {
    background: #e7e7e7;
}
</style>
