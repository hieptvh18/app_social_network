<template>
    <aside class="sidebar-menu col-3 bg-info">
        <div class="logo">
          <a href="">Instagram</a>
        </div>
        <ul class="nav-menu">
          <li>
                <router-link :to="{name:'homepage'}">
                    <i class="fas fa-home-alt"></i>Home
                </router-link>
        </li>
          <li><i class="fas fa-search"></i><ModalSearchUser/></li>
          <li><i class="fas fa-search"></i>
            <button
            type="button"
            class="btn"
            @click="showModal"
            >
              Open Modal!
            </button>

            <ModalDynamic
              v-show="isModalVisible"
              @close="closeModal"
            />
          </li>
          <li><a href="">Explore</a></li>
          <li><a href=""><i class="fab fa-facebook-messenger"></i>Message</a></li>
          <li><a href=""><i class="far fa-heart"></i>Notification</a></li>

          <!-- create post -->
          <li><ModalCreatePost/></li>
          <li>
            <router-link :to="{name:'profile',params:{username:'tvhh'}}">
                    <i class="fas fa-home-alt"></i>Profile
                </router-link>
        </li>
        </ul>
      </aside>
</template>

<script>
import ModalCreatePost from './ModalCreatePost/index.vue';
import ModalSearchUser from './ModalSearchUser/index.vue';
import ModalDynamic from './ModalDynamic/index.vue';

export default {
  components:{ModalCreatePost,ModalSearchUser,ModalDynamic}
  ,
  data() {
      return {
        isModalVisible: false,
      };
    },
    methods: {
      showModal() {
        this.isModalVisible = true;
      },
      closeModal() {
        this.isModalVisible = false;
      }
    }
}
</script>