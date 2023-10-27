const authSocial = [
    {
        path: "/",

        children: [
            {
                path: "/auth/:provider/callback", 
                name: "login_social",
                component: () => import("../pages/Auth/LoginSocial.vue")
            },
        ],
    },
];

export default authSocial;