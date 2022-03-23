import * as type from './typeMutationsSubSector'

function deleteDataSubSector(dataSubSector, stateData){
  stateData.map( (subSector, index) => {
    if(subSector.subSectorID == dataSubSector.subSectorID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_SUBSECTOR_DATA](state, payload){
    state.subSectorData.push(payload)
  },
  [type.SUBSECTOR_DATA](state, payload){
    state.subSectorData = payload
  },
  [type.SET_SUBSECTOR_DATA](state, payload){
    deleteDataSubSector(payload, state.subSectorData)
    state.subSectorData.push(payload)
  },
  [type.DELETE_SUBSECTOR_DATA](state,payload){
    deleteDataSubSector(payload, state.subSectorData)
  },
  [type.SUBSECTOR_BY_SECTOR_DATA](state,payload){
    state.subSectorBySectorData = payload
  },
  [type.SUBSECTOR_DATA_TOTAL](state,payload){
    state.subSectorDataTotal = payload
  }
}

export default mutations