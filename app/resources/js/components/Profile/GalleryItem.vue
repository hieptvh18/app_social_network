<template>
    <!-- modal show post detail -->
    <Modal @close="closeModal" v-if="Object.keys(postData).length">
        <template v-slot:header> {{ postData.contents.captions ? postData.contents.captions : '' }} </template>
        <template v-slot:body>
            <div class="post-detail d-flex">
                <div class="slider-post-wrapper">
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
                            <div class="comment-item__profile d-flex mb-4">
                                <div class="profile-avatar mr-2">
                                    <img
                                        src="https://phunugioi.com/wp-content/uploads/2020/03/anh-hot-girl-hoc-sinh-viet-nam.jpg"
                                        alt=""
                                    />
                                </div>
                                <div class="">
                                    <span class="font-weight-bold mr-2"
                                        >thoannt</span
                                    >
                                    <span>He he you very beautiful!🤣🤣</span>
                                </div>
                            </div>
                            <div class="comment-item__profile d-flex mb-4">
                                <div class="profile-avatar mr-2">
                                    <img
                                        src="https://phunugioi.com/wp-content/uploads/2020/03/anh-hot-girl-hoc-sinh-viet-nam.jpg"
                                        alt=""
                                    />
                                </div>
                                <div class="">
                                    <span class="font-weight-bold mr-2"
                                        >thoannt</span
                                    >
                                    <span>He he you very beautiful!🤣🤣</span>
                                </div>
                            </div>

                            <div class="comment-item__profile d-flex mb-4">
                                <div class="profile-avatar mr-2">
                                    <img
                                        src="https://phunugioi.com/wp-content/uploads/2020/03/anh-hot-girl-hoc-sinh-viet-nam.jpg"
                                        alt=""
                                    />
                                </div>
                                <div class="">
                                    <span class="font-weight-bold mr-2"
                                        >thoannt</span
                                    >
                                    <span>He he you very beautiful!🤣🤣</span>
                                </div>
                            </div>

                            <div class="comment-item__profile d-flex mb-4">
                                <div class="profile-avatar mr-2">
                                    <img
                                        src="https://phunugioi.com/wp-content/uploads/2020/03/anh-hot-girl-hoc-sinh-viet-nam.jpg"
                                        alt=""
                                    />
                                </div>
                                <div class="">
                                    <span class="font-weight-bold mr-2"
                                        >thoannt</span
                                    >
                                    <span>He he you very beautiful!🤣🤣</span>
                                </div>
                            </div>

                            <div class="comment-item__profile d-flex mb-4">
                                <div class="profile-avatar mr-2">
                                    <img
                                        src="https://phunugioi.com/wp-content/uploads/2020/03/anh-hot-girl-hoc-sinh-viet-nam.jpg"
                                        alt=""
                                    />
                                </div>
                                <div class="">
                                    <span class="font-weight-bold mr-2"
                                        >thoannt</span
                                    >
                                    <span>He he you very beautiful!🤣🤣</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post-bottom">
                        <!-- form comment- reply comment -->
                        <div class="created_at">{{ postData.contents.created_at }}</div>
                        <form>
                            <input type="text" placeholder="Add a comment" />
                            <button>Post</button>
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
        };
    },
    props: ['isShowModalPost','postId'],
    methods: {
        closeModal() {
            this.$emit('closeModal')
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
       
    }
};
</script>

<style scoped src="./galleries.css"></style>
