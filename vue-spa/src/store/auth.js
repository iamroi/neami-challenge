// import { LOGIN, LOGOUT } from '../mutation-types'

const state = {
    // auth: null,
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
    permissions: null,
    permissionsLoaded: false,
}

const getters = {
    isLoggedIn(state) {
        return !!state.token && !!state.user;
        // return state.token !== null && state.token !== '';
    },
    isUserCan: state => (data) => {
        // console.log(data);
        if(state.permissions === null) {
            return false;
        }
        return state.permissions.indexOf(data) !== -1;
    },
    permissions (state) {
        return state.permissions;
    },
    isPermissionsLoaded (state) {
        return state.permissionsLoaded;
    },
    authUser (state) {
        return state.user;
    }
}

const mutations = {
    authenticated (state, data) {
        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        state.user = data.user;
        state.token = data.token;
        state.permissions = data.permissions;
    },
    unauthenticated (state, data) {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        state.user = null;
        state.token = null;
        state.permissions = null;
    },
    updatePermissions (state, data) {
        state.permissions = data;
        state.permissionsLoaded = true;
    },
    updateAuthUser (state, data) {
        localStorage.setItem('user', JSON.stringify(data));
        state.user = data;
    },
}

const actions = {
    authenticated ({ commit, state }, data) {
        commit('authenticated', data);
    },
    unauthenticated ({ commit, state }, data) {
        commit('unauthenticated', data);
    },
    getAuthUser({ commit, state }, data) {
        return axios.get('/user/me')
            .then(result => {
                // console.dir(result);
                commit('updateAuthUser', result.data.data);
                return true;
            }).catch(err => {
                return false;
            });
    },
    getPermissions({ commit, state }, data) {
        return axios.get('/permissions')
            .then(result => {
                // console.dir(result);
                commit('updatePermissions', result.data.data);
                return true;
            }).catch(err => {
                return false;
            });
    },
}

export default {
    state,
    getters,
    mutations,
    actions,
}
