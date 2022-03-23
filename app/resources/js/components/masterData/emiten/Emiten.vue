<template>
  <div class="columns is-centered is-multiline">
    <EmitenForm :userData="userData" :dataSectors="dataSectors" :dataSubSectors="dataSubSectors"/>
    <EmitenTable :userData="userData" :dataSectors="dataSectors" :dataSubSectors="dataSubSectors"/>
  </div>
</template>

<script>
import Event from '../../../Event'
import EmitenForm from './EmitenForm'
import EmitenTable from './EmitenTable'
export default {
  name: "EmitenMasterComponent",
  components:{
    EmitenForm,
    EmitenTable
  },
  computed:{
    userData(){
      return this.$store.getters.getUserDataLogin
    },
    dataSectors(){
      return this.$store.getters.getSectorData.sort( (a,b) => {
        if(a.sectorName > b.sectorName){
          return 1
        }else if(a.sectorName < b.sectorName){
          return -1
        }
        return 0
      })
    },
    dataSubSectors(){
      return this.$store.getters.getSubSectorBySectorData
    }
  },
  created(){
    Event.$emit('isLoading', true)
      this.$store.dispatch('getSector')
      .then((respon) => {
        Event.$emit('isLoading', false)
        // this.$buefy.toast.open({
        //     message: respon,
        //     type: 'is-success'
        // })
      })
      .catch((error) => {
        Event.$emit('isLoading', false)
        this.$buefy.notification.open({
          message: error,
          type: 'is-danger',
        })
      })
  }
}
</script>

<style>

</style>