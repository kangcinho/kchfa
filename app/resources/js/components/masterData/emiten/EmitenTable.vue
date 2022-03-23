<template>
  <div class="column is-full container">

    <b-field grouped>
      <b-field>
        <b-select 
          placeholder="Sector" 
          v-model="searchSector"
          @change.native="getSubSector"
          >
          <option value="">Search Sector</option>
          <option v-for="sector in dataSectors" :value="sector.sectorID" :key="sector.sectorID">
            {{ sector.sectorName }}
          </option>
        </b-select>
      </b-field>
      <b-field>
        <b-select placeholder="Sub Sector" v-model="searchSubSector">
          <option value="">Search Sub Sector</option>
          <option
            v-for="option in dataSubSectors"
            :value="option.subSectorID"
            :key="option.subSectorID">
            {{ option.subSectorName }}
          </option>
        </b-select>
      </b-field>
      <b-field expanded >
        <b-input placeholder="Search Emiten by Name or Kode" type="search" icon="search" v-model="searchEmiten" @keyup.native.enter="searchEmitenPage"></b-input>
      </b-field>
      <p class="control">
          <button class="button is-success" @click="searchEmitenPage" title="Searching...">
            <b-icon icon="search"></b-icon>
          </button>
          <button class="button is-warning" @click="clearSearching" title="Clear Search">
            <b-icon icon="times"></b-icon>
          </button>
      </p>
    </b-field>
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Emiten Kode</th>
          <th>Emiten Name</th>
          <th>Amount Share</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="dataEmiten in dataEmitens" :key="dataEmiten.rasioID">
          <td>
            {{ dataEmiten.emitenKode }}
            <span v-if="dataEmiten.isAktif == 1 ? false : true">
              <b-icon icon="trash-alt"></b-icon>
            </span>  
          </td>
          <td>{{ dataEmiten.emitenName }}</td>
          <td>{{ dataEmiten.amountShare }}</td>
          <td>
            <b-button
              v-if="userData.isUpdate"
              type="is-info"
              size="is-small"
              icon-right="edit" 
              title="Edit Data Emiten"
              @click ="updateEmiten(dataEmiten)"/>
            <b-button
            v-if="userData.isDelete"
              type="is-danger"
              size="is-small"
              icon-right="trash-alt"
              title="Delete Data Emiten"
              @click="deleteEmiten(dataEmiten)"/>
            <b-button 
              type="is-success"
              size="is-small"
              icon-right="search" 
              title="Detail Data Emiten"
              @click ="detailEmiten(dataEmiten)"/>
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
import EmitenModal from './EmitenModal'

export default {
  name: "EmitenTableComponent",
  props:['userData', 'dataSectors', 'dataSubSectors'],
  data(){
    return {
      emiten: {
        emitenID: null,
        emitenKode: null,
        emitenName: null,
        amountShare: null,
        emitenInfo: null,
        emitenAddress: null,
        subSectorID: null,
        sectorID: null,
        isBUMN: false,
        isAktif: true
      },
      searchEmiten: '',
      searchSector:'',
      searchSubSector:'',
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
    this.getEmitenDataPage()
  },
  computed:{
    dataEmitens(){
      return this.$store.getters.getEmitenData
    }
  },
  methods:{
    clearSearching(){
      this.searchEmiten = ''
      this.searchSector = ''
      this.searchSubSector = ''
      this.getEmitenDataPage()
    },
    getSubSector(){
      Event.$emit('isLoading', true)
      this.$store.dispatch('getSubSectorBySector', {sectorID: this.searchSector})
      .then((respon) => {
        Event.$emit('isLoading', false)
        // this.$buefy.toast.open({
        //   message: respon,
        //   type: 'is-success'
        // })
        this.searchSubSector = ''
      })
      .catch((error) => {
        Event.$emit('isLoading', false)
        this.$buefy.notification.open({
          message: error,
          type: 'is-danger',
        })
      })
    },
    searchEmitenPage(){
      this.pagging.current = 1
      this.getEmitenDataPage()
    },
    updateEmiten(dataEmiten){
        this.emiten.emitenID = dataEmiten.emitenID
        this.emiten.emitenKode = dataEmiten.emitenKode
        this.emiten.emitenName = dataEmiten.emitenName
        this.emiten.amountShare = dataEmiten.amountShare
        this.emiten.emitenInfo = dataEmiten.emitenInfo
        this.emiten.emitenAddress = dataEmiten.emitenAddress
        this.emiten.subSectorID = dataEmiten.subSectorID
        this.emiten.isBUMN = dataEmiten.isBUMN
        this.emiten.isAktif = dataEmiten.isAktif
        this.emiten.sectorID = dataEmiten.sectorID
        this.emiten.isCreate = false
        Event.$emit('updateDataEmiten', this.emiten)
    },
    deleteEmiten(dataEmiten){
      this.$buefy.modal.open({
        parent: this,
        component: ModalKonfirmasiHapus,
        hasModalCard: true,
        props:{
          'nama': dataEmiten.emitenName,
          'data': dataEmiten,
          'method': 'deleteEmiten',
        }
      })
    },
    detailEmiten(dataEmiten){
      this.$buefy.modal.open({
        parent: this,
        component: EmitenModal,
        hasModalCard: true,
        fullScreen: true,
        props:{
          'data': dataEmiten
        }
      })
    },
    getEmitenDataPage(){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      Event.$emit('isLoading', true)
      this.$store.dispatch('getEmitenPage', {
        firstPage,
        lastPage, 
        searchEmiten: this.searchEmiten,
        searchSector: this.searchSector,
        searchSubSector: this.searchSubSector
      })
      .then( (respon) => {
        Event.$emit('isLoading', false)
        this.pagging.total =  this.$store.getters.getEmitenDataTotal
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
  watch:{
    'pagging.current'(newVal, oldVal){
      this.getEmitenDataPage()
    }
  }
}
</script>

<style>

</style>