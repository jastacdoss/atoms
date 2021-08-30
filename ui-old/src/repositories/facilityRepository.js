import Axios from '../utils/Axios';
import store from '../store';

const model = 'facility';

function getResource() {
  return `/facilities`;
}

export default {
  get() {
    store.commit('request', `${model}/get`);

    return Axios.get(getResource())
      .then((resp) => resp)
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/get`);
        return response;
      });
  },
  create(data) {
    store.commit('request', `${model}/create`);
    return Axios.post(`${getResource()}`, data)
      .then((resp) => {
        store.commit('alerts/newMessage', { type: 'success', message: `${data.name} created successfully.` }, { root: true });
        return resp;
      })
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/create`);
        return response;
      });
  },
  update(area_id, data) {
    store.commit('request', `${model}/update`);
    return Axios.put(`${getResource()}/${area_id}`, data)
      .then((resp) => {
        store.commit('alerts/newMessage', { type: 'success', message: `${data.name} updated successfully.` }, { root: true });
        return resp;
      })
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/update`);
        return response;
      });
  },
  delete(area) {
    store.commit('request', `${model}/delete`);
    return Axios.delete(`${getResource()}/${area.id}`)
      .then((resp) => {
        store.commit('alerts/newMessage', { type: 'success', message: `${area.name} deleted successfully.` }, { root: true });
        return resp;
      })
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/delete`);
        return response;
      });
  },
  reset(area) {
    store.commit('request', `${model}/reset`);
    return Axios.post(`${getResource()}/reset`, { area_slug: area.slug })
      .then((resp) => {
        store.commit('alerts/newMessage', { type: 'success', message: `${area.name} reset successfully.` }, { root: true });
        return resp;
      })
      .catch((e) => {
        store.commit('alerts/newMessage', { type: 'error', message: e.response.data }, { root: true });
        throw e.response.data;
      })
      .finally((response) => {
        store.commit('request', `${model}/reset`);
        return response;
      });
  },
};
