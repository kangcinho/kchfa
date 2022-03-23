import * as type from './typeMutationsQuartal'

function deleteDataQuartal(dataQuartal, stateData){
  stateData.map( (quartal, index) => {
    if(quartal.quartalID == dataQuartal.quartalID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_QUARTAL_DATA](state, payload){
    state.quartalData.push(payload)
  },
  [type.QUARTAL_DATA](state, payload){
    state.quartalData = payload
  },
  [type.SET_QUARTAL_DATA](state, payload){
    deleteDataQuartal(payload, state.quartalData)
    state.quartalData.push(payload)
  },
  [type.DELETE_QUARTAL_DATA](state,payload){
    deleteDataQuartal(payload, state.quartalData)
  }
}

export default mutations