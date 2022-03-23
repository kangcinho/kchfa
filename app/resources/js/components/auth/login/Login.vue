<template>
  <div class="columns is-centered mt-10px">
    <div class="column is-four-fifths-desktop is-four-fifths-widescreen is-half-fullhd is-full-mobile is-full-tablet">
      <article class="message is-primary is-normal" >
          <div class="message-header">
            <p>Login</p>
          </div>
          <div class="message-body">
            <b-field label="Username">
              <b-input v-model="user.username"></b-input>
            </b-field>
            <b-field label="Password">
              <b-input type="password" v-model="user.password" @keyup.native.enter="login" password-reveal></b-input>
            </b-field>
            <b-button type="is-primary" expanded 
                  icon-left="sign-in-alt"
                  @click="login">
                  Sign In
              </b-button>
          </div>
      </article>
    </div>
  </div>
</template>

<script>
import Event from '../../../Event'
export default {
  name: 'LoginComponent',
  data(){
    return {
      user: {
        username: null,
        password: null
      }
    }
  },
  methods:{
    login(){
      this.$store.dispatch('loginUser', this.user)
      .then( (respon) => {
        this.$router.push({'name': 'HomePage'})
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
  mounted(){
    Event.$emit('isLoading', false)
  }
}
</script>

<style>

</style>