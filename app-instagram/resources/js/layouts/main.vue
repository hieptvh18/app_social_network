
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
export default {
    components:{Sidebar}
}
</script>