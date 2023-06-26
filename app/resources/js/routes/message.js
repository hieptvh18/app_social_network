const message = [
    {
        path: "/messages",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: "", 
                name: "messagepage",
                component: () => import("../pages/Message/index.vue"),
            },
        ],
    },
];

export default message;