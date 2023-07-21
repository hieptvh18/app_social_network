<template>
    <div class="content__right-following mb-3">
        <div class="following-title d-flex justify-content-between mt-5 mb-4">
          <div class="suggest">Suggestions for you</div>
          <a href="" class="see-all">See All</a>
        </div>
        <ul class="following-list" v-if="recommendList.length" style="margin: 0; padding:0 ;">
            <li v-for="(val,index) in recommendList" :key="index">
                <router-link :to="{name:'profile',params:{username:val.username}}" class="mr-2">
                    <span class="avatar-recommend-user mr-3"><img :src="val.avatar" alt="img"></span>
                    <span>{{ val.name }}</span>
                </router-link>
                <span class="following-btn" @click="follow($event,val.id)">Follow +</span>
            </li>
        </ul>
      </div>
</template>

<script setup>
    import {ref} from 'vue';
    import { getRecomendFollowing,followUser } from '../../api/user'; 

    const recommendList = ref([]);

    const getListRecommend = async ()=>{
        const response = await getRecomendFollowing();
        if(response.data.success){
            recommendList.value = response.data.data;
        }
    }
    getListRecommend();

    // follow action
    const follow = (e,following_id) => {
        let dataFollow = {
            user_id: window.userLogginIn.id,
            following_id: following_id,
        };
        followUser(dataFollow)
            .then((res) => {
                if (res.data.success) {
                    e.target.style.display = 'none';
                }
            })
            .catch((err) => {
                console.log(err);
            });
    };

</script>

<style scoped>
.following-btn{
    cursor: pointer;
}
.following-btn:hover{
    color: #ccc;
}
.following-list li{
    display: flex;
    justify-content: space-between;
    line-height: 30px;
}
.following-list li a{
    display: flex;
    align-items: center;
}
.avatar-recommend-user{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    overflow: hidden;
}
.avatar-recommend-user img{
    object-fit: cover;
    width: 100%;
    height: 100%;
}
</style>