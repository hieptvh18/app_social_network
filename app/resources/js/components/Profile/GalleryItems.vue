<template>
    <div class="content-gallery">
        <div class="tab-button">
            <button @click="tabActive(true)" :class="{'active':tabPost}">Posts</button>
            <button v-if="isMyProfile" @click="tabActive(false)" :class="{'active':!tabPost}">Stories</button>
        </div>
        <div class="tab-posts" v-if="tabPost">
            <div class="gallery__header mt-3">
                <button
                    v-if="isMyProfile"
                    class="btn btn-primary mb-3"
                    @click="showModal"
                >
                    Create posts
                </button>
            </div>
            <!-- list post -->
            <div class="gallery__items d-flex" v-if="posts.length">
                <div
                    class="gallery__item"
                    v-for="(post, key) in posts"
                    v-bind:key="key"
                >
                    <div v-if="post.images.length" @click="showPostDetail(post.id)">
                        <img :src="post.images[0].image" alt="" />
                        <div class="gallery__modal-backdrop" style="display: none">
                            <div class="modal-backdrop__box">
                            <span class="mr-2"
                            ><i class="far fa-heart"></i> {{ post.likes_count }}</span
                            >
                                <span><i class="fa-regular fa-comment"></i> {{ post.comments_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal create post -->
            <Modal v-if="isModalVisible" @close="closeModal">
                <template v-slot:header> Create new posts </template>
                <template v-slot:body>
                    <!-- caption -->
                    <div class="create-post__captions mb-3">
                        <EmojiPicker
                            picker-type="textarea"
                            @update:text="changeCaption"
                            @placeholder="'hihi'"
                            @select="onSelectEmoji"
                        />
                    </div>
                    {{ labelUpload }}
                    <div id="uploading">
                        <button
                            class="btn btn-secondary"
                            @click="triggerClickInptUpload"
                        >
                            Choose Files...
                        </button>
                        <input
                            type="file"
                            name="photos"
                            multiple
                            accept="image/*"
                            @change="previewImgPhotos"
                            ref="inputUploadPhotos"
                            style="display: none"
                        />
                        <div class="create-posts__preview-items">
                            <div
                                v-for="(image, key) in images"
                                :key="key"
                                class="uploading-preview__item"
                            >
                            <span
                                class="removeImg"
                                title="Remove"
                                @click="removePhoto(image, key)"
                            ><i class="fa-solid fa-xmark"></i
                            ></span>
                                <img class="preview-img" :ref="'image'" />
                            </div>
                        </div>
                    </div>
                </template>
                <template v-slot:footer>
                    <Loader v-if="isLoader" />
                    <div class="message">
                        <div class="" :class="{'text-danger':messages.error,'text-success':messages.success}" v-if="messages.success || messages.error">{{ messages.success || messages.error }}</div>
                    </div>
                    <button
                        :disabled="isDisableBtnCreate"
                        class="btn btn-success"
                        style="width: 100%"
                        @click="onUpload"
                    >
                        Create
                    </button>
                </template>
            </Modal>

            <!-- modal show post detail -->
            <ModalPostDetail v-if="postId && isShowModalPost" @closeModal="closeModal" :postId="postId" :isShowModalPost="isShowModalPost"/>
        </div>
        <div class="tab-stories" v-if="!tabPost">
            <div class="stories-title mt-3 mb-3 text-secondary">
                Only you can see your archived stories unless you choose to share them.
            </div>
            <div class="stories-items">
                <div class="stories-items__item" v-if="stories.length" v-for="(story,index) in stories">
                    <div class="story-publish">
                        24 Jul
                    </div>
                    <img :src="story.photo" :alt="story.content" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Modal from "../ModalDynamic/index.vue";
import Loader from "../LoaderResult.vue";
import ModalPostDetail from "../Homepage/ModalPostDetail.vue";
import {
    getStorage,
    ref as refFirebase,
    uploadBytes,
    getDownloadURL,
} from "firebase/storage";
import EmojiPicker from "vue3-emoji-picker";
import "vue3-emoji-picker/css";
import { ref } from "vue";
import {savePostData} from "../../api/post";
import {fetchMyStories} from "@/api/story";
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

export default {
    components: { Modal,ModalPostDetail, EmojiPicker, Loader,Swiper,SwiperSlide },
    data() {
        return {
            labelUpload: "Upload Photos",
            count: 1,
            images: [],
            isModalVisible: false,
            isShowModalPost:false,
            isDisableBtnCreate: true,
            uploadValue: null,
            isLoader: false,
            messages: {
                success:"",
                error:""
            },
            imageData: [], // image url param call api save posts;
            caption:'',
            postId:'',
            postDetailKey:0,
            tabPost:ref(true)
        };
    },
    props: ["posts", "isMyProfile"],
    methods: {
        closeModal() {
            this.isModalVisible = false;
            this.isShowModalPost = false;
        },

        showModal() {
            this.isModalVisible = true;
        },

        showPostDetail(postId){
            this.isShowModalPost = true;
            this.postId = postId;
        },

        previewImgPhotos(e) {
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {
                this.images.push(selectedFiles[i]);
            }

            for (let i = 0; i < this.images.length; i++) {
                let reader = new FileReader(); //instantiate a new file reader
                reader.addEventListener(
                    "load",
                    function () {
                        this.$refs.image[parseInt(i)].src = reader.result;
                    }.bind(this),
                    false
                );

                reader.readAsDataURL(this.images[i]);
            }

            if (this.images.length) this.isDisableBtnCreate = false;
        },

        removePhoto(image, key) {
            console.log("remove photo" + key);
            console.log(this.images);
            // delete this.images[key];
            this.images.splice(key, 1);
            console.log(this.images);
        },

        async onUpload() {
            const self = this;
            const files = this.images;
            this.isLoader = true;

            if(!files.length && !this.caption) {
                this.messages.error = "Caption or image is required!";
                return;
            }
            this.messages.error = "";

            if (!files.length && this.caption){
                this.uploadPostNotImage();
                return;
            }

            for (let file of files) {
                await self.uploadingToCloud(file);
            }

            // call api save posts
            var arrayToString = JSON.stringify(Object.assign({}, this.imageData));  // convert array to string
            var imageJsons = JSON.parse(arrayToString);
            const dataPost = {
                captions:this.caption,
                images:imageJsons
            };

            this.savePost(dataPost);
        },

        triggerClickInptUpload() {
            this.$refs.inputUploadPhotos.click();
        },

        uploadPostNotImage(){
            const dataPost = {
                captions : this.caption
            }
            this.savePost(dataPost);
        },

        uploadingToCloud(file) {
            const storage = getStorage();
            const storageRef = refFirebase(storage, "posts/" + file.name);
            const uploadTask2 = uploadBytes(storageRef, file);

            return new Promise((resolve, reject) => {
                uploadTask2.then((snapshot) => {
                    getDownloadURL(snapshot.ref).then((downloadURL) => {
                        let imageUrl = downloadURL;
                        this.images = [];
                        this.isLoader = false;
                        this.imageData.push(imageUrl);

                        // save success-> re load component page
                        resolve("upload success");
                    });
                });
            });
        },
        changeCaption(e){
            this.caption = e;
        },
        savePost(data){
            savePostData(data)
                .then(res=>{
                    console.log(res);
                    this.isLoader = false;
                    if(res.data.success){
                        this.messages.success = "Create successful!";
                        this.messages.error = "";
                        // reload component profile
                        this.reloadComponent();
                        return;
                    }
                    this.messages.error = "Create error! try again!";
                    this.messages.success = "";

                })
                .catch(er=>{
                    this.isLoader = false;
                    this.messages.error = "Create error! try again!";
                    this.messages.success = "";
                })
        },
        reloadComponent(){
            this.$emit('reloadComponent');
        },
    },
    setup() {
        const input = ref("");
        const stories = ref([]);
        const tabPost = ref(true);

        const myStories = async ()=>{
            const response = await fetchMyStories();
            if(response.data.success){
                stories.value = response.data.stories;
            }
        }

        // tab active
        const tabActive = (value) => {
            tabPost.value = value;
            if(!tabPost.value){
                myStories()
            };
        }


        function onSelectEmoji(emoji) {
            input.value += emoji.i;
        }

        return {
            input,
            onSelectEmoji,
            modules: [Pagination, Navigation],
            stories,
            tabActive,
            tabPost
        };
    },

    beforeMount(){
        console.log(this.posts);
    }
};
</script>

<style scoped src="./galleries.css"></style>
