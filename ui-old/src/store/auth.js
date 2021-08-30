/** store/auth.js */
import AuthRepository from '../repositories/authRepository';
import router from '../router';
import store from "../store";

// System roles
const roles = [ // Order matters, user at bottom of list has all preceding roles automatically
    'guest',
    'controller',
    'bidaid',
    'arearep',
    'admin',
    'super',
];

const roleNames = {
    guest: 'Guest',
    controller: 'Controller',
    bidaid: 'Bidder',
    arearep: 'Area Rep',
    admin: 'Facility Rep',
    super: 'Super User',
};

// Initial state for store
const init = () => {
    return {
        roleNames,
        scope: {},
        status: 'init',
        user: null,
        mocking: false,
    };
};

// State
const state = init();

const getters = {
    loggedIn: state => state.status === 'logged-in',
    isLoggedInUser: (state) => (member_id) => {
        return state.user.member_id === member_id;
    },
    roles: state => state.scope.roles,
    isScopeSet: state => !!state.scope.user_id,
    hasRole: (state, getters) => (roles) => {
        // Make sure roles is an array
        let requestedRoles = roles instanceof Array ? roles : [ roles ];

        return getters.isScopeSet && _.intersection(requestedRoles, state.scope.roles).length > 0;
    },
    is: (state) => (role, areaId = null) => {
        // Make sure user logged in
        if (!state.user)
            return false;

        // Validate the role and scope
        let areaCheck = areaId ? state.scope.areas.includes(areaId) : true; // Check area scope, if specified
            // roleIdx = state.scope.roles.indexOf(state.user.role_id),
            // roles = state.scope.roles.slice(0, roleIdx + 1);

        // Check role and scope
        if (state.user.role_id === 'super') {
            return true; // Super always allowed
        } else if (!state.scope.facility) {
            return false; // Everyone else must be in their facility
        } else {
            return state.scope.roles.includes(role) && areaCheck;
        }
    },
    mocking: state => state.mocking,
    roleName: (state) => (role) => {
        return state.roleNames[role];
    },
    roleNames: state => state.roleNames,
    role: state => state.roleNames[state.user.role_id],
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
    setUser({ commit, dispatch }, user) {
        return new Promise((resolve, reject) => {
            // Store the logged in user
            commit('setUser', user);

            // Fetch the member record for the user
            dispatch('member/fetch', user.member_id, { root: true })
                .then(r => {
                    commit('status', 'logged-in');
                    resolve({ user, member: r.data });
                })
                .catch(e => {
                    commit('status', 'error');
                    dispatch('logout');
                    reject(e);
                });
        })
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
    mockUser({ commit, dispatch }, user) {
        // Handle mocking
        commit('mocking', true);

        // Change the user
        dispatch('setUser', user)
            .then(r => {
                let { member } = r;
                dispatch('getScope', member.facility_id);
            })
    },
    getScope({ commit, getters }, facilityId) {
        return new Promise(( resolve ) => {
            // If scope is already set then just resolve
            if (getters.isScopeSet && !getters.mocking) {
                resolve();
                return;
            }

            // Scope not set so fetch it
            AuthRepository.getScope(facilityId, getters.mocking ? getters.user.id : null)
                .then(r => {
                    commit('setScope', r.data);
                    resolve();
                });
        });
    },
};

const mutations = {
    mocking(state) {
        state.mocking = true;
    },
    status(state, status) {
        state.status = status;
    },
    setUser(state, user) {
        state.user = user;
    },
    logout(state) {
        Object.assign(state, init());
    },
    setScope(state, scopes) {
        state.scope = scopes;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
