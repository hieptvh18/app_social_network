<template>
    <aside class="sidebar-menu col-3 bg-light">
        <div class="logo">
          <router-link :to="{name:'homepage'}">Instagram</router-link>
        </div>
        <ul class="nav-menu">
          <li>
                <router-link :to="{name:'homepage'}">
                    <i class="fas fa-home-alt"></i>Home
                </router-link>
        </li>
          <li><i class="fas fa-search"></i><ModalSearchUser/></li>
          <li><a href="">Explore</a></li>
          <li>
            <router-link :to="{name:'messagepage'}">
              <i class="fab fa-facebook-messenger"></i>Message
            </router-link>
          </li>
          <li>
            <router-link :to="{name:'notificationpage'}">
              <i class="far fa-heart"></i>Notification
            </router-link>
          </li>

          <li>
            <router-link :to="{name:'profile',params:{username:userData.username}}">
                    <i class="fas fa-home-alt"></i>Profile
                </router-link>
        </li>
        </ul>
      </aside>
</template>
<style scoped src="./index.css">
</style>
<script>
import ModalSearchUser from '../ModalSearchUser/index.vue';
import ModalDynamic from '../ModalDynamic/index.vue';

export default {
  components:{ModalSearchUser,ModalDynamic},
  // props: ['userData'],
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
    },
    props:{
      userData: Object
    },
    setup(props){
      // const userData = props.userData;

      // return {
      //   userData
      // }
    },
}
</script>