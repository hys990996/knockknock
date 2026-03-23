import { createApp } from "vue";
import App from "./App.vue";
import Buefy from "buefy";
import "buefy/dist/buefy.css";
import router from "./router";
import { createPinia } from "pinia";
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import "@fortawesome/fontawesome-free/css/all.css";
import naive from "naive-ui";

//引用 bootstrap
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap";

//引用sass
import "@/assets/sass/style.scss";

//引用axios
import axios from "axios";
window.axios = axios;

// 進行初始化
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

createApp(App)
  .use(router)
  .use(pinia)
  .use(naive)
  .use(Buefy, {
    defaultIconPack: "mdi",
  })
  .mount("#app");
