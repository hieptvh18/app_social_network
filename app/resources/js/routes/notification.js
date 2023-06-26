const notification = [
    {
        path: "/notifications",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: "", 
                name: "notificationpage",
                component: () => import("../pages/Notification/Index.vue"),
            },
        ],
    },
];

export default notification;