// router root
import { createRouter, createWebHistory } from "vue-router";
import post from "./post";

const routes = [...post];

const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router;