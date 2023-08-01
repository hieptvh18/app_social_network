<template>
    <div class="create-story__container mt-4 mb-4">
        <div class="story-content" v-if="!isShowPreview">
            <div class="story-content__types">
                <div class="type-images" @click="handleClickStoryImages">
                    <div class="title">
                        <div class="title-icon">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                height="1em"
                                viewBox="0 0 576 512"
                            >
                                <path
                                    d="M160 80H512c8.8 0 16 7.2 16 16V320c0 8.8-7.2 16-16 16H490.8L388.1 178.9c-4.4-6.8-12-10.9-20.1-10.9s-15.7 4.1-20.1 10.9l-52.2 79.8-12.4-16.9c-4.5-6.2-11.7-9.8-19.4-9.8s-14.8 3.6-19.4 9.8L175.6 336H160c-8.8 0-16-7.2-16-16V96c0-8.8 7.2-16 16-16zM96 96V320c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160c-35.3 0-64 28.7-64 64zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V344c0 75.1 60.9 136 136 136H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-48.6 0-88-39.4-88-88V120zm208 24a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"
                                />
                            </svg>
                        </div>
                        <div class="title-text"><span>Photo story</span>
                            <input
                            type="file"
                            name="photos"
                            accept="image/*"
                            @change="previewImgPhotos"
                            ref="inputUploadPhotos"
                            style="display: none"
                        />
                        </div>
                    </div>
                </div>
                <div class="type-text">
                    <div class="title">
                        <div class="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M254 52.8C249.3 40.3 237.3 32 224 32s-25.3 8.3-30 20.8L57.8 416H32c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32h-1.8l18-48H303.8l18 48H320c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H390.2L254 52.8zM279.8 304H168.2L224 155.1 279.8 304z"/></svg>
                        </div>
                        <div class="title-text"><span>Story Text</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- preview story when choose photo story  -->
        <div class="preview-image" v-if="isShowPreview">
                <div class="preview-content">{{ contents }}</div>
                <img ref="image" alt="">
            </div>

        <div class="story-bottom mt-5" v-if="isShowPreview">
            <div class="story-bottom__title">Preview Story</div>
            <div class="story-bottom__content">
                <!-- content -->
                <textarea v-model="contents" class="form-control" id="" cols="30" rows="4" placeholder="Enter content"></textarea>

                <div class="mt-3">
                    <button class="btn btn-danger" @click="discardCreate">Discard</button>
                    <button class="btn btn-success">Share to story</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { ref } from 'vue';

export default{
    
    components:{},
    data(){
        return{
            image:'',
            contents:'',
            isShowPreview:false
        }
    },
    methods:{
        previewImgPhotos(e) {
            const selectedFile = e.target.files[0];
                this.image = selectedFile;

                let reader = new FileReader(); //instantiate a new file reader
                reader.addEventListener(
                    "load",
                    function () {
                        this.$refs.image.src = reader.result;
                    }.bind(this),
                    false
                );

            reader.readAsDataURL(this.image);

            this.isShowPreview = true;
        },
        handleClickStoryImages(){
            this.$refs.inputUploadPhotos.click();
        },
        discardCreate(){
            this.contents = '';
            this.isShowPreview = false;
            this.image = '';
        }
    }
}
</script>

<style scoped lang="scss">
.create-story__container {
    min-height: 100vh;

    .preview-image{
        width:30% ;
        height: 50vh;
        margin: 0 auto;
        position: relative;
        border: 2px solid #093ea0;
        border-radius: 15px;
        // overflow: hidden;

        img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }
        .preview-content{
            position: absolute;
            top: 0;
            left: 0;
            text-shadow: 1px 2px #ccc;
        }
    
    }

    .story-content {
        display: flex;
    }

    .story-content__types {
        display: flex;
        column-gap: 30px;
        width: 100%;
        height: 500px;
        justify-content: center;
        align-items: center;

        .type-images, .type-text{
            min-width: 30%;
            height: 50vh;
            border-radius: 15px;
            justify-content: center;
            text-align: center;
            display: flex;
            align-items: center;
            cursor: pointer;

            &:hover{
                opacity: 0.8;
            }
        }
        .type-images {
            background-color: #4158D0;
            background-image: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);

            .title {
            }
        }

        .type-text {
            background-color: #8EC5FC;
            background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);

            .title {
            }
        }
    }
}
</style>
