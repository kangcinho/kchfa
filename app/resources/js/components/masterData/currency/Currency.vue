<template>
  <div class="columns is-centered is-multiline">
    <CurrencyForm :userData="userData"/>
    <CurrencyTable :userData="userData"/>
  </div>
</template>
<script>
import CurrencyForm from './CurrencyForm'
import CurrencyTable from './CurrencyTable'
export default {
  name: "CurrencyMasterComponent",
  components:{
    CurrencyForm,
    CurrencyTable
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