import * as type from './typeMutationsAuth'

const mutations = {
  [type.LOGIN_USER](state, payload){
    state.userDataLogin = payload
    state.isAuth = true
  },
  [type.LOGOUT_USER](state){
    state.userDataLogin = null
    state.isAuth = false
  },
  [type.GET_USER](state,payload){
    state.userDataLogin = payload
    state.isAuth = true
  }
}

export default mutations