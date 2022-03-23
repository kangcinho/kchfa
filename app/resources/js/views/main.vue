<template>
  <div>
    <Header></Header>
    <router-view></router-view>
    <b-loading is-full-page :active.sync="isLoading" :can-cancel="false"></b-loading>
  </div>
</template>

<script>
import Header from '../views/Header'
import Event from '../Event'
export default {
  name: 'MainView',
  components:{
    Header
  },
  data(){
    return {
      isLoading: false
    }
  },
  created(){
    Event.$on('isLoading', (data) => {
      this.isLoading = data
    })
    // this.$store.dispatch('getUserLogin')
    // .then( (respon) => {
    //   this.$buefy.toast.open({
    //     message: respon,
    //     type: 'is-success'
    //   })
    // })
    // .catch( (error) => {
    //   this.$buefy.notification.open({
    //     message: error,
    //     type: 'is-danger',
    //   })
    // })
  },
  mounted(){
    setInterval(this.refreshToken, 300000)
  },
  methods:{
    refreshToken(){
      if(this.userData != null){
        //refresh token
        this.$store.dispatch('refreshToken')
      }
    }
  },
  computed:{
    userData(){
      return this.$store.getters.getUserDataLogin
    }
  }
}
</script>

<style>

</style>