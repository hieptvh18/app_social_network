// router root
import { createRouter, createWebHistory } from "vue-router";
import post from "./post";
import home from "./home";
import profile from "./profile";
import error from "./error-page";

const routes = [...home,...post,...profile];

const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router;