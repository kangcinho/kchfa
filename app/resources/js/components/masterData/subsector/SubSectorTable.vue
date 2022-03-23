<template>
  <div class="column is-full container">
    <b-field expanded >
      <b-input placeholder="Search Sub Sector" type="search" icon="search" v-model="searchSubSector" @keyup.native.enter="searchSubSectorPage"></b-input>
    </b-field>
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Sector Name</th>
          <th>SubSector Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="dataSubSector in dataSubSectors" :key="dataSubSector.subSectorID">
          <td>{{ dataSubSector.sector.sectorName }}</td>
          <td>{{ dataSubSector.subSectorName }}</td>
          <td>
            <b-button 
              v-if="userData.isUpdate"
              type="is-info"
              size="is-small"
              icon-right="edit" 
              title="Edit Data Sub Sector"
              @click ="updateSector(dataSubSector)"/>
            <b-button
              v-if="userData.isDelete"
              type="is-danger"
              size="is-small"
              icon-right="trash-alt"
              title="Delete Data Sub Sector"
              @click="deleteSector(dataSubSector)"/>
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
export default {
  name: "SectorTableComponent",
  props: ['userData'],
  data(){
    return {
      subSector: {
        sectorID: null,
        subSectorID: null,
        subSectorName: null,
        isCreate: false
      },
      searchSubSector: '',
      isLoading: false,
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
    this.getSubSectorDataPage()
  },
  computed:{
    dataSubSectors(){
      return this.$store.getters.getSubSectorData
    }
  },
  methods:{
    searchSubSectorPage(){
      this.pagging.current = 1
      this.getSubSectorDataPage()
    },
    updateSector(dataSubSector){
      this.subSector.subSectorID = dataSubSector.subSectorID
      this.subSector.sectorID = dataSubSector.sector.sectorID
      this.subSector.subSectorName = dataSubSector.subSectorName
      this.subSector.isCreate = false
      Event.$emit('updateDataSubSector', this.subSector)
    },
    deleteSector(dataSubSector){
      this.$buefy.modal.open({
        parent: this,
        component: ModalKonfirmasiHapus,
        hasModalCard: true,
        props:{
          'nama': dataSubSector.subSectorName,
          'data': dataSubSector,
          'method': 'deleteSubSector',
        }
      })
    },
    getSubSectorDataPage(){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      Event.$emit('isLoading', true)
      this.$store.dispatch('getSubSectorPage', {firstPage,lastPage, searchSubSector: this.searchSubSector})
      .then( (respon) => {
        Event.$emit('isLoading', false)
        this.pagging.total =  this.$store.getters.getSubSectorDataTotal
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
      this.getSubSectorDataPage()
    }
  }
}
</script>

<style>

</style>