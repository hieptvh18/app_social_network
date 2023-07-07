<template>
    <div class="story-headers d-flex mb-3 pt-2">
                <!-- add new story -->
                <div class="story-headers__item text-center mr-4" @click="openModal">
                    <div
                        class="avatar add-new d-flex justify-content-center align-items-center"
                    >
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="story-name font-weight-bold">new</div>
                </div>
                <div class="story-headers__item mr-4" @click="showStories">
                    <div class="avatar active">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg"
                            alt=""
                        />
                    </div>
                    <div class="story-name">thu_thao2</div>
                </div>

                <div class="story-headers__item mr-4">
                    <div class="avatar active">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg"
                            alt=""
                        />
                    </div>
                    <div class="story-name">thu_thao2</div>
                </div>
            </div>
            <ModalDynamic v-show="isShowModal" @close="closeModal">
                <template v-slot:body>
                    Create new story
                </template>
            </ModalDynamic>
</template>

<script>
import ModalDynamic from "../ModalDynamic/index.vue";
export default{
    components:{ModalDynamic},
    data(){
        return{
            isShowModal:false
        }
    },

    methods:{
        openModal(){
            this.isShowModal = true;
        },
        closeModal(){
            this.isShowModal = false;
        },
        showStories(){

        }
    }

}

</script>
<style scoped>
.story-headers__item .avatar{
    width: 70px;
    height: 70px;
    border-radius: 50%;
    overflow: hidden;
    border:2px solid orange ;
    cursor: pointer;
}

.story-headers__item .avatar.add-new{
    border: 1px solid #ccc;
    cursor: pointer;
}

.story-headers__item img{
    object-fit: cover;
    width: 100%;
}
</style>
