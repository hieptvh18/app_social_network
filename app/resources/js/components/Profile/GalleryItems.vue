<template>
    <div class="content-gallery">
        <div class="gallery__header">
            <h5>Posts</h5>
            <button
                v-if="isMyProfile"
                class="btn btn-primary mb-3"
                @click="showModal"
            >
                Create posts
            </button>
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
        <Modal v-if="isModalVisible" @close="closeModal">
            <template v-slot:header> Create new posts </template>
            <template v-slot:body>
                <!-- caption -->
                <div class="create-post__captions mb-3">
                    <EmojiPicker
                        picker-type="textarea"
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
    </div>
</template>

<script>
import Modal from "../ModalDynamic/index.vue";
import Loader from "../LoaderResult.vue";
import {
    getStorage,
    ref as refFirebase,
    uploadBytesResumable,
    uploadBytes,
    getDownloadURL,
} from "firebase/storage";
import EmojiPicker from "vue3-emoji-picker";
import "vue3-emoji-picker/css";
import { ref } from "vue";

export default {
    components: { Modal, EmojiPicker, Loader },
    data() {
        return {
            labelUpload: "Upload Photos",
            count: 1,
            images: [],
            isModalVisible: false,
            isDisableBtnCreate: true,
            uploadValue: null,
            isLoader: false,
            messages: {},
            imageData:[],// image url param call api save posts;
        };
    },
    props: ["posts", "isMyProfile"],
    methods: {
        closeModal() {
            this.isModalVisible = false;
        },
        showModal() {
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

            if (this.images.length) this.isDisableBtnCreate = false;
        },
        removePhoto(image, key) {
            console.log("remove photo" + key);
            console.log(this.images);
            // delete this.images[key];
            this.images.splice(key, 1);
            console.log(this.images);
        },
        onUpload() {
            const self = this;
            const files = this.images;
            console.log(files);
            if (!files.length) return;

            files.forEach((file) => {
                self.uploadingToCloud(file);
            });

            // call api save posts
            console.log("called api save posts");
        },
        triggerClickInptUpload() {
            this.$refs.inputUploadPhotos.click();
        },
        uploadingToCloud(file) {
            const storage = getStorage();
            const storageRef = refFirebase(storage, "posts/" + file.name);
            const uploadTask = uploadBytesResumable(storageRef, file);

            uploadTask.on(
                "state_changed",
                (snapshot) => {
                    // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                    const progress =
                        (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    this.uploadValue = progress;
                    this.isLoader = true;

                    switch (snapshot.state) {
                        case "paused":
                            console.log("Upload is paused");
                            break;
                        case "running":
                            console.log("Upload is running");
                            break;
                    }
                },
                (error) => {
                    this.isLoader = false;
                    console.log("error when upload firebase storage.");
                },
                () => {
                    // For instance, get the download URL: https://firebasestorage.googleapis.com/...
                    getDownloadURL(uploadTask.snapshot.ref).then(
                        (downloadURL) => {
                            let imageUrl = downloadURL;
                            this.images = [];
                            this.isLoader = false;
                            console.log("upload done: " + imageUrl);
                            this.imageData.push(imageUrl);

                            // save success-> re load component page
                            // window.location.reload();
                        }
                    );
                }
            );
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

<style scoped src="./galleries.css"></style>
