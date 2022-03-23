<template>
  <div class="columns is-centered is-multiline">
    <YearForm :userData="userData" />
    <YearTable :userData="userData" />
  </div>
</template>

<script>
import YearForm from './YearForm'
import YearTable from './YearTable'
export default {
  name: "YearMasterComponent",
  components:{
    YearForm,
    YearTable
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