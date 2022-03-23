import * as type from './typeMutationsEmiten'

function deleteDataEmiten(dataEmiten, stateData){
  stateData.map( (emiten, index) => {
    if(emiten.emitenID == dataEmiten.emitenID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_EMITEN_DATA](state, payload){
    state.emitenData.push(payload)
  },
  [type.EMITEN_DATA](state, payload){
    state.emitenData = payload
  },
  [type.SET_EMITEN_DATA](state, payload){
    deleteDataEmiten(payload, state.emitenData)
    state.emitenData.push(payload)
  },
  [type.DELETE_EMITEN_DATA](state, payload){
    deleteDataEmiten(payload, state.emitenData)
  },
  [type.EMITEN_DATA_TOTAL](state, payload){
    state.emitenDataTotal = payload
  }
}

export default mutations