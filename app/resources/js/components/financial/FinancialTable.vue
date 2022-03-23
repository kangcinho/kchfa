<template>
  <div class="column is-full container">
    <b-field expanded >
      <b-input placeholder="Search Emiten" type="search" icon="search" v-model="searchEmiten" @keyup.native.enter="searchFinancialPage"></b-input>
    </b-field>
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Emiten Kode</th>
          <th>Tahun</th>
          <th>Quartal</th>
          <th>Current Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="dataFinancial in dataFinancials" :key="dataFinancial.emitenDataID">
          <td>
            {{ dataFinancial.emitenKode }}
            <span v-if="dataFinancial.isAktif">
              <b-icon
                icon="check-circle"
              >

              </b-icon>
            </span>
          </td>
          <td>{{ dataFinancial.yearName }}</td>
          <td>{{ dataFinancial.quartalName }}</td>
          <td>{{ dataFinancial.emitenPrice }}</td>
          <td>
            <b-button 
              type="is-info"
              size="is-small"
              icon-right="edit" 
              title="Edit Data Financial"
              @click="updateFinancial(dataFinancial)"
              />
            <b-button
              type="is-danger"
              size="is-small"
              icon-right="trash-alt"
              title="Delete Data Financial"
              @click="deleteFinancial(dataFinancial)"/>
            <b-button
              type="is-success"
              size="is-small"
              icon-right="search"
              title="Detail Data Financial"
              @click="detailFinancial(dataFinancial)"/>
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
import Event from '../../Event'
import FinancialModalDetail from './FinancialModalDetail'
import ModalKonfirmasiHapus from '../masterData/modal/ModalKonfirmasiHapus'
export default {
  name: "FinancialTableComponent",
  data(){
    return {
      searchEmiten: '',
      pagging:{
        total: 0,
        current: 1,
        perPage: 8,
        rangeBefore: 2,
        rangeAfter: 2
      }
    }
  },
  computed:{
    dataFinancials(){
      return this.$store.getters.getFinancialData
    }
  },
  created(){
    // Event.$emit('isLoading', true)
    // this.$store.dispatch('getFinancial')
    // .then((respon) => {
    //   this.$buefy.toast.open({
    //     message: respon,
    //     type: 'is-success'
    //   })
    // })
    // .catch((error) => {
    //   Event.$emit('isLoading', false)
    //   this.$buefy.notification.open({
    //     message: error,
    //     type: 'is-danger',
    //   })
    // })
  },
  mounted(){
    this.getFinancialDataPage()
  },
  methods:{
    searchFinancialPage(){
      this.pagging.current = 1
      this.getFinancialDataPage()
    },
    getFinancialDataPage(){
      let firstPage,lastPage      
      firstPage = (this.pagging.current - 1) * this.pagging.perPage
      lastPage = this.pagging.perPage
      Event.$emit('isLoading', true)
      this.$store.dispatch('getFinancialPage', {firstPage,lastPage, searchEmiten: this.searchEmiten})
      .then( (respon) => {
        Event.$emit('isLoading', false)
        this.pagging.total =  this.$store.getters.getFinancialDataTotal
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
    },
    updateFinancial(dataFinancial){
      Event.$emit("updateDataFinancial",dataFinancial)
    },
    detailFinancial(dataFinancial){
      this.$buefy.modal.open({
          parent: this,
          component: FinancialModalDetail,
          hasModalCard: true,
          fullScreen: true,
          props:{
            'dataFinancial': dataFinancial,
          }
        })
    },
    deleteFinancial(dataFinancial){
      this.$buefy.modal.open({
          parent: this,
          component: ModalKonfirmasiHapus,
          hasModalCard: true,
          props:{
              'nama': dataFinancial.emitenKode + " " + dataFinancial.quartalName + " " + dataFinancial.yearName,
              'data': dataFinancial,
              'method': 'deleteFinancial',
          }
      })
    }
  },
  watch:{
    'pagging.current'(newVal, oldVal){
      this.getFinancialDataPage()
    }
  }
}
</script>

<style>

</style>