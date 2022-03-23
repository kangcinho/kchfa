<template>
  <div class="columns is-centered is-multiline">
    <SubSectorForm :userData="userData" />
    <SubSectorTable :userData="userData" />
  </div>
</template>

<script>
import SubSectorForm from './SubSectorForm'
import SubSectorTable from './SubSectorTable'
export default {
  name: "SubSectorMasterComponent",
  components: {
    SubSectorForm,
    SubSectorTable
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