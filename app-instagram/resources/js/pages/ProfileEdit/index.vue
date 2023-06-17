
<template>
 <div class="content-form-edit-profile p-4" v-if="!loading">
    <form @submit.prevent="submitUpdate">
        <div class="avatar">
            <div class="box-avatar">
                <img src="https://aem.dropbox.com/cms/content/dam/dropbox/warp/en-us/developers/tech-research-lab.svg" alt="">
            </div>
        </div>
        <div class="username">
            <span>tranvhh</span>
            <a href="">Change profile photo</a>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Name</label>
            <div class="ml-3">
                <input type="text" name="name" class="form-control-sm" :value="formData.name" disabled>
                <br>
                <small>You are using the same name on Instagram and Facebook. Go to Facebook to change your name. Change Name
                </small>
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Username</label>
            <div class="ml-3">
                <input type="text" readonly name="username" class="form-control-sm" v-model="formData.username">
                <br>
                <small>In most cases, you'll be able to change your username back to tranvhh for another 14 days.
                </small>
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Bio</label>
            <div class="ml-3">
                <textarea name="bio" id="" cols="30" rows="4" class="form-control" v-model="formData.bio"></textarea>
                <br>
                <small>In most cases, you'll be able to change your username back to tranvhh for another 14 days.
                </small>
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Email</label>
            <div class="ml-3">
                <input type="email" name="email" v-model="formData.email" class="form-control-sm" >        
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Phone</label>
            <div class="ml-3">
                <input type="text" name="phone" class="form-control-sm" v-model="formData.phone">        
            </div>
        </div>

        <button type="submit" class="btn" :class="{'btn-primary': !loader,'btn-success':loader}">{{ loader ? 'Submit success!' : 'Submit' }}</button>
        <!-- <router-link :to="{name:'profile',params:{username:userLoggin.username}}">Back to profile</router-link> -->
    </form>
    <div class="text-secondary">© 2023 Instagram from Meta</div>
</div>
<ModalLoading v-if="loading" />
</template>

<style scoped src="./index.css"></style>
<script>
    import Index from './index.css';
    import { getUser } from '../../api/auth';
    import { ref } from 'vue';
    import ModalLoading from '../../components/ModalLoading.vue';
    import LoaderResult from '../../components/LoaderResult.vue';
    import {updateUser} from '../../api/user';

    export default {
      components:{Index,ModalLoading},
      data(){
        return {
            formData:{
                username:'',
                name:'',
                email:'',
                password:'',
                phone:'',
            },
            loading:ref(true),
            loader:ref(false)
        }
      },
      methods:{
        async sleep(ms) {
            return await new Promise(resolve => setTimeout(resolve, ms));
        },
        submitUpdate (e){
            this.loader = true;
            let formData = this.formData;
            updateUser(formData)
            .then(response=>{
                if(response.data.success){
                    this.sleep(3000);
                    this.loader = false;
                    console.log('sleep after');
                }
            }).
            catch(err=>console.log(err))
             .then((res)=>console.log(res))
        },
        getUserData(){
             getUser()
            .then(response=>{
                if(response.data.success == true){
                    let user = response.data.data;
                    this.formData.username = user.username;
                    this.formData.name = user.name;
                    this.formData.email = user.email;
                    this.formData.bio = user.bio;
                    this.formData.phone = user.phone;
                }
            })
            .catch(err=>{
                console.log(err);
            })
            .then(()=> this.loading = false)
        }
      },
      setup(){
        // use middleware check if current customer login == current username param edit in url ===> show page edit .
        // var userLoggin = ref({});
        // var loading = ref(true);
        // var myProfile = ref(true);

        
        // const getUserLoggin = getUser()
        //     .then(response=>{
        //         if(response.statusText == 'OK'){
        //             userLoggin.value = response.data.data;
        //         }
        //     })
        //     .catch(err=>{
        //         console.log(err);
        //     })
        //     .then(()=> loading.value = false)

        // return {
        //     userLoggin,
        //     loading
        // }
      },
      mounted(){
        this.getUserData();
      }
    }
</script>