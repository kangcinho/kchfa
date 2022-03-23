const getters = {
  getYearData: (state) => {
    return state.yearData.sort( (a,b) => {
      if(a.updated_at < b.updated_at){
        return 1
      }else if(a.updated_at > b.updated_at){
        return -1
      }
      return 0
    })
  }
}
  
export default getters