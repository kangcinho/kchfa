import axios from 'axios'
import * as type from './typeMutationsSector'

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
  createSector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/sector', data)
      .then( (respon) => {
        commit(type.CREATE_SECTOR_DATA, respon.data.sectors)
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
  getSector({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/sector')
      .then( (respon) => {
        commit(type.SECTOR_DATA, respon.data.sectors)
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
  updateSector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/sector', data)
      .then( (respon) => {
        commit(type.SET_SECTOR_DATA, respon.data.sectors)
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
  deleteSector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/sector', { params: { sectorID: data.sectorID } })
      .then( (respon) => {
        commit(type.DELETE_SECTOR_DATA, data)
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