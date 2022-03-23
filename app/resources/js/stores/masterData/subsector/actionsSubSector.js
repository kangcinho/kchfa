import axios from 'axios'
import * as type from './typeMutationsSubSector'

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
  createSubSector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/subsector', data)
      .then( (respon) => {
        commit(type.CREATE_SUBSECTOR_DATA, respon.data.subSectors)
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
  getSubSector({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/subsector')
      .then( (respon) => {
        commit(type.SUBSECTOR_DATA, respon.data.subSectors)
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
  updateSubSector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/subsector', data)
      .then( (respon) => {
        commit(type.SET_SUBSECTOR_DATA, respon.data.subSectors)
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
  deleteSubSector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/subsector', { params: { subSectorID: data.subSectorID } })
      .then( (respon) => {
        commit(type.DELETE_SUBSECTOR_DATA, data)
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
  getSubSectorBySector({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/subsector/sector',data)
      .then( (respon) => {
        commit(type.SUBSECTOR_BY_SECTOR_DATA, respon.data.subSectors)
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
  getSubSectorPage({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/subsector/page',data)
      .then( (respon) => {
        commit(type.SUBSECTOR_DATA, respon.data.subSectors)
        commit(type.SUBSECTOR_DATA_TOTAL, respon.data.subSectorCount)
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