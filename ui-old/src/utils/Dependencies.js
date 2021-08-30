import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'bootstrap/dist/css/bootstrap.css';

const Dependencies = {
    install(Vue) {
      Vue.use(BootstrapVue);
    }
};

export default Dependencies;
