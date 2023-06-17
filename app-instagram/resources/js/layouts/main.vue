
<template>
    <div class="web-wrapper row">
      <!-- sidebar menu -->
      <Sidebar/>
      <!-- main content insta -->
      <main class="page-content col-9" style="position: absolute; right: 0; top: 0;">
        <router-view></router-view>
      </main>
    </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue';
import {ref} from 'vue';
import { getUser } from '../api/auth';

export default {
    components:{Sidebar},
    data(){
      return {}
    },
    setup(){
      // var userDataLogin = ref({});
      // var loading = ref(true);
      //   // fetch data user login
      //   getUser()
      //             .then(response=>{
      //               console.log(response);
      //               if(response.data.success = true){
      //                 userDataLogin.value = response.data.data;
      //               }
      //             })
      //             .catch(err=>{
      //               console.log('fetch error: '+err);
      //             })
      //             .then(()=>{
      //               loading.value = false;
      //             });
      // return {
      //   userDataLogin,
      //   loading
      // }
    }
}
</script>