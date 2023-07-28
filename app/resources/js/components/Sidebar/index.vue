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
          <router-link :to="{name:'messagepage'}">
            <li class="d-flex justify-content-between">
              <div class=""><i class="fab fa-facebook-messenger"></i>Message</div>
              <div class="count-noti messages">2</div>
            </li>
          </router-link>

          <router-link :to="{name:'notificationpage'}">
            <li class="d-flex justify-content-between ">
              <div class=""><i class="far fa-heart"></i>Notification</div>
              <div class="count-noti notifications" v-if="countNoti">{{ countNoti }}</div>
            </li>
          </router-link>

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
import {fetchNotificationsUnread} from '../../api/notification';
import { ref } from 'vue';

export default {
  components:{ModalSearchUser,ModalDynamic},
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
    setup(){
        var countNoti = ref(0);

        const fetchCountNoti = async ()=>{
            const res = await fetchNotificationsUnread();
            if(res.data.success){
                countNoti.value = res.data.count;
            }
        }
        fetchCountNoti();

        return {
            countNoti
        }
    }
}
</script>
<style scoped>
.count-noti{
  width: 20px;
  height: 20px;
  border-radius: 4px;
  color: #fff;
  background: green;
  font-size: 14px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
