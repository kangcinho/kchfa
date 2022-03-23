require("./bootstrap")
import Vue from 'vue'
import Main from './views/Main'
import Buefy from 'buefy'
import router from './router/router'
import store from './stores/store'
import initializeRouter from './router/helper'

Vue.use(require('vue-moment'))
Vue.use(Buefy, {
  defaultIconPack: 'fas',
})
initializeRouter(store, router)
new Vue({
  el: '#app',
  store,
  router,
  render: (h) => h(Main)
})