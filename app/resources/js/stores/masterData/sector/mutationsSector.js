import * as type from './typeMutationsSector'

function deleteDataSector(dataSector, stateData){
  stateData.map( (sector, index) => {
    if(sector.sectorID == dataSector.sectorID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_SECTOR_DATA](state, payload){
    state.sectorData.push(payload)
  },
  [type.SECTOR_DATA](state, payload){
    state.sectorData = payload
  },
  [type.SET_SECTOR_DATA](state, payload){
    deleteDataSector(payload, state.sectorData)
    state.sectorData.push(payload)
  },
  [type.DELETE_SECTOR_DATA](state,payload){
    deleteDataSector(payload, state.sectorData)
  }
}

export default mutations