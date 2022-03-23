const getters = {
  getEmitenData: (state) => {
    return state.emitenData.sort( (a,b) => {
      if(a.updated_at < b.updated_at){
        return 1
      }else if(a.updated_at > b.updated_at){
        return -1
      }
      return 0
    })
  },
  getEmitenDataTotal: (state) => state.emitenDataTotal
}
  
export default getters