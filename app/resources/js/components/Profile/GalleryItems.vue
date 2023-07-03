<template>
    <div class="content-gallery">
        <div class="gallery__header">
            <h5>Posts</h5>
            <button v-if="isMyProfile" class="btn btn-primary mb-3" @click="showModal">Create posts</button>
        </div>
        <div class="gallery__items d-flex" v-if="posts.length">
            <div
                class="gallery__item"
                v-for="(post, key) in posts"
                v-bind:key="key"
            >
                <img :src="post.images" alt="" />
                <div class="gallery__modal-backdrop" style="display: none">
                    <div class="modal-backdrop__box">
                        <span class="mr-2"
                            ><i class="far fa-heart"></i> 10</span
                        >
                        <span><i class="fa-regular fa-comment"></i> 20</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal create post -->
        <Modal
            v-show="isModalVisible"
            @close="closeModal"
        >
        <template v-slot:header>
            Create new posts
        </template>
            <template v-slot:body>
                <!-- caption -->
                <div class="create-post__captions mb-3">
                    <EmojiPicker picker-type="textarea" @select="onSelectEmoji" />

                    <!-- <textarea name="caption"  class="form-control" cols="30" rows="6" placeholder="Your caption..."></textarea> -->
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
                            <div v-for="(image, key) in images" :key="key" class="uploading-preview__item">
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
                <button class="btn btn-success">Create</button>
            </template>
        </Modal>
    </div>
</template>

<script>
import Modal from "../ModalDynamic/index.vue";
import EmojiPicker from "vue3-emoji-picker";
import "../../../../node_modules/vue3-emoji-picker/dist/style.css";
import { ref } from "vue";

export default {
    components:{Modal,EmojiPicker},
    data() {
        return {
            labelUpload: "Upload Photos",
            count: 1,
            images: [],
            isModalVisible: false,
        };
    },
    props: ["posts",'isMyProfile'],
    methods: {
        closeModal() {
            this.isModalVisible = false;
        },
        showModal() {
            console.log('ok');
            this.isModalVisible = true;
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
                ); //add event listener

                reader.readAsDataURL(this.images[i]);
            }
        },
        removePhoto(image, key) {
            console.log("remove photo" + key);
            console.log(this.images);
            // delete this.images[key];
            this.images.splice(key, 1);
            console.log(this.images);
        },
        uploadPhotos() {},
        triggerClickInptUpload() {
            this.$refs.inputUploadPhotos.click();
        },
    },
    setup() {
        const input = ref("");

        function onSelectEmoji(emoji) {
            input.value += emoji.i;
        }

        return {
        input,
        onSelectEmoji,
        };
  },
};
</script>

<style scoped src="./galleries.css">

</style>
