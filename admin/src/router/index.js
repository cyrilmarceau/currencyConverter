import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            redirect: "/accueil",
        },
        {
            path: "/login",
            name: "login",
            component: () => import("../views/auth/LoginView.vue"),
        },
        {
            path: "/accueil",
            name: "accueil",
            component: () => import("../views/home/HomeView.vue"),
        },
        {
            path: "/pairs/create",
            name: "paires - création",
            component: () => import("../views/pairs/PairCreateView.vue"),
        },
        {
            path: "/pairs/update/:id",
            name: "pairs/update",
            component: () => import("../views/pairs/PairUpdateView.vue"),
        },
        // {
        //     path: "/pairs/:id",
        //     name: "pairs/pair",
        //     component: () => import("../views/users/PairView.vue"),
        // }
    ],
});

export default router;
