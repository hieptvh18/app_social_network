import PageNotFound from '../pages/PageNotFound/index.vue';


const error = [
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: ()=> import('../pages/PageNotFound/index.vue') },
    { path: "/404.html",name:'pagenotfound', component: PageNotFound },
];

export default error;