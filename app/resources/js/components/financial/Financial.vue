<template>
  <div class="columns is-centered is-multiline">
    <FinancialForm/>
    <FinancialTable/>
  </div>
</template>

<script>
import FinancialForm from './FinancialForm'
import FinancialTable from './FinancialTable'

export default {
  name: "FinancialMasterComponent",
  components:{
    FinancialForm,
    FinancialTable
  }
}
</script>

<style>

</style>