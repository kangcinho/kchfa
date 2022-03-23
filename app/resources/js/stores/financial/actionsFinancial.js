import axios from 'axios'
import * as type from './typeMutationsFinancial'

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
  createFinancial({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/financial', data)
      .then( (respon) => {
        commit(type.CREATE_FINANCIAL_DATA, respon.data.financials)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        if(error.response.data.info.errorInfo){
          gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        }
        else{
          gagal(error.response.data.error)
        }
      })
    })
  },
  getFinancial({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/financial')
      .then( (respon) => {
        commit(type.FINANCIAL_DATA, respon.data.financials)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        if(error.response.data.info.errorInfo){
          gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        }
        else{
          gagal(error.response.data.error)
        }
      })
    })
  },
  updateFinancial({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/financial', data)
      .then( (respon) => {
        commit(type.SET_FINANCIAL_DATA, respon.data.financials)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        if(error.response.data.info.errorInfo){
          gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        }
        else{
          gagal(error.response.data.error)
        }
      })
    })
  },
  deleteFinancial({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/financial', { params: { emitenDataID: data.emitenDataID } })
      .then( (respon) => {
        commit(type.DELETE_FINANCIAL_DATA, data)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        if(error.response.data.info.errorInfo){
          gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        }
        else{
          gagal(error.response.data.error)
        }
      })
    })
  },
  getFinancialPage({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/financial/page', data)
      .then( (respon) => {
        commit(type.FINANCIAL_DATA, respon.data.financials)
        commit(type.FINANCIAL_DATA_TOTAL, respon.data.financialCount)
        berhasil(respon.data.status)
      })
      .catch( (error) => {
        if(error.response.data.info.errorInfo){
          gagal(error.response.data.error + '<br/> Error Code:' + error.response.data.info.errorInfo[1])
        }
        else{
          gagal(error.response.data.error)
        }
      })
    })
  },
}

export default actions