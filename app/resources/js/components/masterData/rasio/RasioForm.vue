<template>
  <div class="column mt-10px is-full">
    <article class="message is-primary is-normal">
      <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
        <p>Rasio Data</p>
      </div>
      <div class="message-header" @click="isOpen = false" v-else>
        <p>Rasio Data</p>
      </div>
      <div class="message-body" v-show="isOpen">
        <b-field label="Rasio Name"
          :type="errorRasio.rasioNameError ? 'is-danger': ''"
          :message="errorRasio.rasioNameError ? errorRasio.rasioNameMsg: ''"
          >
          <b-input 
            rounded
            v-model="rasio.rasioName"
            ref="rasioName"
          />
        </b-field>
        <b-field label="Rasio Note" >
          <b-input 
            type="textarea"
            rounded
            v-model="rasio.note"
          />
        </b-field>
        <p class="title is-6">Rasio Grouping</p>
        <b-field grouped>
          <div class="field">
            <b-switch v-model="rasio.isFinancial">
              Financial
            </b-switch>
          </div>
          <div class="field">
            <b-switch v-model="rasio.isOwner">
              Owner
            </b-switch>
          </div>
        </b-field>
        <div v-if="rasio.isFinancial">
          <p class="title is-6">Jenis Laporan Keuangan</p>
          <b-field grouped>
            <div class="field">
              <b-switch v-model="rasio.isNeraca">
                Neraca
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isLabaRugi">
                Laba Rugi
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isCashFlow">
                Cash Flow
              </b-switch>
            </div>
          </b-field>
          <p class="title is-6">Bagian Aset, Liablitas dan Ekuitas</p>
          <b-field grouped>
            <div class="field">
              <b-switch v-model="rasio.isDER">
                DER
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isCurrentRatio">
                Current Ratio
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isQuickRatio">
                Quick Ratio
              </b-switch>
            </div>
          </b-field>
          <p class="title is-6">Bagian Cash Flow</p>
          <b-field grouped>
            <div class="field">
              <b-switch v-model="rasio.isCFO">
                CFO
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isCFI">
                CFI
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isCFF">
                CFF
              </b-switch>
            </div>
          </b-field>
          <p class="title is-6">Bagian Laba Rugi</p>
          <b-field grouped>
            <div class="field">
              <b-switch v-model="rasio.isPBV">
                PBV
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isPER">
                PER
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isEPS">
                EPS
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isROE">
                ROE
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isGPM">
                GPM
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isNPM">
                NPM
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isTax">
                TAX
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isBVPS">
                BVPS
              </b-switch>
            </div>
            <div class="field">
              <b-switch v-model="rasio.isNWC">
                NWC
              </b-switch>
            </div>
          </b-field>        
        </div>
        <b-button type="is-info"  
          rounded
          icon-left="save"
          @click.native="saveRasio">
          <span v-if="rasio.isCreate">
              Save
          </span>
          <span v-else>
              Update
          </span>
        </b-button>
        <b-button type="is-warning"  
          rounded
          icon-left="trash"
          @click.native="clearForm(true)">
          Clear
        </b-button>
      </div>
    </article>
  </div>
</template>

<script>
import Event from '../../../Event'
export default {
  name: "RasioFormComponent",
  props: ['userData'],
  data(){
    return {
      isOpen: false,
      rasio:{
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
      errorRasio:{
        rasioNameError: false,
        rasioNameMsg: null
      }
    }
  },
  methods:{
    saveRasio(){
      if(this.validate()){
        Event.$emit('isLoading', true)
        if(this.rasio.isCreate){
          this.$store.dispatch('createRasio', this.rasio)
          .then((respon) => {
            Event.$emit('isLoading', false)
            this.$buefy.toast.open({
              message: respon,
              type: 'is-success'
            })
            this.clearForm(false)
          })
          .catch((error) => {
            Event.$emit('isLoading', false)
            this.$buefy.notification.open({
              message: error,
              type: 'is-danger',
            })
          })
        }else{
          this.$store.dispatch('updateRasio', this.rasio)
          .then((respon) => {
            Event.$emit('isLoading', false)
            this.$buefy.toast.open({
              message: respon,
              type: 'is-success'
            })
            this.clearForm(false)
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
      if(this.rasio.rasioName == null || this.rasio.rasioName == ''){
        this.errorRasio.rasioNameError = true
        this.errorRasio.rasioNameMsg = "Rasio Name Cannot Be Null"
        return false
      }else{
        this.errorRasio.rasioNameError = false
        this.errorRasio.rasioNameMsg = null
      }

      return true
    },
    clearForm(isOpen){
      this.isOpen = isOpen
      this.rasio.rasioID = null
      this.rasio.rasioName = null
      this.rasio.note = null
      this.rasio.isCreate = true
      this.rasio.isFinancial = false
      this.rasio.isOwner = false
      this.rasio.isNeraca = false
      this.rasio.isLabaRugi = false
      this.rasio.isCashFlow = false
      this.rasio.isCFO = false
      this.rasio.isCFI = false
      this.rasio.isCFF = false
      this.rasio.isPBV = false
      this.rasio.isPER = false
      this.rasio.isEPS = false
      this.rasio.isROE = false
      this.rasio.isGPM = false
      this.rasio.isNPM = false
      this.rasio.isDER = false
      this.rasio.isTax = false
      this.rasio.isBVPS = false
      this.rasio.isCurrentRatio = false
      this.rasio.isQuickRatio = false
      this.rasio.isNWC = false
    }
  },
  watch:{
    'rasio.isFinancial'(newVal){
      if(!newVal){
        this.rasio.isNeraca = false,
        this.rasio.isLabaRugi = false,
        this.rasio.isCashFlow = false,
        this.rasio.isCFO = false,
        this.rasio.isCFI = false,
        this.rasio.isCFF = false,
        this.rasio.isPBV = false,
        this.rasio.isPER = false,
        this.rasio.isEPS = false,
        this.rasio.isROE = false,
        this.rasio.isGPM = false,
        this.rasio.isNPM = false,
        this.rasio.isDER = false,
        this.rasio.isTax = false,
        this.rasio.isBVPS = false,
        this.rasio.isCurrentRatio = false,
        this.rasio.isQuickRatio = false,
        this.rasio.isNWC = false
      }
    }
  },
  mounted(){
    Event.$on('updateDataRasio', (data) => {
      this.rasio.rasioID = data.rasioID      
      this.rasio.rasioName = data.rasioName
      this.rasio.note = data.note
      this.rasio.isCreate = data.isCreate
      this.rasio.isFinancial = data.isFinancial
      this.rasio.isOwner = data.isOwner
      this.rasio.isNeraca = data.isNeraca
      this.rasio.isLabaRugi = data.isLabaRugi
      this.rasio.isCashFlow = data.isCashFlow
      this.rasio.isCFO = data.isCFO
      this.rasio.isCFI = data.isCFI
      this.rasio.isCFF = data.isCFF
      this.rasio.isPBV = data.isPBV
      this.rasio.isPER = data.isPER
      this.rasio.isEPS = data.isEPS
      this.rasio.isROE = data.isROE
      this.rasio.isGPM = data.isGPM
      this.rasio.isNPM = data.isNPM
      this.rasio.isDER = data.isDER
      this.rasio.isTax = data.isTax
      this.rasio.isBVPS = data.isBVPS
      this.rasio.isCurrentRatio = data.isCurrentRatio
      this.rasio.isQuickRatio = data.isQuickRatio
      this.rasio.isNWC = data.isNWC     
      this.isOpen = true
      console.log(data.isNWC)
    })
  },
}
</script>

<style>

</style>