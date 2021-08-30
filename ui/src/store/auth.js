/** store/auth.js */
import AuthRepository from '../repositories/authRepository';
import router from '../router';

// Initial state for store
const init = () => {
    return {
        user: null,
        status: 'init',
    };
};

// State
const state = init();

const getters = {
    loggedIn: state => state.status === 'logged-in',
    user: state => state.user,
};

const actions = {
    checkUser({ commit, dispatch, state }) {
        return new Promise((resolve, reject) => {
            // Only check user if user not loaded
            if (state.status !== 'init') {
                resolve();
                return;
            }

            // See if user logged in
            AuthRepository.getUser()
                .then(r => {
                    // Not logged in, so do it
                    dispatch('setUser', r.data);
                    resolve(r.data);
                })
                .catch(e => {
                    // If not found then reset state
                    commit('logout');
                    commit('status', 'logged-out');

                    // Reject the promise
                    reject(e);
                });
        })
    },
    setUser({ commit }, user) {
        return new Promise((resolve) => {
            // Store the logged in user
            commit('setUser', user);

            // ** Load dependencies using promise here **
            commit('status', 'logged-in');
            resolve({ user });
        });
    },
    login({ commit, dispatch }, data) {
        return new Promise((resolve, reject) => {
            commit('status', 'loading');

            // Set CSRF protection
            AuthRepository.csrf()
                .then(() => {
                    // Attempt to log user in
                    AuthRepository.login(data)
                        .then(r => {
                            dispatch('setUser', r.data)
                                .then(user => {
                                    resolve(user);
                                })
                        })
                        .catch(e => {
                            commit('status', 'error');
                            reject(e);
                        });
                });
        });
    },
    logout({commit}) {
        // Tell db the user wants out
        return AuthRepository.logout()
            .then(r => {
                // Clear out state and local storage
                commit('logout');

                // Confirmation message
                commit('alerts/newMessage', {
                    type: 'success',
                    message: 'You have been successfully logged out of the system'
                }, {root: true});

                return r;
            })
            .catch(err => {
                commit('alerts/newMessage', {
                    type: 'error',
                    message: 'Unable to connect to server to complete logout.'
                }, {root: true});
                return err;
            }).finally(() => {
                router.push('/');
            });
    },
};

const mutations = {
    status(state, status) {
        state.status = status;
    },
    setUser(state, user) {
        state.user = user;
    },
    logout(state) {
        Object.assign(state, init());
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
