<template>
  <b-navbar type="is-primary" size="is-small">
        <template slot="brand">
            <b-navbar-item tag="router-link" to="/">
              KCH
            </b-navbar-item>
        </template>
        <template slot="start" v-if="userData">
            <b-navbar-item tag="router-link" to="/user" v-if="userData.isAdmin">
                User
            </b-navbar-item>
            <b-navbar-dropdown v-if="userData.isMaster" label="Master">
                <b-navbar-item tag="router-link" to="/currency">
                    Currency
                </b-navbar-item>
                <b-navbar-item tag="router-link" to="/emiten">
                    Emiten
                </b-navbar-item>
                <b-navbar-item tag="router-link" to="/rasio">
                    Rasio
                </b-navbar-item>
                <b-navbar-item tag="router-link" to="/sector">
                    Sector
                </b-navbar-item>
                <b-navbar-item tag="router-link" to="/subsector">
                    Sub Sector
                </b-navbar-item>
                <b-navbar-item tag="router-link" to="/quartal">
                    Quartal
                </b-navbar-item>
                <b-navbar-item tag="router-link" to="/year">
                    Year
                </b-navbar-item>
            </b-navbar-dropdown>
            <b-navbar-item tag="router-link" to="/financial-statement" v-if="userData.isFA">
                Financial Statement
            </b-navbar-item>
            <b-navbar-item href="#" v-if="userData != null">
                Analisa
            </b-navbar-item>
        </template>

        <template slot="end">
            <b-navbar-item tag="router-link" to="/login" v-if="userData == null">
                <div class="buttons">
                    <a class="button is-primary">
                        Log in
                    </a>
                </div>
            </b-navbar-item>
            <b-navbar-item>
                <div class="buttons" @click="logout" v-if="userData != null">
                    <a class="button is-primary">
                        Log Out
                    </a>
                </div>
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
export default {
  name: 'HeaderView',
  methods:{
    logout(){
        this.$store.dispatch('logoutUser')
        .then( (respon) => {
            this.$router.push({name: 'LoginPage'})
            this.$buefy.toast.open({
                message: respon,
                type: 'is-success'
            })
        })
        .catch( (error) => {
            this.$buefy.notification.open({
            message: error,
            type: 'is-danger',
            })
        })
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