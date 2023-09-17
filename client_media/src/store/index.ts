import { createStore } from 'vuex'

export default createStore({
  state: {
    userData : {},
    token : ''
  },
  getters: {
    gettokenData : (state) => state.token,
    getuserData : (state) => state.userData,
    getuserID : (state, getters) => getters.getuserData.id
  },
  mutations: {
    
  },
  actions: {
    loginUser : ({state},value) => state.userData = value,
    loginToken : ({state},value) => state.token = value,
  },
  modules: {
  }
})
