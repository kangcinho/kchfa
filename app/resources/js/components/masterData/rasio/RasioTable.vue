<template>
  <div class="column is-full container">
    <b-field expanded >
      <b-input placeholder="Search Rasio" type="search" icon="search" v-model="searchRasio" @keyup.native.enter="searchRasioPage"></b-input>
    </b-field>
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Rasio Name</th>
          <th>Rasio Count</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="dataRasio in dataRasioes" :key="dataRasio.rasioID">
          <td>{{ dataRasio.rasioName }}</td>
          <td>{{ dataRasio | rasioCount }}</td>
          <td>
            <b-button
              v-if="userData.isUpdate"
              type="is-info"
              size="is-small"
              icon-right="edit" 
              title="Edit Data Rasio"
              @click ="updateRasio(dataRasio)"/>
            <b-button
            v-if="userData.isDelete"
              type="is-danger"
              size="is-small"
              icon-right="trash-alt"
              title="Delete Data Rasio"
              @click="deleteRasio(dataRasio)"/>
            <b-button 
              type="is-success"
              size="is-small"
              icon-right="search" 
              title="Detail Data Rasio"
              @click ="detailRasio(dataRasio)"/>
          </td>
        </tr>
      </tbody>
    </table>
    <b-pagination
      :total="pagging.total"
      :current.sync="pagging.current"
      :range-before="pagging.rangeBefore"
      :range-after="pagging.rangeAfter"
      :per-page="pagging.perPage"
      rounded
      icon-prev="chevron-left"
      icon-next="chevron-right"
      aria-next-label="Next page"
      aria-previous-label="Previous page"
      aria-page-label="Page"
      aria-current-label="Current page">
    </b-pagination>
  </div>
</template>

<script>
import Event from '../../../Event'
import ModalKonfirmasiHapus from '../modal/ModalKonfirmasiHapus'
import RasioModal from './RasioModal'

export default {
  name: "RasioTableComponent",
  props: ['userData'],
  data(){
    return {
      rasio: {
        rasioID: null,
        rasioName: null,
        note: null,
        isCreate: true,
        isFinancial: false,
        isOwner: false,
        isNeraca: false,
        isLabaRugi: false,
        isCashFlow: false,
        isCFO: false,
        isCFI: false,
        isCFF: false,
        isPBV: false,
        isPER: false,
        isEPS: false,
        isROE: false,
        isGPM: false,
        isNPM: false,
        isDER: false,
        isTax: false,
        isBVPS: false,
        isCurrentRatio: false,
        isQuickRatio: false,
        isNWC: false
      },
      searchRasio: '',
      pagging:{
        total: 0,
        current: 1,
        perPage: 8,
        rangeBefore: 2,
        rangeAfter: 2
      }
    }
  },
  mounted(){
    this.getRasioDataPage()
  },
  computed:{
    dataRasioes(){
      return this.$store.getters.getRasioData
    }
  },
  methods:{
    searchRasioPage(){
      this.pagging.current = 1
      this.getRasioDataPage()
    },
    updateRasio(dataRasio){
      this.rasio.rasioID = dataRasio.rasioID
      this.rasio.rasioName = dataRasio.rasioName
      this.rasio.note = dataRasio.note
      this.rasio.isCreate = dataRasio.isCreate
      this.rasio.isFinancial = dataRasio.isFinancial
      this.rasio.isOwner = dataRasio.isOwner
      this.rasio.isNeraca = dataRasio.isNeraca
      this.rasio.isLabaRugi = dataRasio.isLabaRugi
      this.rasio.isCashFlow = dataRasio.isCashFlow
      this.rasio.isCFO = dataRasio.isCFO
      this.rasio.isCFI = dataRasio.isCFI
      this.rasio.isCFF = dataRasio.isCFF
      this.rasio.isPBV = dataRasio.isPBV
      this.rasio.isPER = dataRasio.isPER
      this.rasio.isEPS = dataRasio.isEPS
      this.rasio.isROE = dataRasio.isROE
      this.rasio.isGPM = dataRasio.isGPM
      this.rasio.isNPM = dataRasio.isNPM
      this.rasio.isDER = dataRasio.isDER
      this.rasio.isTax = dataRasio.isTax
      this.rasio.isBVPS = dataRasio.isBVPS
      this.rasio.isCurrentRatio = dataRasio.isCurrentRatio
      this.rasio.isQuickRatio = dataRasio.isQuickRatio
      this.rasio.isNWC = dataRasio.isNWC
      this.rasio.isCreate = false
      Event.$emit('updateDataRasio', this.rasio)
    },
    deleteRasio(dataRasio){
      this.$buefy.modal.open({
        parent: this,
        component: ModalKonfirmasiHapus,
        hasModalCard: true,
        props:{
          'nama': dataRasio.rasioName,
          'data': dataRasio,
          'method': 'deleteRasio',
        }
      })
    },
    detailRasio(dataRasio){
      this.$buefy.modal.open({
        parent: this,
        component: RasioModal,
        hasModalCard: true,
        fullScreen: true,
        props:{
          'data': dataRasio
        }
      })
    },
    getRasioDataPage(){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      Event.$emit('isLoading', true)
      this.$store.dispatch('getRasioPage', {firstPage,lastPage, searchRasio: this.searchRasio})
      .then( (respon) => {
        Event.$emit('isLoading', false)
        this.pagging.total =  this.$store.getters.getRasioDataTotal
        // this.$buefy.toast.open({
        //   message: respon,
        //   type: 'is-success'
        // })
      })
      .catch( (respon) => {
        Event.$emit('isLoading', false)
        this.$buefy.notification.open({
          message: respon,
          type: 'is-danger'
        })
      })
    }
  },
  filters:{
    rasioCount(dataRasio){
      const keyRasio = Object.keys(dataRasio)
      let countingRasio = 0

      keyRasio.forEach((item, index) => {
        if(dataRasio[item] == true){
          countingRasio++
        }
      })
      return countingRasio
    }
  },
  watch:{
    'pagging.current'(newVal, oldVal){
      this.getRasioDataPage()
    }
  }
}
</script>

<style>

</style>