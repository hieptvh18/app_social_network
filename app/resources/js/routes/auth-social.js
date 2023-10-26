const authSocial = [
    {
        path: "/",

        children: [
            {
                path: "/api/v1/auth/github/callback", 
                name: "login_social",
                component: () => import("../pages/Auth/LoginSocial.vue")
            },
        ],
    },
];

export default authSocial;