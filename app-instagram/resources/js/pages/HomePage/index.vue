
<template>
  <div class="d-flex content" v-if="!loading">
    <section id="main" class="content__left justify-content-end col-9">
      <div class="story-header d-flex mb-3">
        <div class="story-header__item mr-2">
          <div class="avatar active">
              <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg" alt="">
          </div>
          <div class="friend-name">thu_thao2</div>
        </div>

        <div class="story-header__item">
          <div class="avatar active">
              <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg" alt="">
          </div>
          <div class="friend-name">thu_thao2</div>
        </div>

        
      </div>
      <div class="list-post">
        <div v-for="(post, key) in postListing" class="list-post__items">
        
          <div class="item mb-2 bg-success" v-bind:key="key">
            <div class="item__top">
              <div
                class="item-profile-box d-flex justify-content-between p-2 align-items-center"
              >
                <div class="item-profile d-flex align-items-center">
                  <div class="profile-avatar mr-2">
                    <img
                    :style="{width:'100%'}"
                    :src="post.avatar"
                    />
                  </div>
                  <div class="profile-name">
                    <a href="./profile-following.html">{{ post.username }}</a>
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
                    :src="post.image"
                    :alt="post.caption"
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
                      >{{ post.username }}</span
                    >
                    {{ post.caption ?? post.caption }}
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
    </section>
    <!-- my profile user login -->
    <section id="content__right" class="content__right col-3 p-2">
      <div class="content__right-profile row mb-3">
        <div class="profile-left col-9 d-flex align-items-center">
          <router-link :to="{name:'profile',params:{username: userLoginData.username}}">
            <div class="avatar mr-2">
              <img :src="userLoginData.avatar" :alt="userLoginData.username">
          </div>
          </router-link>
          <div class="switch">
            <div class="username">{{userLoginData.username}}</div>
            <span class="fullname text-secondary"
              >{{ userLoginData.fullname }}</span
            >
          </div>
        </div>
        <button data-toggle="modal" data-target="#exampleModalCenter" class="profile-switch col-3 btn"> Logout </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Logout Confirm?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button @click="handleLogout" type="button" class="btn btn-primary">Confirm</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="content__right-following mb-3">
        <div class="following-title row">
          <div class="col-6">Suggestions for you</div>
          <a href="" class="col-6">See All</a>
        </div>
        <ul class="following-list">
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
        </ul>
      </div>
      <div class="copy-right text-secondary">© 2023 INSTAGRAM FROM META</div>
    </section>
  </div>
  <ModalLoading v-if="loading" />
</template>

<style scoped src="./index.css"></style>
<script>
    import {logout} from '../../api/auth';
    import {ref,computed} from 'vue';
    import { getUser } from '../../api/auth';
    import ModalLoading from '../../components/ModalLoading.vue';

    export default {
      components:{ModalLoading},
      props:['userDataLogin'],
      setup(props){
        const loading = ref(true);
        const postListing = ref([
                  {
                    username:'marchland_official',
                    avatar:'https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg',
                    caption:'So beautiful...',
                    image:'https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8&w=1000&q=80',
                    likes:'100',
                    comments:'30000',
                    created_at:'2 day agos'
                  },
                  {
                    username:'Leo Messi',
                    avatar:'https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg',
                    caption:'Welcome America...',
                    image:'https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8&w=1000&q=80',
                    likes:'100',
                    comments:'30000',
                    created_at:'2 day agos'
                  }
                ]);
        const userLoginData = ref(null);

        // fetch data user login
        getUser()
                  .then(response=>{
                    console.log(response);
                    if(response.data.statusText = 'OK'){
                      userLoginData.value = response.data.data;
                    }
                  })
                  .catch(err=>{
                    console.log('fetch error: '+err);
                  })
                  .then(()=>{
                    loading.value = false;
                  });

        return {
          loading,
          userLoginData,
          postListing
        }
      },
      methods:{
        handleLogout(e){
            logout()
            .then(response=>{
              if(response.data.status == 'ok'){
                window.localStorage.removeItem('tokenLogin');
                window.location.href = 'accounts/login';
              }
            }).catch(error=>{
              console.log(error);
            })
        }
      },
      computed:{

      }
      
    }
</script>