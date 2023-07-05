<template>
    <div class="list-post">
        <div v-for="(post, key) in postListing" class="list-post__items">
        
          <div class="item mb-2 bg-success" v-bind:key="key">
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
                  <img
                      :style="{width:'100%'}"
                    :src="post.images[0].image"
                    :alt="post.captions"
                  />
                </div>
                <div class="photos__content p-2">
                  <div class="photos__icon d-flex">
                    <div class="icon__likes mr-3">
                      <i class="far fa-heart"></i>
                      <span v-if="post.likes">{{ post.likes }} likes</span>
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
                  <a href class="show-comment text-secondary">more</a>
                  <div class="photos__created-at text-secondary">
                    {{ post.created_at }}
                  </div>

                  <div class="photos__comment mt-3">
                    <form action="">
                      <div class="form-group d-flex">
                        <input
                          type="text"
                          placeholder="Add a comment..."
                          name="comment"
                          class="form-control"
                          id=""
                        />
                        <button class="btn btn-light">Post</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="item__footer"></div>
          </div>

        </div>
      </div>
</template>

<style scoped>
.list-post .item{
    border-radius: 5px;
}
.photos__gallery{
    height: 578px;
}
.photos__gallery img{
    height: 100%;
    object-fit: cover;
}
</style>
<script>
    export default{
        data(){

        },
        props:['postListing']
    }
</script>