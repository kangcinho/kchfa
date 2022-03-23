import axios from 'axios'
import * as type from './typeMutationsCurrency'

const actions = {
  createCurrency({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/currency', data)
      .then( (respon) => {
        commit(type.CREATE_CURRENCY_DATA, respon.data.currencies)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  getCurrency({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/currency')
      .then( (respon) => {
        commit(type.CURRENCY_DATA, respon.data.currencies)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  updateCurrency({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/currency', data)
      .then( (respon) => {
        commit(type.SET_CURRENCY_DATA, respon.data.currencies)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        // gagal(error.response.data.error)
        gagal("Error")
      })
    })
  },
  deleteCurrency({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/currency', { params: { currencyID: data.currencyID } })
      .then( (respon) => {
        commit(type.DELETE_CURRENCY_DATA, data)
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