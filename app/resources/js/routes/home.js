import auth from '../middleware/auth';
const home = [
    {
        path: "",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: "", // lay path cua thg cha luon
                name: "homepage",
                component: () => import("../pages/HomePage/index.vue"),
                // meta:{
                //     requiresAuth: true
                // }
            },
        ],
    },
];

export default home;