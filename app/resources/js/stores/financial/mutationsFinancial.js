import * as type from './typeMutationsFinancial'

function deleteDataFinancial(dataFinancial, stateData){
  stateData.map( (financial, index) => {
    if(financial.emitenDataID == dataFinancial.emitenDataID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_FINANCIAL_DATA](state, payload){
    if(payload.isAktif){
      state.financialData.map( (financial) => {
        if(financial.emitenID == payload.emitenID){
          financial.isAktif = 0
        }
      })
    }
    state.financialData.push(payload)
  },
  [type.FINANCIAL_DATA](state, payload){
    state.financialData = payload
  },
  [type.SET_FINANCIAL_DATA](state, payload){
    deleteDataFinancial(payload, state.financialData)
    if(payload.isAktif){
      state.financialData.map( (financial) => {
        if(financial.emitenID == payload.emitenID){
          financial.isAktif = 0
        }
      })
    }
    state.financialData.push(payload)
  },
  [type.DELETE_FINANCIAL_DATA](state,payload){
    deleteDataFinancial(payload, state.financialData)
  },
  [type.FINANCIAL_DATA_TOTAL](state, payload){
    state.financialDataCount = payload
  }
}

export default mutations