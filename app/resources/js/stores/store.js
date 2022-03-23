import Vue from 'vue'
import Vuex from 'vuex'
import currency from './masterData/currency/currency'
import sector from './masterData/sector/sector'
import quartal from './masterData/quartal/quartal'
import year from './masterData/year/year'
import subsector from './masterData/subsector/subsector'
import rasio from './masterData/rasio/rasio'
import emiten from './masterData/emiten/emiten'
import financial from './financial/financial'
import user from './masterData/user/user'
import auth from './auth/auth'

Vue.use(Vuex)

export default new Vuex.Store({
  modules:{
    auth,
    currency,
    sector,
    quartal,
    year,
    subsector,
    rasio,
    emiten,
    financial,
    user
  }
})
