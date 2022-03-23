<template>
  <div class="columns is-centered is-multiline">
    <QuartalForm :userData="userData" />
    <QuartalTable :userData="userData" />
  </div>
</template>

<script>
import QuartalForm from './QuartalForm'
import QuartalTable from './QuartalTable'
export default {
  name: "QuartalMasterComponent",
  components: {
    QuartalForm,
    QuartalTable
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