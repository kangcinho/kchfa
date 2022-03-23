<template>
  <div class="columns is-centered is-multiline">
    <RasioForm :userData="userData" />
    <RasioTable :userData="userData" />
  </div>
</template>

<script>
import RasioForm from './RasioForm'
import RasioTable from './RasioTable'

export default {
  name: "RasioMasterComponent",
  components: {
    RasioForm,
    RasioTable
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