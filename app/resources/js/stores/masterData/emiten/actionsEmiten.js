import axios from 'axios'
import * as type from './typeMutationsEmiten'

const actions = {
  createEmiten({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/emiten', data)
      .then( (respon) => {
        commit(type.CREATE_EMITEN_DATA, respon.data.emitens)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  getEmiten({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/emiten')
      .then( (respon) => {
        commit(type.EMITEN_DATA, respon.data.emitens)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  updateEmiten({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/emiten', data)
      .then( (respon) => {
        commit(type.SET_EMITEN_DATA, respon.data.emitens)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  deleteEmiten({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/emiten', { params: { emitenID: data.emitenID } })
      .then( (respon) => {
        commit(type.DELETE_EMITEN_DATA, data)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  getEmitenPage({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/emiten/page', data)
      .then( (respon) => {
        commit(type.EMITEN_DATA, respon.data.emitens)
        commit(type.EMITEN_DATA_TOTAL, respon.data.emitenCount)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  }
}

export default actions