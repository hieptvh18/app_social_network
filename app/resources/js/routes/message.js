const message = [
    {
        path: "/messages",
        component: () => import("../layouts/main.vue"),

        children: [
            {
                path: "", 
                name: "messagepage",
                component: () => import("../pages/Message/index.vue"),
                
                children:[
                    {
                        path:":id",
                        name:'chatdetail',
                        component: ()=>import("../components/Message/ChatDetail/index.vue")
                    }
                ]
            },
        ],
    },
];

export default message;