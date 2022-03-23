<template>
  <div class="columns is-centered is-multiline">
    <SectorForm :userData="userData" />
    <SectorTable :userData="userData" />
  </div>
</template>

<script>
import SectorForm from './SectorForm'
import SectorTable from './SectorTable'
export default {
  name: "SectorMasterComponent",
  components:{
    SectorForm,
    SectorTable
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