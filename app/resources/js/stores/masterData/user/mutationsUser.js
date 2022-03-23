import * as type from './typeMutationsUser'

function deleteDataUser(dataUser, stateData){
  stateData.map( (user, index) => {
    if(user.userID == dataUser.userID){
      stateData.splice(index,1)
    }
  })
}
const mutations = {
  [type.CREATE_USER_DATA](state, payload){
    state.userData.push(payload)
  },
  [type.USER_DATA](state, payload){
    state.userData = payload
  },
  [type.SET_USER_DATA](state, payload){
    deleteDataUser(payload, state.userData)
    state.userData.push(payload)
  },
  [type.DELETE_USER_DATA](state,payload){
    deleteDataUser(payload, state.userData)
  }
}

export default mutations