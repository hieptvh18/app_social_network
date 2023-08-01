const story = [
    {
        path: "/story",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: "create", 
                name: "storycreate",
                component: () => import("../pages/Story/CreateStory.vue"),
                // meta:{
                //     requiresAuth: true
                // }
            },
        ],
    },
];

export default story;