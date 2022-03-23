import * as type from './typeMutationsRasio'

function deleteDataRasio(dataRasio, stateData){
  stateData.map( (rasio, index) => {
    if(rasio.rasioID == dataRasio.rasioID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_RASIO_DATA](state, payload){
    state.rasioData.push(payload)
  },
  [type.RASIO_DATA](state, payload){
    state.rasioData = payload
  },
  [type.SET_RASIO_DATA](state, payload){
    deleteDataRasio(payload, state.rasioData)
    state.rasioData.push(payload)
  },
  [type.DELETE_RASIO_DATA](state,payload){
    deleteDataRasio(payload, state.rasioData)
  },
  [type.RASIO_DATA_TOTAL](state, payload){
    state.rasioDataTotal = payload
  }
}

export default mutations