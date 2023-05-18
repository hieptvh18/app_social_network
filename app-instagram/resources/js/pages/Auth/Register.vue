<template>
    <main>
        <div class="page">
            <div class="header">
              <h1 class="logo"><router-link :to="{name:'homepage'}">Picturegram</router-link></h1>
              <p>Sign up to see photos and videos from your friends.</p>
              <button><i class="fab fa-facebook-square"></i> Log in with Facebook</button>
              <div>
                <hr>
                <p>OR</p>
                <hr>
              </div>
            </div>
            <div class="container">
              <form action="{{route('registerPost')}}" method="POST">
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="fullname" placeholder="Full Name">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button>Sign up</button>
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

<script>
import RegisterStyle from './register.css';

export default {
    components: {
        RegisterStyle
    }
}
</script>
