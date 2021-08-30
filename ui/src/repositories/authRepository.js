import Axios from '../utils/Axios';
import store from '../store';

const model = 'auth';
const resource = '';

export default {
  csrf() {
    return Axios.get('sanctum/csrf-cookie');
  },
  getUser() {
    store.commit('request', `${model}/getUser`);
    return Axios.get(`${resource}/get-user`)
      .then((resp) => resp)
      .catch((e) => {
        // store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, {root: true});
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/getUser`);
        return response;
      });
  },
  login(data) {
    store.commit('request', `${model}/login`);
    return Axios.post(`${resource}/login`, data)
      .then((resp) => resp)
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/login`);
        return response;
      });
  },
  logout() {
    store.commit('request', `${model}/logout`);
    return Axios.post(`${resource}/logout`)
      .then((resp) => resp)
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: `Unable to login. /n/r${e.response.data.message}` }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/logout`);
        return response;
      });
  },
  register(payload) {
    store.commit('request', `${model}/register`);
    return Axios.post(`${resource}/register`, payload)
      .then((resp) => resp)
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: `Unable to register. /n/r${e.response.data.message}` }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/register`);
        return response;
      });
  },
  requestResetCode(email) {
    store.commit('request', `${model}/requestResetCode`);
    return Axios.post(`${resource}/request-code`, email)
      .then((resp) => resp)
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data.message }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/requestResetCode`);
        return response;
      });
  },
  resetPassword(payload) {
    store.commit('request', `${model}/resetPassword`);
    return Axios.post(`${resource}/reset-password`, payload)
      .then((resp) => resp)
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data.message }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/resetPassword`);
        return response;
      });
  },
};
