import { createStore } from 'vuex';
import alerts from './alerts'
import auth from './auth'

export default createStore({
  state: {
    loading: [],
  },
  getters: {
    loading: state => state.loading.length !== 0,
  },
  mutations: {
    // Global loading indicator
    request(state, mod = []) {
      const i = state.loading.indexOf(mod);
      i !== -1 ? state.loading.splice(i, 1) : state.loading.push(mod);
    },
  },
  actions: {
  },
  modules: {
    alerts,
    auth,
  },
});
