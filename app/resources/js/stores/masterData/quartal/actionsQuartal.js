import axios from 'axios'
import * as type from './typeMutationsQuartal'

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
  createQuartal({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/quartal', data)
      .then( (respon) => {
        commit(type.CREATE_QUARTAL_DATA, respon.data.quartals)
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
  getQuartal({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/quartal')
      .then( (respon) => {
        commit(type.QUARTAL_DATA, respon.data.quartals)
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
  updateQuartal({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/quartal', data)
      .then( (respon) => {
        commit(type.SET_QUARTAL_DATA, respon.data.quartals)
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
  deleteQuartal({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/quartal', { params: { quartalID: data.quartalID } })
      .then( (respon) => {
        commit(type.DELETE_QUARTAL_DATA, data)
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