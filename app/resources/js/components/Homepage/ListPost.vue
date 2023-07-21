<template>
    <div class="list-post">
        <div v-for="(post, key) in postListing" class="list-post__items">
          <div class="item mb-2" v-bind:key="key">
            <div class="item__top">
              <div
                class="item-profile-box d-flex justify-content-between p-2 align-items-center"
              >
                <div class="item-profile d-flex align-items-center">
                  <div class="profile-avatar mr-2">
                    <router-link :to="{name:'profile',params:{username:post.author.username}}">
                        <img
                        :style="{width:'100%'}"
                        :src="post.author.avatar"
                        />
                    </router-link>
                  </div>
                  <div class="profile-name">
                    <a href="./profile-following.html"><router-link :to="{name:'profile',params:{username:post.author.username}}">{{ post.author.username }}</router-link></a>
                  </div>
                </div>
                <div class="bars">...</div>
              </div>
            </div>
            <div class="item__content">
              <div class="content-photos">
                <div class="photos__gallery">
<!--                    using swiper slider-->
                    <swiper
                        :navigation="true"
                        :modules="modules"
                        class="mySwiper"
                    >
                        <swiper-slide v-for="(image, keyImg) in post.images">
                            <img
                                :style="{width:'100%'}"
                                :src="image.image"
                                :alt="post.captions"
                            />
                        </swiper-slide>
                    </swiper>
                </div>
                <div class="photos__content p-2">
                  <div class="photos__icon d-flex">
                    <div class="icon__likes mr-3" @click="clickIconLike(post)">
                      <i :class="{'active':checkLiked(post) || isLiked ? true : false}" class="far fa-heart"></i>
                      <span v-if="post.likes.length">{{ post.likes.length }} likes</span>
                    </div>
                    <div class="icon-comment">
                      <i class="fa-regular fa-comment"></i>
                      <span v-if="post.comments">{{ post.comments }} comments</span>
                    </div>
                  </div>
                  <div class="photos__caption">
                    <span class="font-weight-bold"
                      >{{ post.author.username }}</span
                    >
                    {{ post.captions ?? post.captions }}
                  </div>
                  <!-- <a href class="show-comment text-secondary">more</a> -->
                  <div class="photos__created-at text-secondary">
                    {{ post.created_at }}
                  </div>

                  <FormComment :postId="post.id"/>
                </div>
              </div>
            </div>
            <div class="item__footer"></div>
          </div>

        </div>
      </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, Navigation } from 'swiper/modules';
import { likePost } from '../../api/post';
import {ref} from 'vue';
import FormComment from '../FormComment.vue';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
    export default{
        components: {
            Swiper,
            SwiperSlide,
            FormComment
        },
        methods:{
          
        },
        props:['postListing'],
        setup(props) {
            console.log(props.postListing);
            let isLiked = false;
            const listMyComment = [];

            // check liked
            const checkLiked = (post)=>{
              let currenUserId = window.userLogginIn.id;
              let result = post.likes.filter(val=>val.user_id == currenUserId);
              
              result.length ? isLiked = true : isLiked = false;
              
              return result.length;
            }

            const clickIconLike = async (post)=>{
              isLiked = !isLiked;

              const response = await likePost({
                'userId':window.userLogginIn.id,
                'postId':post.id
              });

              console.log(response);

              if(response.data.success) {
                console.log('liked');
              }
            }

            // handle comment action
            const commentPost = ()=>{

            }

            return {
                modules: [ Navigation],
                clickIconLike,
                checkLiked,
                isLiked,
                listMyComment
            };
        },
    }

</script>
<style scoped>
.icon__likes i.active{
  color:red;
}
.photos__icon div{
    cursor: pointer;
}
.photos__icon i{
    font-size: 25px;
}
.icon__likes .liked{
    color: red;
}
.list-post .item{
    border-radius: 5px;
    background: #e7e7e7;
}
.photos__gallery{
    height: 578px;
}
.photos__gallery img{
    height: 100%;
    object-fit: cover;
}

.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;

    /* Center slide text vertically */
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.swiper-button-prev{
    background: #e7e7e7;
}
</style>
