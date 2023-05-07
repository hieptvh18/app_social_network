const error = [
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: ()=> import('../pages/404/index.vue') },
];

export default error;