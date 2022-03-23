<template>
  <div class="modal-card" style="width: auto" v-if="financialStatement">
    <header class="modal-card-head">
      <p class="modal-card-title">
        <b>{{ financialStatement.emitenKode+"-"+financialStatement.emitenName }}</b> 
      </p>
    </header>
    <section class="modal-card-body">
      <div class="columns is-multiline">
        
        <div class="column is-3-fullhd is-3-widescreen is-4-desktop is-full-mobile is-6-tablet" v-for="(rasio,index) in financialStatement.rasioes" :key="rasio.rasioID">
          <!-- <b-field label="Rasio"
            :type="rasio.rasioIDError ? 'is-danger': ''"
            :message="rasio.rasioIDError ? rasio.rasioIDMsg: ''"
          > -->
          <b-field
            custom-class="is-medium">
            <template slot="label">
              Rasio
                <b-tooltip  :label="rasio.note" position="is-right">
                    <b-icon size="is-small" icon="question-circle"></b-icon>
                </b-tooltip>
            </template>
            <b-select placeholder="Select a Rasio"
              v-model="rasio.rasioID"
              expanded
              disabled >
              <option
                v-for="option in dataRasioes"
                :value="option.rasioID"
                :key="option.rasioID">
                {{ option.rasioName }}
              </option>
            </b-select>
          </b-field>
          <b-field label="Currency"
            :type="rasio.currencyIDError ? 'is-danger': ''"
            :message="rasio.currencyIDError ? rasio.currencyIDMsg: ''"
          >
            <b-select placeholder="Select a Currency"
              v-model="rasio.currencyID"
              @change.native="changeAllIDCurrency(rasio.currencyID)"
              expanded
              :disabled="!rasio.isEditable"
              >
              <option
                v-for="option in dataCurrencies"
                :value="option.currencyID"
                :key="option.currencyID">
                {{ option.currencyName }}
              </option>
            </b-select>
          </b-field>
          <b-field label="Kurs Currency to Rupiah"
            :type="rasio.pricePerUnitCurrencyError ? 'is-danger': ''"
            :message="rasio.pricePerUnitCurrencyError ? rasio.pricePerUnitCurrencyMsg: ''"
          >
            <b-input
              rounded
              v-model="rasio.pricePerUnitCurrency"
              :disabled="!rasio.isEditable"
              @change.native="changeAllUnitCurrency(rasio.pricePerUnitCurrency)"
              @keyup.native="humanReaderNumber(rasio.pricePerUnitCurrency, index, 'pricePerUnitCurrency')"
            />
          </b-field>
          <b-field label="Price Rasio"
            :type="rasio.priceError ? 'is-danger': ''"
            :message="rasio.priceError ? rasio.priceMsg: ''"
          >
            <b-input
              rounded
              v-model="rasio.price"
              @keyup.native="humanReaderNumber(rasio.price, index, 'price')"
              :disabled="!rasio.isEditable"
            />
          </b-field>
          <b-button
            v-if="!rasio.isEditable"
            icon-left="pencil-alt"
            type="is-danger"
            expanded
            @click.native="changeToEditRasioMode(rasio,index)">
            Edit Rasio
          </b-button>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
        <b-button type="is-info"  
          rounded
          icon-left="save"
          @click="createFinancial">
          <span v-if="financialStatement.isCreate">
            Save
          </span>
          <span v-else>
            Update
          </span>
        </b-button>
        <b-button type="is-warning"
          rounded
          icon-left="times"
          @click="closeModal()">
          Close
        </b-button>
        <b-button type="is-success"
          rounded
          icon-left="file-upload"
          @click="useTemplateRasio">
          Use Template Rasio
        </b-button>
    </footer>
  </div>
</template>

