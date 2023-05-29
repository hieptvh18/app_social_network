// router root
import { createRouter, createWebHistory } from "vue-router";
import post from "./post";
import home from "./home";
import profile from "./profile";
import error from "./error-page";
import auth from "./auth";

const routes = [...home,...post,...profile,...auth];

const router = createRouter({
    history:createWebHistory(),
    routes
});

// check middleware
router.beforeEach((to,from,next)=>{
    console.log('change router middleware');
    if(window.localStorage.getItem('tokenLogin')){
        next();
    }else{
        if(to.href == '/accounts/login' || to.href == '/accounts/register'){
            
            next();
        }else{
            window.location.href = '/accounts/login'
        }
    }
})

export default router;