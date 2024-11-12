import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import axios from 'axios';
import router from './router'
import './assets/css/app.css';

axios.defaults.baseURL = 'https://localhost:7001//api';

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app');
