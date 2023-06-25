<template>
    <div class="content-gallery">
        <div class="gallery__header">Posts</div>
        <div
            class="gallery__items d-flex"
            v-if="posts.length"
        >
            <div
                class="gallery__item"
                v-for="(post, key) in posts"
                v-bind:key="key"
            >
                <img :src="post.images" alt="" />
                <div class="gallery__modal-backdrop" style="display: none;">
                    <div class="modal-backdrop__box">
                        <span class="mr-2"><i class="far fa-heart"></i> 10</span>
                        <span><i class="fa-regular fa-comment"></i> 20</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default
{
    data()
    {
        return { }
    },
    props:['posts'],
    method:{}
}
</script>

<style scoped>
.content-gallery .gallery__item:hover .gallery__modal-backdrop{
    display: flex !important;
}
.gallery__items{
    column-gap: 20px;
}

.gallery__item{
    width:29% ;
    max-height:250px ;
    position: relative;
    cursor: pointer;
}
.gallery__item img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery__modal-backdrop{
    width: 100%;
    height: 100%;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    color: #fff;
    background: #3333336b;

    display: flex;
    align-items: center;
    justify-content: center;
}
.modal-backdrop__box{

}
</style>
