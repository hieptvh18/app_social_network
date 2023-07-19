<template>
    <main>
        <div class="page register-page">
            <div class="header">
              <div class="box-logo">
                <router-link :to="{name:'homepage'}"><img :src="'../../../../assets/images/in.png'" /></router-link>
              </div>
              <p>Sign up to see photos and videos from your friends.</p>
              <button><i class="fab fa-google-square"></i> Log in with Google</button>
              <div>
                <hr>
                <p>OR</p>
                <hr>
              </div>
            </div>
            <div class="container">
              <form @submit.prevent="registerPost">
                <span class="text-danger">{{ errors.server ?? errors.server }}</span>
                <span class="text text-success">{{ messageSuccess ?? messageSuccess }}</span>
                <input v-model="name" type="text" name="name" placeholder="Full Name">
                <small class="text-danger">{{ errors.name ?? errors.name }}</small>

                <input v-model="email" type="text" name="email" placeholder="Email">
                <small class="text-danger">{{ errors.email ?? errors.email }}</small>

                <input v-model="username" type="text" name="username" placeholder="Username">
                <small class="text-danger">{{ errors.username ?? errors.username }}</small>

                <input v-model="password" type="password" name="password" placeholder="Password">
                <small class="text-danger">{{ errors.password ?? errors.password }}</small>

                <button type="submit">Sign up</button>
              </form>

              <ul>
                <li>By signing up, you agree to our</li>
                <li><a href="">Terms</a></li>
                <li><a href="">Data Policy</a></li>
                <li>and</li>
                <li><a href="">Cookies Policy</a> .</li>
             </ul>
            </div>
        </div>
        <div class="option">
           <p>Have an account?
            <router-link :to="{name:'login'}">Log in</router-link>
            </p>
        </div>
        <div class="otherapps">
          <p>Get the app.</p>
          <button type="button"><i class="fab fa-apple"></i> App Store</button>
          <button type="button"><i class="fab fa-google-play"></i> Google Play</button>
        </div>
        <div class="footer">
          <ul>
            <li><a href="">ABOUT</a></li>
            <li><a href="">HELP</a></li>
            <li><a href="">PRESS</a></li>
            <li><a href="">API</a></li>
            <li><a href="">JOBS</a></li>
            <li><a href="">PRIVACY</a></li>
            <li><a href="">TEMS</a></li>
            <li><a href="">LOCATIONS</a></li>
            <li><a href="">TOP ACCOUNTS</a></li>
            <li><a href="">HASHTAGS</a></li>
            <li><a href="">LANGUAGE</a></li>
          </ul>
          <p>© 2023 PICTUREGRAM</p>
        </div>
      </main>
</template>

<style scoped src="./register.css"></style>
<script>
import {register} from '../../api/auth';

export default {
    data(){
      return{
        messageSuccess:'',
        errors:{},
        name:'',
        email:'',
        username:'',
        password:'',
      }
    },
    methods:{
      async registerPost(e){
        if(this.validateForm()){
          // handle call api submit form
          const formData = {name:this.name, email: this.email, username:this.username, password:this.password};

          await register(formData)
          .then(response=>{
            console.log(response);
            if(response.data.status){
                delete this.errors['server'];
                this.messageSuccess = response.data.message;
            }else{
                this.errors.server = 'Register fail! try again!';
            }
          }).
          catch(error=>{
            console.log(error);
          })
        }
      },

      validateForm(){
        delete this.errors['server'];
        // fullname field
        if(!this.name) this.errors.name = 'Fullname is required!';
        else delete this.errors['name'];

        // email field
        if(!this.email) {
          this.errors.email = 'Email is required!';
        }else{
          let emailPattern =/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

          if(!emailPattern.test(this.email)) this.errors.email = 'Email is not vaild!';
          else delete this.errors['email'];
        }

        // username
        if(this.username){
          let usernamePattern = /^\w{4,14}$/; // not space, 4-14 character

          if(!usernamePattern.test(this.username)){
            this.errors.username = 'Username is not valid!';
          }else delete this.errors['username'];
        }else this.errors.username = 'Username is required!';

        // password
        if(!this.password){
          this.errors.password = 'Password is required';
        }else delete this.errors['password']

        if(Object.keys(this.errors).length){
          return false;
        }
        return true;
      },
    }
}
</script>
