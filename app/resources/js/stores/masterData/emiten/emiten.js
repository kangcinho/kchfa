import state from './statesEmiten'
import actions from './actionsEmiten'
import getters from './gettersEmiten'
import mutations from './mutationsEmiten'

const store = {
  state,
  mutations,
  actions,
  getters
}

export default store