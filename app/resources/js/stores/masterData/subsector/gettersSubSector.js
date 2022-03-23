const getters = {
  getSubSectorData: (state) => {
    return state.subSectorData.sort( (a,b) => {
      if(a.updated_at < b.updated_at){
        return 1
      }else if(a.updated_at > b.updated_at){
        return -1
      }
      return 0
    })
  },
  getSubSectorBySectorData: (state) => {
    return state.subSectorBySectorData.sort( (a,b) => {
      if(a.subSectorName < b.subSectorName){
        return 1
      }else if(a.subSectorName > b.subSectorName){
        return -1
      }
      return 0
    })
  },
  getSubSectorDataTotal: (state) => state.subSectorDataTotal
}
  
export default getters