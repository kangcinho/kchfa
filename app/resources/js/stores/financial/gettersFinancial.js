const getters = {
  // getFinancialData: (state) => {
  //   return state.financialData.sort( (a,b) => {
  //     if((a.emitenKode > b.emitenKode) && (a.yearName > b.yearName) && (a.quartalName > b.quartalName)){
  //       return 1
  //     }else if((a.emitenKode < b.emitenKode) && (a.yearName < b.yearName) && (a.quartalName < b.quartalName)){
  //       return -1
  //     }
  //     return 0
  //   })
  // },
  getFinancialData: (state) => state.financialData,
  getFinancialDataTotal: (state) => state.financialDataCount
}
  
export default getters