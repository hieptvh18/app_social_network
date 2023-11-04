<template>
    <div class="post-item">
        <div class="item__content">
            <div class="content-photos">
                <div class="photos__gallery item">
                    <!-- using swiper slider-->
                    <swiper
                        :navigation="true"
                        :modules="modules"
                        class="mySwiper"
                    >
                        <swiper-slide v-for="(image, keyImg) in post.images">
                            <img
                                @click="showPostDetail(post.id)"
                                :style="{ width: '100%' }"
                                :src="image.image"
                                :alt="post.captions"
                            />
                        </swiper-slide>
                    </swiper>
                </div>

                <div class="item pb-2 pt-3 pl-2">
                    <div class="top pb-3">
                        <!-- {{ post.caption }} -->
                        <b>{{ post.author.username ?? '' }}</b>
                    </div>
                    <div class="comment_list pt-2 pb-2">
                        <div class="comment_list-item" 
                            v-if="comments"
                            v-for="(item,index) in comments"
                            :key="index"
                        >
                            <div class="d-flex justify-content-between pr-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar mr-2">
                                        <img :src="(item.user && item.user.avatar) ? item.user.avatar : currentUser.avatar" :alt="item.user ? item.user.username : currentUser.username">
                                    </div>
                                    <router-link :to="{
                                            name: 'profile',
                                            params: {
                                                username: item.user ? item.user.username : currentUser.username,
                                            },}">
                                            <b>{{ item.user ? item.user.username : currentUser.username }}</b>
                                        </router-link>
                                </div>
                                <small class="text-secondary">{{ item.created_at }}</small>
                            </div>
                            <div class="message">{{ item.message }}</div>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="photos__icon d-flex align-items-center">
                            <ButtonLike
                                :isLike="checkLiked(post)"
                                :post="post"
                            />

                            <div
                                class="icon-comment"
                                @click="showPostDetail(post.id)"
                            >
                                <i class="fa-regular fa-comment mr-2"></i>
                                <span v-if="post.comments"
                                    >{{ post.comments.length }} comments</span
                                >
                            </div>
                        </div>
                        <div class="photos__caption">
                            {{ post.caption ?? post.caption }}
                        </div>
                        <!-- <a href class="show-comment text-secondary">more</a> -->
                        <div class="photos__created-at text-secondary">
                            {{ post.created_at }}
                        </div>

                        <div class="comment-form">
                            <!-- form comment- reply comment -->
                            <form @submit.prevent="postComment(post.id)" class="d-flex">
                                <input required v-model="message" class="form-control" type="text" placeholder="Add a comment" />
                                <button class="btn btn-light"><i class="fa-regular fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style src="./index.scss"></style>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Navigation } from "swiper/modules";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { getPostById } from "../../api/post";
import { fetchComments,saveComment,deleteComment } from "../../api/comment";
import ButtonLike from "../../components/Homepage/ButtonLike.vue";
import FormComment from "../../components/Homepage/FormComment.vue";
// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";

export default {
    components: {
        Swiper,
        SwiperSlide,
        ButtonLike,
        FormComment,
    },
    data() {
        return {
            message:"",
            comments:[],
            currentUser:window.userLogginIn,
        }
    },
    methods: {
        async loadComments(){
            const postId = useRoute().params.id;
            const commentsResponse = await fetchComments(postId);
            if(commentsResponse.data.success){
                    this.comments = commentsResponse.data.comments;
            }
        },
        async postComment(postId){
                const response  = await saveComment({user_id:window.userLogginIn.id,message:this.message,post_id:postId});

                if(response.data.success){
                    this.comments.push(response.data.comment);
                    this.message = '';
                }
        },
        async deleteComment(id){
            const response = await deleteComment(id);
            if(response.data.success){
                this.loadComments();
            }
        }
    },
    beforeMount(){
        this.loadComments();
    },
    setup() {
        const id = useRoute().params.id;
        const post = ref({});
        let isLiked = false;

        const getPostDetail = async (id) => {
            const resp = await getPostById(id);
            console.log(resp.data.data);
            if (resp.data.success) {
                post.value = resp.data.data;
            }
        };
        getPostDetail(id);

        // check liked
        const checkLiked = (post) => {
            let currenUserId = window.userLogginIn.id;
            let result = post.likers.filter(
                (val) => val.id == currenUserId
            );

            result.length ? (isLiked = true) : (isLiked = false);

            return result.length;
        };

        return {
            modules: [Navigation],
            post,
            checkLiked
        };
    },
};
</script>
