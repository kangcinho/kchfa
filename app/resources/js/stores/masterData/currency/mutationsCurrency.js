import * as type from './typeMutationsCurrency'

function deleteDataCurrency(dataCurrency, stateData){
  stateData.map( (currency, index) => {
    if(currency.currencyID == dataCurrency.currencyID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_CURRENCY_DATA](state, payload){
    state.currencyData.push(payload)
  },
  [type.CURRENCY_DATA](state, payload){
    state.currencyData = payload
  },
  [type.SET_CURRENCY_DATA](state, payload){
    deleteDataCurrency(payload, state.currencyData)
    state.currencyData.push(payload)
  },
  [type.DELETE_CURRENCY_DATA](state,payload){
    deleteDataCurrency(payload, state.currencyData)
  }
}

export default mutations