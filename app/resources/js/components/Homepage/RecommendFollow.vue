<template>
    <div class="content__right-following mb-3">
        <div class="following-title row">
          <div class="col-6">Suggestions for you</div>
          <a href="" class="col-6">See All</a>
        </div>
        <ul class="following-list" v-if="recommendList.length" style="margin: 0; padding:0 ;">
            <li v-for="(val,index) in recommendList" :key="index">
                <router-link :to="{name:'profile',params:{username:val.username}}" class="mr-2">{{ val.name }}</router-link>
                <span class="following-btn" @click="follow">Follow +</span>
            </li>
        </ul>
      </div>
</template>

<script setup>
    import {ref} from 'vue';
    import { getRecomendFollowing } from '../../api/user'; 

    const recommendList = ref([]);

    const getListRecommend = async ()=>{
        const response = await getRecomendFollowing()
        if(response.data.success){
            recommendList.value = response.data.data;
        }
    }
    getListRecommend();

    const follow = ()=>{
        console.log('follow');
    }

</script>

<style scoped>
.following-btn{
    cursor: pointer;
}
</style>