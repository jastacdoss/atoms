import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Dependencies from './utils/Dependencies';


createApp(App)
  .use(store)
  .use(router)
  .use(Dependencies)
  .mount('#app');
