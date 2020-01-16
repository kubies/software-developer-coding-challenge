import {login, logout, me} from '../../api/user.js'
import {getToken, setToken, removeToken} from "../../utils/auth";

const state = {
  token: getToken(),
  user: null
}

const mutations = {
  SET_TOKEN: (state, token) => {
    state.token = token
    setToken(token)
  },
  SET_USER: (state, user) => {
    state.user = user
  }
}

const actions = {
  login({ commit }, userInfo) {
    return new Promise((resolve, reject) => {
      const { email, password } = userInfo
      login({email: email.trim(), password: password}).then(response => {
        const {data} = response
        commit('SET_TOKEN', data.token)
        resolve(data)
      }).catch(err => {
        reject(err.response)
      })
    })
  },
  logout({commit}) {
    return new Promise((resolve, reject) => {
      logout().then(response => {
        const {data} = response
        commit('SET_TOKEN', null)
        commit('SET_USER', null)
        removeToken()
        resolve(data)
      }).catch(err => {
        if(err.response.status === 401) {
          commit('SET_TOKEN', null)
          commit('SET_USER', null)
          removeToken()
        }
        reject(err.response)
      })
    })
  },
  me({commit}) {
    return new Promise((resolve, reject) => {
      me().then(response => {
        const {data} = response
        commit('SET_USER', data)
        resolve(data)
      }).catch(err => {
        reject(err.response)
      })
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
