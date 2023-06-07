// router root
import { createRouter, createWebHistory } from "vue-router";
import post from "./post";
import home from "./home";
import profile from "./profile";
import error from "./error-page";
import auth from "./auth";
import {getUser} from '../api/auth';

//init routing
const routes = [...home,...post,...profile,...auth];

const router = createRouter({
    history:createWebHistory(),
    routes
});

// check middleware

function isRouteAuth(href){
    if(href.indexOf('/accounts/login') != -1 || href.indexOf('accounts/register') != -1 ){
        return true;
    }
    return false;
}

function redirectLogin(message = 'Please Login!'){
    return window.location.href = '/accounts/login';
}

function redirectHome(){
    return window.location.href = '/';
}

router.beforeEach((to,from,next)=>{
    const tokenLogin = window.localStorage.getItem('tokenLogin');
    if(tokenLogin){
        if(isRouteAuth(to.href)){
            redirectHome();
        }else{
            next();
        }
    }else{
        if(isRouteAuth(to.href)){
            next();
        }else redirectLogin();
    }
})

export default router;