
<template>
  <div class="d-flex content" v-if="!loading">
    <section id="main" class="content__left justify-content-end col-12 col-sm-12 col-md-9">
      <!--  Stories section  -->
      <!-- <Stories/> -->
      <StoryIndex/>

      <!-- List post component -->
      <ListPost :postListing="postListing" />
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
      <!-- list suggest following -->
      <RecommendFollow/>
    </section>
  </div>
  <ModalLoading v-if="loading" />
</template>

<style src="./index.scss"></style>
<script>
    import {logout,getUser} from '../../api/auth';
    import {getListPostByFollowing} from "../../api/post";
    import {ref,computed} from 'vue';
    import ModalLoading from '../../components/ModalLoading.vue';
    import ListPost from '../../components/Homepage/ListPost.vue';
    import Stories from "../../components/Homepage/Stories.vue";
    import RecommendFollow from "../../components/Homepage/RecommendFollow.vue";
    import StoryIndex from "../../components/Homepage/Story/Index.vue";

    export default {
      components:{Stories,StoryIndex, ModalLoading,ListPost,RecommendFollow},
      props:['userDataLogin'],
      setup(props){
        const loading = ref(true);
        const postListing = ref([]);
        const userLoginData = ref(null);

        // fetch data user login
        getUser()
                  .then(response=>{
                    if(response.data.statusText = 'OK'){
                      userLoginData.value = response.data.data;
                    }
                  })
                  .catch(err=>{
                    console.log('fetch error: '+err);
                  });

        // fetch list post
        getListPostByFollowing()
        .then(response=>{
          console.log(response.data);
          if(response.data.success){
            postListing.value = response.data.data;
          }
          loading.value = false;
        })
        .catch(err=>{
          loading.value = true;
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
