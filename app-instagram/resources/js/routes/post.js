const post = [
    {
        path: "/post",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: "", // lay path cua thg cha luon
                name: "post-list",
                component: () => import("../components/PostComponent.vue")
            },
        ],
    },
];

console.log(post)

export default post;