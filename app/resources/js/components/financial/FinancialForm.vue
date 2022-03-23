<template>
  <div class="column mt-10px is-full">
    <article class="message is-primary is-normal">
        <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true">
            <p>Financial Statement</p>
        </div>
        <div class="message-body" v-show="isOpen">
          <b-field label="Emiten"
            :type="errorFinancial.emitenIDError?'is-danger':''"
            :message="errorFinancial.emitenIDError? errorFinancial.emitenIDMsg: ''"
          >
            <b-autocomplete
              :data="filterDataEmitens"
              placeholder="Search a Emiten"
              icon="search"
              field="emitenName"
              v-model="searchEmiten"
              @input="getEmitenID(searchEmiten)"
              @select="option => selected = option">
              <template slot="empty">Emiten not found</template>
            </b-autocomplete>
          </b-field>
          <b-field label="Year"
            :type="errorFinancial.yearIDError?'is-danger':''"
            :message="errorFinancial.yearIDError? errorFinancial.yearIDMsg: ''"
          >
            <b-select placeholder="Select a Year"
              expanded
              v-model="financial.yearID"
              >
              <option
                v-for="option in dataYears"
                :value="option.yearID"
                :key="option.yearID">
                {{ option.yearName }}
              </option>
            </b-select>
          </b-field>
          <b-field label="Quartal"
            :type="errorFinancial.quartalIDError?'is-danger':''"
            :message="errorFinancial.quartalIDError? errorFinancial.quartalIDMsg: ''"
          >
            <b-select placeholder="Select a Quartal"
              expanded
              v-model="financial.quartalID">
              <option
                v-for="option in dataQuartals"
                :value="option.quartalID"
                :key="option.quartalID">
                {{ option.quartalName }}
              </option>
            </b-select>
          </b-field>
          <b-field label="Emiten Current Price"
            :type="errorFinancial.emitenPriceError?'is-danger':''"
            :message="errorFinancial.emitenPriceError? errorFinancial.emitenPriceMsg: ''"
          >
            <b-input 
              v-model="financial.emitenPrice"
              placeholder="Emiten Price"
            />
          </b-field>
          <b-field>
            <b-switch v-model="financial.isAktif">
              Aktif
            </b-switch>
          </b-field>
          <b-button type="is-info"  
              rounded
              icon-left="save"
              @click="financialNextStep">
              <span v-if="financial.isCreate">
                  Next Save
              </span>
              <span v-else>
                  Next Update
              </span>
          </b-button>
          <b-button type="is-warning"  
              rounded
              icon-left="trash"
              @click="clearForm">
              Clear
          </b-button>
        </div>
    </article>
  </div>
</template>

