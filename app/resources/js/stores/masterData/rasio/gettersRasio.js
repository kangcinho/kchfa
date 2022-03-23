const getters = {
  getRasioData: (state) => {
    return state.rasioData.sort( (a,b) => {
      if(a.updated_at < b.updated_at){
        return 1
      }else if(a.updated_at > b.updated_at){
        return -1
      }
      return 0
    })
  },
  getRasioDataTotal: (state) => state.rasioDataTotal
}
  
export default getters