import axios from 'axios'
import * as type from './typeMutationsAuth'

const actions = {
  loginUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/login', data)
      .then( (respon) => {
        commit(type.LOGIN_USER, respon.data.user)
        localStorage.setItem('token', respon.data.token)
        axios.defaults.headers.common = {
          'Authorization': 'Bearer '+ respon.data.token,
        }
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("ERROR")
      })
    })
  },
  logoutUser({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/logout')
      .then( (respon) => {
        commit(type.LOGOUT_USER)
        localStorage.removeItem('token')
        delete axios.defaults.headers.common['Authorization']
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("ERROR")
      })
    })
  },
  getUserLogin({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/user-login')
      .then( (respon) => {
        commit(type.GET_USER, respon.data.user)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("ERROR")
      })
    })
  },
  refreshToken({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/refresh-token')
      .then( (respon) => {
        localStorage.setItem('token', respon.data.token)
        axios.defaults.headers.common = {
          'Authorization': 'Bearer '+ respon.data.token,
        }
      })
      .catch( (error) => {
        gagal("ERROR")
      })
    })
  }
}

export default actions