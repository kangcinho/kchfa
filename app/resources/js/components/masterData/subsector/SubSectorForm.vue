<template>
  <div class="column mt-10px is-full">
      <article class="message is-primary is-normal">
          <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
              <p>Sub Sector Data</p>
          </div>
          <div class="message-header" @click="isOpen = false" v-else>
              <p>Sub Sector Data</p>
          </div>
          <div class="message-body" v-show="isOpen">
              <b-field label="Sector"
                :type="errorSubSector.sectorNameError ? 'is-danger': ''"
                :message="errorSubSector.sectorNameError ? errorSubSector.sectorNameMsg: ''"
                >
                <b-select placeholder="Select a Sector"
                  expanded  
                  v-model="subSector.sectorID">
                  <option
                    v-for="option in dataSectors"
                    :value="option.sectorID"
                    :key="option.sectorID">
                    {{ option.sectorName }}
                  </option>
                </b-select>
              </b-field>

              <b-field label="Sub Sector Name"
                  :type="errorSubSector.subSectorNameError ? 'is-danger': ''"
                  :message="errorSubSector.subSectorNameError ? errorSubSector.subSectorNameMsg: ''"
                  >
                  <b-input 
                      rounded
                      v-model="subSector.subSectorName"
                      ref="subSectorName"
                  />
              </b-field>
              <b-button type="is-info"  
                  rounded
                  icon-left="save"
                  @click.native="saveSubSector">
                  <span v-if="subSector.isCreate">
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
  name: "SubSubSectorFormComponent",
  props: ['userData'],
  data() {
    return {
      errorSubSector: {
        subSectorNameError: false,
        subSectorNameMsg: null,
        sectorNameError: false,
        sectorNameMsg: null
      },
      subSector: {
        subSectorName: null,
        sectorID: null,
        subSectorID: null,
        isCreate: true
      },
      isOpen: false
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
  },
  computed:{
    dataSectors(){
      return this.$store.getters.getSectorData.sort( (a,b) => {
        if(a.sectorName < b.sectorName){
          return 1
        }else if(a.sectorName > b.sectorName){
          return -1
        }
        return 0
      })
    }
  },
  methods: {
    saveSubSector() {
      if(this.validate()){
        Event.$emit('isLoading', true)
        if(this.subSector.isCreate){
          this.$store.dispatch('createSubSector', this.subSector)
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
          this.$store.dispatch('updateSubSector', this.subSector)
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
      if(this.subSector.subSectorName == null || this.subSector.subSectorName == ''){
          this.errorSubSector.subSectorNameError = true
          this.errorSubSector.subSectorNameMsg = "Sub Sector Name Cannot Be Null"
          error++
      }else{
          this.errorSubSector.subSectorNameError = false
          this.errorSubSector.subSectorNameMsg = null
      }

       if(this.subSector.sectorID == null || this.subSector.sectorID == ''){
          this.errorSubSector.sectorNameError = true
          this.errorSubSector.sectorNameMsg = "Sector Name Cannot Be Null"
          error++
      }else{
          this.errorSubSector.sectorNameError = false
          this.errorSubSector.sectorNameMsg = null
      }
      if(error > 0){
          return false
      }
      return true
    },
    clearForm(isOpen){
      this.subSector.isCreate = true
      this.subSector.sectorID = null
      this.subSector.subSectorID = null
      this.subSector.subSectorName = null
      this.isOpen = isOpen
    }
  },
  mounted(){
    Event.$on('updateDataSubSector', (data) => {
      this.subSector.sectorID = data.sectorID
      this.subSector.subSectorName = data.subSectorName
      this.subSector.subSectorID = data.subSectorID
      this.subSector.isCreate = data.isCreate
      this.isOpen = true
    })
  },
}
</script>

<style>

</style>