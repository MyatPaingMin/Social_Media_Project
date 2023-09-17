import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import 'bootstrap/dist/css/bootstrap.min.css';
// import '@fontawesome/fontawesome-free/css/all.css'; // Import Font Awesome CSS

createApp(App).use(store).use(router).mount('#app')
