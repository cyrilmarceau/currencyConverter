import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";
import ElementPlus from "element-plus";

import "element-plus/dist/index.css";
import "@/scss/_variable.scss";

const app = createApp(App);



axios.interceptors.request.use(config => {
    const token = localStorage.getItem("token");
    config.headers["Authorization"] = `Bearer ${token}`;
    config.headers.common['Access-Control-Allow-Origin'] = '*';
    return config;
});

app.use(router);
app.use(ElementPlus);

app.mount("#app");
