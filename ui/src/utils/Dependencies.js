import GlobalFilters from "./GlobalFilters";
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue/dist/bootstrap-vue.esm';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import '../assets/sass/app.scss';

window._ = require('lodash'); // lodash

const Dependencies = {
    install(Vue) {
        Vue.use(GlobalFilters);
        Vue.use(BootstrapVue);
        Vue.use(IconsPlugin);
    }
};

export default Dependencies;
