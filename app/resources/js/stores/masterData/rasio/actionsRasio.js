import axios from 'axios'
import * as type from './typeMutationsRasio'

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
  createRasio({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/rasio', data)
      .then( (respon) => {
        commit(type.CREATE_RASIO_DATA, respon.data.rasioes)
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
  getRasio({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/rasio')
      .then( (respon) => {
        commit(type.RASIO_DATA, respon.data.rasioes)
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
  updateRasio({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/rasio', data)
      .then( (respon) => {
        commit(type.SET_RASIO_DATA, respon.data.rasioes)
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
  deleteRasio({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/rasio', { params: { rasioID: data.rasioID } })
      .then( (respon) => {
        commit(type.DELETE_RASIO_DATA, data)
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
  getRasioPage({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/rasio/page', data)
      .then( (respon) => {
        commit(type.RASIO_DATA, respon.data.rasioes)
        commit(type.RASIO_DATA_TOTAL, respon.data.rasioCount)
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