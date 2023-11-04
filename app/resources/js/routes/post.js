const post = [
    {
        path: "/",
        component:()=>import('../layouts/main.vue'),

        children: [
            {
                path: "post/:id",
                name: "post.detail",
                component: () => import("../pages/Post/Index.vue")
            },
        ],
    },
];

export default post;