import state from './statesSector'
import actions from './actionsSector'
import getters from './gettersSector'
import mutations from './mutationsSector'

const store = {
  state,
  mutations,
  actions,
  getters
}

export default store