<script>
import Event from '../../Event'
import FinancialModalNextStep from './FinancialModalNextStep'
export default {
  name: "FinancialFormComponent",
  data(){
    return {
      isOpen: false,
      financial:{
        isCreate: true,
        emitenDataID: null,
        emitenID: null,
        emitenName: null,
        emitenKode: null,
        yearID: null,
        quartalID: null,
        emitenPrice: null,
        isAktif: true,
        rasioes: []
      },
      errorFinancial:{
        emitenIDError: false,
        yearIDError: false,
        quartalIDError: false,
        emitenPriceError: false,

        emitenIDMsg: null,
        yearIDMsg: null,
        quartalIDMsg: null,
        emitenPriceMsg: null,
      },
      searchEmiten: '',
    }
  },
  methods:{
    getEmitenID(dataEmiten){
      // console.log(dataEmiten)
      this.dataEmitens.map( (emiten) => {
        if(
          emiten.emitenKode.toString()
          .toLowerCase()
          .indexOf(dataEmiten.toLowerCase()) >= 0 
          ||
          emiten.emitenName.toString()
          .toLowerCase()
          .indexOf(dataEmiten.toLowerCase()) >= 0 
        ){
          this.financial.emitenID = emiten.emitenID
          this.financial.emitenName = emiten.emitenName
          this.financial.emitenKode = emiten.emitenKode
          // console.log(emiten.emitenID)
        }
      })
    },
    clearForm(){
      Event.$emit('clearFormFinancial')
    },
    financialNextStep(){
      if(this.validate()){
        this.$buefy.modal.open({
          parent: this,
          component: FinancialModalNextStep,
          hasModalCard: true,
          fullScreen: true,
          props:{
            'dataFinancial': this.financial,
            'dataRasioes': this.dataRasioes,
            'dataCurrencies': this.dataCurrencies
          }
        })
      }      
    },
    validate(){
      let emitenPrice = 0, error = 0
      if(this.financial.emitenID == null || this.financial.emitenID == ''){
        this.errorFinancial.emitenIDError = true
        this.errorFinancial.emitenIDMsg = "Emiten Cannot Be Null"
        error++
      }else{
        this.errorFinancial.emitenIDError = false
        this.errorFinancial.emitenIDMsg = null
      }

      if(this.financial.yearID == null || this.financial.yearID == ''){
        this.errorFinancial.yearIDError = true
        this.errorFinancial.yearIDMsg = "Year Cannot Be Null"
        error++
      }else{
        this.errorFinancial.yearIDError = false
        this.errorFinancial.yearIDMsg = null
      }

      if(this.financial.quartalID == null || this.financial.quartalID == ''){
        this.errorFinancial.quartalIDError = true
        this.errorFinancial.quartalIDMsg = "Quartal Cannot Be Null"
        error++
      }else{
        this.errorFinancial.quartalIDError = false
        this.errorFinancial.quartalIDMsg = null
      }

      if(this.financial.emitenPrice == null || this.financial.emitenPrice == ''){
        this.errorFinancial.emitenPriceError = true
        this.errorFinancial.emitenPriceMsg = "Emiten Price Cannot Be Null"
        error++
      }else{
        let emitenPrice = this.financial.emitenPrice.replace(/\./g,'')
        if(isNaN(emitenPrice)){
          this.errorFinancial.emitenPriceError = true
          this.errorFinancial.emitenPriceMsg = "Emiten Price Must Be Number"
          error++
        }else{
          this.errorFinancial.emitenPriceError = false
          this.errorFinancial.emitenPriceMsg = null
        }
      }

      if(error > 0){
        return false
      }
      return true
    }
  },
  created(){
    Event.$emit('isLoading', true)
    this.$store.dispatch('getEmiten')
    .then((respon) => {
      // this.$buefy.toast.open({
      //   message: respon,
      //   type: 'is-success'
      // })
    })
    .catch((error) => {
      Event.$emit('isLoading', false)
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
      })
    })

    this.$store.dispatch('getQuartal')
    .then((respon) => {
      // this.$buefy.toast.open({
      //   message: respon,
      //   type: 'is-success'
      // })
    })
    .catch((error) => {
      Event.$emit('isLoading', false)
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
      })
    })

    this.$store.dispatch('getRasio')
    .then((respon) => {
      // this.$buefy.toast.open({
      //   message: respon,
      //   type: 'is-success'
      // })
    })
    .catch((error) => {
      Event.$emit('isLoading', false)
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
      })
    })

    this.$store.dispatch('getCurrency')
    .then((respon) => {
      // this.$buefy.toast.open({
      //   message: respon,
      //   type: 'is-success'
      // })
    })
    .catch((error) => {
      Event.$emit('isLoading', false)
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
      })
    })

    this.$store.dispatch('getYear')
    .then((respon) => {
      Event.$emit('isLoading', false)
      // this.$buefy.toast.open({
      //   message: respon,
      //   type: 'is-success'
      // })
    })
    .catch((error) => {
      Event.$emit('isLoading', false)
      this.$buefy.notification.open({
        message: error,
        type: 'is-danger',
      })
    })
  },
  computed:{
    dataEmitens(){
      return this.$store.getters.getEmitenData.sort( (a,b) => {
        if(a.emitenKode > b.emitenKode){
          return 1
        }else if(a.emitenKode < b.emitenKode){
          return -1
        }
        return 0
      })
    },
    dataQuartals(){
      return this.$store.getters.getQuartalData.sort( (a,b) => {
        if(a.quartalName > b.quartalName){
          return 1
        }else if(a.quartalName < b.quartalName){
          return -1
        }
        return 0
      })
    },
    dataYears(){
      return this.$store.getters.getYearData.sort( (a,b) => {
        if(a.yearName < b.yearName){
          return 1
        }else if(a.yearName > b.yearName){
          return -1
        }
        return 0
      })
    },
    dataRasioes(){
      let dataSort = this.$store.getters.getRasioData.sort( (a,b) => {
        if(a.isLabaRugi < b.isLabaRugi){
          return 1
        }else if(a.isLabaRugi > b.isLabaRugi){
          return -1
        }
        return 0
      })
      return dataSort.filter( (data) => {
        if(data.isFinancial){
          return data
        }
      })
    },
    dataCurrencies(){
      return this.$store.getters.getCurrencyData.sort( (a,b) => {
        if(a.currencyName < b.currencyName){
          return 1
        }else if(a.currencyName > b.currencyName){
          return -1
        }
        return 0
      })
    },
    filterDataEmitens(){
      return this.dataEmitens.filter((option) => {
        return option.emitenName
          .toString()
          .toLowerCase()
          .indexOf(this.searchEmiten.toLowerCase()) >= 0 
          || 
          option.emitenKode.toString()
          .toLowerCase()
          .indexOf(this.searchEmiten.toLowerCase()) >= 0 
      })
    }
  },
  watch:{
    'financial.emitenPrice'(valueNumber){
      this.financial.emitenPrice = this.$options.filters.humanReaderNumber(valueNumber)
    }
  },
  filters:{
    humanReaderNumber(valueNumber){
      if(valueNumber == null || valueNumber == ''){
        return valueNumber
      }
      let number_string = valueNumber.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);
      
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
    
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return  rupiah
    }
  },
  mounted(){
    Event.$on('updateDataFinancial', (dataFinancial) => {
      this.financial.rasioes = []
      this.financial.isCreate = false
      this.financial.emitenDataID = dataFinancial.emitenDataID
      this.financial.emitenID = dataFinancial.emitenID
      this.financial.emitenName = dataFinancial.emitenName
      this.searchEmiten = dataFinancial.emitenName
      this.financial.emitenKode = dataFinancial.emitenKode
      this.financial.yearID = dataFinancial.yearID
      this.financial.quartalID = dataFinancial.quartalID
      this.financial.emitenPrice = dataFinancial.emitenPrice
      this.financial.isAktif = dataFinancial.isAktif ? true : false
      this.isOpen = true
      dataFinancial.rasio.map( (rasio) => {
        this.financial.rasioes.push(rasio)
      })
    })
    Event.$on('clearFormFinancial', () => {
      this.financial.rasioes = []
      this.financial.isCreate = true
      this.financial.emitenDataID = null
      this.financial.emitenID = null
      this.financial.emitenName = null
      this.searchEmiten = ''
      this.financial.emitenKode = null
      this.financial.yearID = null
      this.financial.quartalID = null
      this.financial.emitenPrice = null
      this.financial.isAktif = true
      this.isOpen = false
    })
  }
}
</script>

<style>

</style>