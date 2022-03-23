import * as type from './typeMutationsYear'

function deleteDataYear(dataYear, stateData){
  stateData.map( (year, index) => {
    if(year.yearID == dataYear.yearID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_YEAR_DATA](state, payload){
    state.yearData.push(payload)
  },
  [type.YEAR_DATA](state, payload){
    state.yearData = payload
  },
  [type.SET_YEAR_DATA](state, payload){
    deleteDataYear(payload, state.yearData)
    state.yearData.push(payload)
  },
  [type.DELETE_YEAR_DATA](state,payload){
    deleteDataYear(payload, state.yearData)
  }
}

export default mutations