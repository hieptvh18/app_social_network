<template>
<span class="" data-toggle="modal" data-target="#modalCreatePost">
    Create Post
</span>

<!-- Modal -->
<div class="modal fade" id="modalCreatePost" tabindex="-1" role="dialog" aria-labelledby="modalCreatePost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreatePost">Create new post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{labelUpload }}
                <!-- view photos preview when uploading -->
                <div id="uploading">
                    <button class="btn btn-secondary" @click="triggerClickInptUpload">Choose Files...</button>
                    <input type="file" name="photos" multiple accept="image/*" @change="previewImgPhotos" ref="inputUploadPhotos" style="display: none;" />
                    <div v-for="(image, key) in images" :key="key">
                        <div class="uploading-preview__item">
                            <span class="removeImg"
                            title="Remove" @click="removePhoto(image,key)"><i class="fa-solid fa-xmark"></i></span>
                            <img class="preview-img" :ref="'image'" />
                            <!-- {{ image.name }} -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Next</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
// import Vue from 'vue';
import Index from './index.css';

export default {
    name: '',
    components: Index,
    // return data to DOM
    data() {
        return {
            labelUpload: "Upload Photos",
            count: 1,
            images: [],

        }
    },
    // method is binding method to DOM
    methods: {
        previewImgPhotos(e) {
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {
                this.images.push(selectedFiles[i]);
            }

            for (let i = 0; i < this.images.length; i++) {
                let reader = new FileReader(); //instantiate a new file reader
                reader.addEventListener('load', function () {
                    this.$refs.image[parseInt(i)].src = reader.result;
                }.bind(this), false); //add event listener

                reader.readAsDataURL(this.images[i]);
            }
        },
        removePhoto(image,key){
            console.log('remove photo'+key);
            console.log(this.images);
            // delete this.images[key];
            this.images.splice(key,1)
            console.log(this.images);
        },
        uploadPhotos(){
          
        },
        triggerClickInptUpload(){
            this.$refs.inputUploadPhotos.click();
        }
    },
    // component mounted 
    mounted() {
       
    },
    unmounted() {
        
    }
};
</script>
