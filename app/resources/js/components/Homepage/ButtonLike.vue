<template>
    <div class="button">
        <input type="checkbox" v-bind:id="'liked'+post.id">
        <label v-bind:for="'liked'+post.id"><span></span></label>
    </div>

</template>

<script>
    export default{
        name:'btn-like',
        props:['post'],
        data(){
            return{}
        },
        methods:{
            clickLike(e){
                e.target.classList.toggle('press');
            }
        }
    }
</script>

<style scoped>
</style>
