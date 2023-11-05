<template>
    <!-- modal show post detail -->
    <Modal @close="closeModal" v-if="Object.keys(postData).length">
        <template v-slot:header> {{ postData.contents.captions ? postData.contents.captions : '' }} </template>
        <template v-slot:body>
            <div class="post-detail d-flex">
                <div class="slider-post-wrapper col-8">
                    <swiper
                        :pagination="{
                            type: 'fraction',
                        }"
                        :navigation="true"
                        :modules="modules"
                        class="mySwiper"
                    >
                        <swiper-slide v-for="(image,index) in postData.images" :key="index">
                            <img
                                :src="image.image"
                                style="width: 100%"
                                alt=""
                            />
                        </swiper-slide>
                    </swiper>
                </div>
                <div class="post-detail-content__right">
                    <div class="post-top profile-items mb-3 font-weight-bold">{{ postData.author.username }}</div>
                    <div class="post-content list-comments">
                        <div class="comment-item">
                            <div class="comment-item__profile d-flex mb-4" v-if="comments.length" v-for="(comment,index) in comments" :key="index">
                                <div class="profile-avatar mr-2">
                                    <img
                                        :src="(comment.user && comment.user.avatar) ? comment.user.avatar : currentUser.avatar"
                                        alt=""
                                    />
                                </div>
                                <div class="d-flex">
                                    <div class="">
                                        <router-link :to="{name:'profile',params:{username:comment.user ? comment.user.username : currentUser.username}}">
                                            <span class="font-weight-bold mr-2">{{ (comment.user ? comment.user.username : currentUser.username) }}</span>
                                        </router-link>
                                        <span>{{ comment.message }}</span>
                                        <p class="time-comment">{{ comment.created_at }}</p>
                                    </div>
                                    <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-light btn-sm rounded"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-right"
                                    >
                                        <button
                                            class="dropdown-item"
                                            type="button"
                                            @click="deleteComment(comment.id)"
                                        >
                                            <i class="mdi mdi-delete"></i>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post-bottom">
                        <!-- form comment- reply comment -->
                        <div class="created_at mb-2">Posted at {{ postData.created_at }}</div>
                        <form @submit.prevent="postComment" class="d-flex">
                            <input required v-model="message" class="form-control" type="text" placeholder="Add a comment" />
                            <button class="btn btn-light"><i class="fa-regular fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </Modal>
</template>

<script>
import Modal from "../ModalDynamic/index.vue";
import Loader from "../LoaderResult.vue";
import { ref } from "vue";
import { getPostById } from "../../api/post";
import { fetchComments, saveComment,deleteComment } from "../../api/comment";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Navigation } from "swiper/modules";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

export default {
    components: { Modal, Loader, Swiper, SwiperSlide },
    data() {
        return {
            isLoader: false,
            messages: {
                success: "",
                error: "",
            },
            message:'',
            comments:[],
            currentUser:window.userLogginIn
        };
    },
    props: ['isShowModalPost','postId'],
    methods: {
        closeModal() {
            this.$emit('closeModal')
        },
        async loadComments(){
            const commentsResponse = await fetchComments(this.postId);
            console.log(commentsResponse);
            if(commentsResponse.data.success){
                    this.comments = commentsResponse.data.comments;
            }
        },
        async postComment(){
                const response  = await saveComment({user_id:window.userLogginIn.id,message:this.message,post_id:this.postId});

                if(response.data.success){
                    this.comments.push(response.data.comment);
                    this.message = '';
                }
        },
        async deleteComment(id){
            const response = await deleteComment(id);
            console.log('res delete comment');
            console.log(response);

            if(response.data.success){
                this.loadComments();
            }
        }
    },
    setup(props) {
        const input = ref("");
        var postData = ref({});

        function onSelectEmoji(emoji) {
            input.value += emoji.i;
        }

        // fetch post data
        const fetchDataPostDetail = ()=>{
            const postId = props.postId;
            getPostById(postId)
                .then(res=>{
                    console.log(res);
                    if(res.data.success){
                        postData.value = res.data.data;
                        return;
                    }
                })
                .catch(er=>console.log(er))
        }
        fetchDataPostDetail();

        return {
            input,
            onSelectEmoji,
            modules: [Pagination, Navigation],
            postData:postData
        };
    },
    beforeMount(){
        this.loadComments();
    }
};
</script>

<style scoped>
.post-detail-content__right{
    width:100% ;
}
button.btn-op-comment__item{
    background: none;
    border: none;
    outline: none;
}
.time-comment{
    font-size: 13px;
    color: #444;
}
.post-content.list-comments{
    max-height: 100vh;
    min-height: 100vh;
    overflow-y: scroll;
}
</style>
<style scoped src="../Profile/galleries.css"></style>
