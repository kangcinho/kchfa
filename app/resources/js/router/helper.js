export default function initializeRouter(store, router) {
 var user = 'heloo'
  axios.interceptors.response.use(null, (error) => {
    if (error.response.status == 401) {
      store.dispatch('logoutUser')
      .then( (respon) => {
        router.push({ name: 'LoginPage' })
      })
    }
    if(error.response.status == 503){
      router.push({'name': 'HomePage'})
    }
  })
  
  if (localStorage.getItem('token')) {
    setAuthorization(localStorage.getItem('token'))
    store.dispatch('getUserLogin')
    .then((res) => {
      router.push({'name' :'HomePage'})
    }).catch(error => {
      localStorage.removeItem('token')
    })
  }
  
  router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.auth) && !localStorage.getItem('token')) {
      next({ name: 'LoginPage' })
    }else if (to.path == '/login' && localStorage.getItem('token')) {
      next({ name: 'HomePage' })
    }else if(to.path == '/login' && !localStorage.getItem('token')){
      next()
    }

    //Router Auth
    user = store.getters.getUserDataLogin
    if(user != null){
      // console.log('hlo')
      if((to.path == '/user') && !user.isAdmin) {
        next({ name: 'HomePage' })
      }else if((to.path == '/financial-statement') && !user.isFA) {
        next({ name: 'HomePage' })
      }else if((to.path == '/currency' || to.path == '/sector' || to.path == '/emiten' || to.path == '/quartal' || to.path == '/year' || to.path == '/subsector' || to.path == '/rasio') && !user.isMaster) {
        next({ name: 'HomePage' })
      }else{
        next()
      }
    }
    // next()
  })
  
}

export function setAuthorization(token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
} 