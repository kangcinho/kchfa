import Router from 'vue-router'
import Vue from 'vue'
import Login from '../components/auth/login/Login'
import Home from '../views/Home'
import Currency from '../components/masterData/currency/Currency'
import Emiten from '../components/masterData/emiten/Emiten'
import Sector from '../components/masterData/sector/Sector'
import Quartal from '../components/masterData/quartal/Quartal'
import Year from '../components/masterData/year/Year'
import SubSector from '../components/masterData/subsector/SubSector'
import Rasio from '../components/masterData/rasio/Rasio'
import Financial from '../components/financial/Financial'
import User from '../components/auth/user/User'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    // base: 'ongoing/kchfa/',
    routes:[
      {
        path: '/',
        name: 'HomePage',
        component: Home,
        meta: {
          auth: true
        }
      },
      {
        path: '/login',
        name: 'LoginPage',
        component: Login,
        meta: {
          auth: false
        },
      },
      {
        path: '/currency',
        name: 'CurrencyPage',
        component: Currency,
        meta: {
          auth: true
        },
      },
      {
        path: '/sector',
        name: 'SectorPage',
        component: Sector,
        meta: {
          auth: true
        },
      },
      {
        path: '/emiten',
        name: 'EmitenPage',
        component: Emiten,
        meta: {
          auth: true
        },
      },
      {
        path: '/quartal',
        name: 'QuartalPage',
        component: Quartal,
        meta: {
          auth: true
        },
      },
      {
        path: '/year',
        name: 'YearPage',
        component: Year,
        meta: {
          auth: true
        },
      },
      {
        path: '/subsector',
        name: 'SubSectorPage',
        component: SubSector,
        meta: {
          auth: true
        },
      },
      {
        path: '/rasio',
        name: 'RasioPage',
        component: Rasio,
        meta: {
          auth: true
        },
      },
      {
        path: '/financial-statement',
        name: 'FinancialPage',
        component: Financial,
        meta: {
          auth: true
        },
      },
      {
        path: '/user',
        name: 'UserPage',
        component: User,
        meta: {
          auth: true
        },
      }
    ],
    scrollBehavior( to, from, savePosisi){
      return {
        x:0,
        y:0
      }
    }
})
    
export default router