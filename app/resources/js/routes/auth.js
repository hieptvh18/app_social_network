const auth = [
    {
        path: "/accounts",

        children: [
            {
                path: "login", // lay path cua thg cha luon
                name: "login",
                component: () => import("../pages/Auth/Login.vue")
            },
            {
                path: "register", 
                name: "register",
                component: () => import("../pages/Auth/Register.vue")
            },
        ],
    },
];

export default auth;