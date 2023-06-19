const profile = [
    {
        path: "/",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: ":username", // lay path cua thg cha luon
                name: "profile",
                component: () => import("../pages/Profile/index.vue")
            },
            {
                path: "accounts/edit/", 
                name: "account-edit",
                component: () => import("../pages/ProfileEdit/index.vue")
            },
        ],
    },
];

export default profile;