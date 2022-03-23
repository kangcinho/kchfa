import axios from 'axios'
import * as type from './typeMutationsUser'

// axios.interceptors.response.use((respon) => {
//   if(respon.data.error == "Unauthorized"){
//     console.log('Intersepsion')
//     store.dispatch('tokenExpr')
//     delete axios.defaults.headers.common['Authorization']
//     router.push({'name': 'LoginPageSecond'})
//     return
//   }
//   return respon
// })

const actions = {
  createUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/user', data)
      .then( (respon) => {
        commit(type.CREATE_USER_DATA, respon.data.users)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // if(error.response.data.info.errorInfo){
        //   gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        // }
        // else{
        //   gagal(error.response.data.error)
        // }
        gagal("Error")
      })
    })
  },
  getUser({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/user')
      .then( (respon) => {
        commit(type.USER_DATA, respon.data.users)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // if(error.response.data.info.errorInfo){
        //   gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        // }
        // else{
        //   gagal(error.response.data.error)
        // }
        gagal("Error")
      })
    })
  },
  updateUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/user', data)
      .then( (respon) => {
        commit(type.SET_USER_DATA, respon.data.users)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // if(error.response.data.info.errorInfo){
        //   gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        // }
        // else{
        //   gagal(error.response.data.error)
        // }
        gagal("Error")
      })
    })
  },
  deleteUser({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/user', { params: { userID: data.userID } })
      .then( (respon) => {
        commit(type.DELETE_USER_DATA, data)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // if(error.response.data.info.errorInfo){
        //   gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        // }
        // else{
        //   gagal(error.response.data.error)
        // }
        gagal("Error")
      })
    })
  }
}

export default actions