<script>
import Event from '../../Event'
export default {
  name: 'FinancialModalNextStep',
  props: ['dataFinancial','dataRasioes','dataCurrencies'],
  data(){
    return {
      financialStatement: null
    }
  },
  mounted(){
    this.financialStatement = this.dataFinancial
  },
  methods:{
    createFinancial(){
      if(this.validate()){
        Event.$emit('isLoading', true)
        if(this.financialStatement.isCreate){
          this.$store.dispatch('createFinancial', this.financialStatement)
          .then((respon) => {
            Event.$emit('isLoading', false)
            Event.$emit('clearFormFinancial')
            this.closeModal()
            this.$buefy.toast.open({
              message: respon,
              type: 'is-success'
            })
            // this.clearForm(false)
          })
          .catch((error) => {
            Event.$emit('isLoading', false)
            this.$buefy.notification.open({
              message: error,
              type: 'is-danger',
            })
          })
        }else{
          this.$store.dispatch('updateFinancial', this.financialStatement)
          .then((respon) => {
            Event.$emit('isLoading', false)
            Event.$emit('clearFormFinancial')
            this.closeModal()
            this.$buefy.toast.open({
              message: respon,
              type: 'is-success'
            })
            // this.clearForm(false)
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
    },
    validate(){
      let error = 0
      this.financialStatement.rasioes.map( (rasio) => {
        if(rasio.rasioID == null || rasio.rasioID == ''){
          rasio.rasioIDError = true
          rasio.rasioIDMsg = "Rasio Cannot Be Null"
          error++
        }else{
          rasio.rasioIDError = false
          rasio.rasioIDMsg = null
        }

        if(rasio.currencyID == null || rasio.currencyID == ''){
          rasio.currencyIDError = true
          rasio.currencyIDMsg = "Currency Cannot Be Null"
          error++
        }else{
          rasio.currencyIDError = false
          rasio.currencyIDMsg = null
        }
                
        if(rasio.pricePerUnitCurrency == null || rasio.pricePerUnitCurrency == ''){
          rasio.pricePerUnitCurrencyError = true
          rasio.pricePerUnitCurrencyMsg = "Price Currency Cannot Be Null"
          error++
        }else{
          rasio.pricePerUnitCurrencyError = false
          rasio.pricePerUnitCurrencyMsg = null
        }

        if(rasio.price == null || rasio.price == ''){
          rasio.priceError = true
          rasio.priceMsg = "Price Cannot Be Null"
          error++
        }else{
          rasio.priceError = false
          rasio.priceMsg = null
        }
      })
      if(error > 0){
        return false
      }
      return true
    },
    closeModal(){
      this.$parent.close()
    },
    changeToEditRasioMode(rasio,index){
      rasio.isEditable = true
    },
    deleteRasio(dataRasio, index){
      if(this.financialStatement.isCreate){
        //Tambah Data, Rasio Dihapus tanpa menuju DB
        this.financialStatement.rasioes.splice(index,1)
      }else{
        //Edit Data, Rasio Dihapus pada DB, jika bisa tambahkan pesan keyakinan
      }
    },
    humanReaderNumber(valueNumber, index, field){
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
      if(valueNumber.includes('-')){
        this.financialStatement.rasioes[index][field] = '-' + rupiah
      }else{
        this.financialStatement.rasioes[index][field] = rupiah 
      }
      
    },
    useTemplateRasio(){
      let exist = false
      this.dataRasioes.map( (dataRasio) => {
        //checking if rasio is exist
        exist = false
        this.financialStatement.rasioes.some((rasio) => {
          if(rasio.rasioID == dataRasio.rasioID){
            exist = true
          }
        })
        if(!exist){
          if(this.financialStatement.isCreate){
            this.financialStatement.rasioes.push({
              financialID: null,
              emitenDataID: null,
              rasioID: dataRasio.rasioID,
              note: dataRasio.note,
              currencyID: null,
              pricePerUnitCurrency: 1,
              price: 1,
              isEditable: true,
              rasioIDError: false,
              rasioIDMsg: null,
              currencyIDError: false,
              currencyIDMsg: null,
              pricePerUnitCurrencyError: false,
              pricePerUnitCurrencyMsg: null,
              priceError: false,
              priceMsg: null
            })
          }else{
            this.financialStatement.rasioes.push({
              financialID: null,
              emitenDataID: this.financialStatement.emitenDataID,
              rasioID: dataRasio.rasioID,
              note: dataRasio.note,
              currencyID: null,
              pricePerUnitCurrency: 1,
              price: 1,
              isEditable: false,
              rasioIDError: false,
              rasioIDMsg: null,
              currencyIDError: false,
              currencyIDMsg: null,
              pricePerUnitCurrencyError: false,
              pricePerUnitCurrencyMsg: null,
              priceError: false,
              priceMsg: null
            })
          }
          
        }
      })
    },
    changeAllUnitCurrency(price){
      this.financialStatement.rasioes.map( (rasio) => {
        rasio.pricePerUnitCurrency = price
      })
    },
    changeAllIDCurrency(curerncyID){
      this.financialStatement.rasioes.map( (rasio) => {
        rasio.currencyID = curerncyID
      })
    }
  }
}

/*
  Format Data CRUD dari DB
  [
    {
      emitenDataID: null
      emitenID: null,
      emitenName: null,
      emitenKode: null,
      yearID: null,
      yearName: null,
      quartalID: null,
      quartalName: null,
      emitenPrice: null,
      isAktif: true,
      isCreate: true,
      rasioes: [
        {
          financialID: null,
          emitenDataID: null,
          rasioID: dataRasio.rasioID,
          rasioName: null,
          currencyID: null,
          currencyName: null,
          pricePerUnitCurrency: 1,
          price: null,
        },
      ]
    }
  ]
*/
</script>

<style>

</style>
