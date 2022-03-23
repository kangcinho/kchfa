<template>
  <div class="column mt-10px is-full">
    <article class="message is-primary is-normal">
      <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
        <p>Emiten Data</p>
      </div>
      <div class="message-header" @click="isOpen = false" v-else>
        <p>Emiten Data</p>
      </div>
      <div class="message-body" v-show="isOpen">
        <b-field label="Sector">
          <b-select placeholder="Select a Sector"
            expanded  
            v-model="emiten.sectorID"
            @change.native="getSubSector(null)">
            <option
              v-for="option in dataSectors"
              :value="option.sectorID"
              :key="option.sectorID">
              {{ option.sectorName }}
            </option>
          </b-select>
        </b-field>
        <b-field label="Sub Sector"
          :type="errorEmiten.emitenSubSectorError ? 'is-danger': ''"
          :message="errorEmiten.emitenSubSectorError ? errorEmiten.emitenSubSectorMsg: ''"
          >
          <b-select placeholder="Select a Sub Sector"
            expanded  
            v-model="emiten.subSectorID">
            <option
              v-for="option in dataSubSectors"
              :value="option.subSectorID"
              :key="option.subSectorID">
              {{ option.subSectorName }}
            </option>
          </b-select>
        </b-field>
        <b-field label="Emiten Kode"
          :type="errorEmiten.emitenKodeError ? 'is-danger': ''"
          :message="errorEmiten.emitenKodeError ? errorEmiten.emitenKodeMsg: ''"
          >
          <b-input 
            rounded
            v-model="emiten.emitenKode"
          />
        </b-field>
        <b-field label="Emiten Name"
          :type="errorEmiten.emitenNameError ? 'is-danger': ''"
          :message="errorEmiten.emitenNameError ? errorEmiten.emitenNameMsg: ''"
          >
          <b-input 
            rounded
            v-model="emiten.emitenName"
          />
        </b-field>
        <b-field label="Emiten Amount Shares"
          :type="errorEmiten.emitenShareError ? 'is-danger': ''"
          :message="errorEmiten.emitenShareError ? errorEmiten.emitenShareMsg: ''"
          >
          <b-input rounded v-model="emiten.amountShare"></b-input>
        </b-field>
        <b-field label="Emiten Info">
          <b-input type="textarea" v-model="emiten.emitenInfo"></b-input>
        </b-field>
        <b-field label="Emiten Address">
          <b-input type="textarea" v-model="emiten.emitenAddress"></b-input>
        </b-field>
        <div class="field">
          <b-switch v-model="emiten.isBUMN">
            BUMN
          </b-switch>
        </div>
        <div class="field">
          <b-switch v-model="emiten.isAktif">
            Aktif
          </b-switch>
        </div>
        <b-button type="is-info"
          rounded
          icon-left="save"
          @click.native="saveEmiten">
          <span v-if="emiten.isCreate">
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
    name: "EmitenFormComponent",
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
                isAktif: true,
                isCreate: true
            },
            errorEmiten: {
                emitenNameError: false,
                emitenNameMsg: null,
                emitenKodeError: false,
                emitenKodeMsg: null,
                emitenShareError: false,
                emitenShareMsg: null,
                emitenSubSectorError: false,
                emitenSubSectorMsg: null
            },
            isOpen: false
        }
    },
    methods:{
      saveEmiten(){
        if(this.validate()){
          Event.$emit('isLoading', true)
          if(this.emiten.isCreate){
            this.$store.dispatch('createEmiten', this.emiten)
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
            this.$store.dispatch('updateEmiten', this.emiten)
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
          let error = 0;
          if(this.emiten.emitenName == null || this.emiten.emitenName == ''){
            this.errorEmiten.emitenNameError = true
            this.errorEmiten.emitenNameMsg = "Emiten Name Cannot Be Null"
            error++
          }else{
            this.errorEmiten.emitenNameError = false
            this.errorEmiten.emitenNameMsg = null
          }

          if(this.emiten.emitenKode == null || this.emiten.emitenKode == ''){
            this.errorEmiten.emitenKodeError = true
            this.errorEmiten.emitenKodeMsg = "Emiten Kode Cannot Be Null"
            error++
          }else{
            this.errorEmiten.emitenKodeError = false
            this.errorEmiten.emitenKodeMsg = null
          }

          if(this.emiten.subSectorID == null || this.emiten.subSectorID == ''){
            this.errorEmiten.emitenSubSectorError = true
            this.errorEmiten.emitenSubSectorMsg = "Sub Sector Cannot Be Null"
            error++
          }else{
            this.errorEmiten.emitenSubSectorError = false
            this.errorEmiten.emitenSubSectorMsg = null
          }

          
          if(this.emiten.amountShare == null || this.emiten.amountShare == ''){
            this.errorEmiten.emitenShareError = true
            this.errorEmiten.emitenShareMsg = "Emiten Amount Shares Cannot Be Null"
            error++
          }else{
            let amountShare = this.emiten.amountShare.replace(/\./g,'')
            if(isNaN(amountShare)){
              this.errorEmiten.emitenShareError = true
              this.errorEmiten.emitenShareMsg = "Emiten Amount Shares Must Be Number"
              error++
            }else{
              this.errorEmiten.emitenShareError = false
              this.errorEmiten.emitenShareMsg = null
            }
          }
          if(error > 0){
            return false
          }
          return true
      },
      clearForm(isOpen){
        this.emiten.emitenID = null
        this.emiten.emitenKode = null
        this.emiten.emitenName = null
        this.emiten.amountShare = null
        this.emiten.emitenInfo = null
        this.emiten.emitenAddress = null
        this.emiten.subSectorID = null
        this.emiten.sectorID = null
        this.emiten.isCreate = true
        this.emiten.isBUMN = false
        this.emiten.isAktif = true
        this.isOpen = isOpen
      },
      getSubSector(subSectorID = null){
        Event.$emit('isLoading', true)
        this.$store.dispatch('getSubSectorBySector', this.emiten)
        .then((respon) => {
          Event.$emit('isLoading', false)
          // this.$buefy.toast.open({
          //   message: respon,
          //   type: 'is-success'
          // })
          this.emiten.subSectorID = subSectorID
        })
        .catch((error) => {
          Event.$emit('isLoading', false)
          this.$buefy.notification.open({
            message: error,
            type: 'is-danger',
          })
        })
      }
    },
    mounted(){
      Event.$on('updateDataEmiten', (data) => {
        this.emiten.emitenID = data.emitenID
        this.emiten.emitenKode = data.emitenKode
        this.emiten.emitenName = data.emitenName
        this.emiten.amountShare = data.amountShare
        this.emiten.emitenInfo = data.emitenInfo
        this.emiten.emitenAddress = data.emitenAddress
        this.emiten.sectorID = data.sectorID
        this.emiten.isBUMN = data.isBUMN
        this.emiten.isAktif = data.isAktif == 1 ? true : false
        this.getSubSector(data.subSectorID)
        this.emiten.isCreate = data.isCreate
        this.isOpen = true
      })
    },
    created(){
      // Event.$emit('isLoading', true)
      // this.$store.dispatch('getSector')
      // .then((respon) => {
      //   Event.$emit('isLoading', false)
      //   // this.$buefy.toast.open({
      //   //     message: respon,
      //   //     type: 'is-success'
      //   // })
      // })
      // .catch((error) => {
      //   Event.$emit('isLoading', false)
      //   this.$buefy.notification.open({
      //     message: error,
      //     type: 'is-danger',
      //   })
      // })
    },
    computed:{
      // dataSectors(){
      //   return this.$store.getters.getSectorData.sort( (a,b) => {
      //     if(a.sectorName < b.sectorName){
      //       return 1
      //     }else if(a.sectorName > b.sectorName){
      //       return -1
      //     }
      //     return 0
      //   })
      // },
      // dataSubSectors(){
      //   return this.$store.getters.getSubSectorBySectorData
      // }
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
    watch:{
      'emiten.amountShare'(valueNumber){
        this.emiten.amountShare = this.$options.filters.humanReaderNumber(valueNumber)
      }
    }
}
</script>

<style>

</style>