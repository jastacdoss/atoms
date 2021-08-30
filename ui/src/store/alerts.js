/** store/alerts.js */

// State
const state = {
    messages: [],
};

const getters = {
    messages: state => state.messages,
};

const actions = {
    fetchMessages({ state, commit }) {
        // Copy the message we are deleting
        let messages = [...state.messages];

        // Delete the messages
        commit('deleteAllMessages');

        // Return the message to the processor
        return messages;
    },
};

const mutations = {
    newMessage(state, message) {
        if (!message.message && message.type) return;

        if (typeof message.message === 'object') {
            message.message = message.message.message;
            message.title = 'Server Error'
            state.messages.push(message);
        } else {
            state.messages.push(message);
        }
    },
    deleteToastMessages(state) { // Toasts are not static and do not persist
        let m = state.messages.filter(m => !!m.static);
        state.messages = m;
    },
    deleteMessage(state, idx) {
        state.messages.splice(idx, 1);
    },
    deleteAllMessages(state) {
        state.messages = [];
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
