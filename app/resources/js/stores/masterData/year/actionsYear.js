import axios from 'axios'
import * as type from './typeMutationsYear'

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
  createYear({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.post('/api/year', data)
      .then( (respon) => {
        commit(type.CREATE_YEAR_DATA, respon.data.years)
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
  getYear({commit}){
    return new Promise( (berhasil, gagal) => {
      axios.get('/api/year')
      .then( (respon) => {
        commit(type.YEAR_DATA, respon.data.years)
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
  updateYear({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.put('/api/year', data)
      .then( (respon) => {
        commit(type.SET_YEAR_DATA, respon.data.years)
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
  deleteYear({commit}, data){
    return new Promise( (berhasil, gagal) => {
      axios.delete('/api/year', { params: { yearID: data.yearID } })
      .then( (respon) => {
        commit(type.DELETE_YEAR_DATA, data)
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