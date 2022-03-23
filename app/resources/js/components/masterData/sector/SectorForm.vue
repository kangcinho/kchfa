<template>
  <div class="column mt-10px is-full">
      <article class="message is-primary is-normal">
          <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
              <p>Sector Data</p>
          </div>
          <div class="message-header" @click="isOpen = false" v-else>
              <p>Sector Data</p>
          </div>
          <div class="message-body" v-show="isOpen">
              <b-field label="Sector Name"
                  :type="errorSector.sectorNameError ? 'is-danger': ''"
                  :message="errorSector.sectorNameError ? errorSector.sectorNameMsg: ''"
                  >
                  <b-input 
                      rounded
                      v-model="sector.sectorName"
                      ref="sectorName"
                  />
              </b-field>
              <b-button type="is-info"  
                  rounded
                  icon-left="save"
                  @click.native="saveSector">
                  <span v-if="sector.isCreate">
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
    name: "SectorFormComponent",
    props: ['userData'],
    data(){
        return {
            sector: {
                sectorID: null,
                sectorName: null,
                isCreate: true
            },
            errorSector: {
                sectorNameError: false,
                sectorNameMsg: null,
            },
            isOpen: false
        }
    },
    methods:{
        saveSector(){
            if(this.validate()){
                Event.$emit('isLoading', true)
                if(this.sector.isCreate){
                    this.$store.dispatch('createSector', this.sector)
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
                    this.$store.dispatch('updateSector', this.sector)
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
            if(this.sector.sectorName == null || this.sector.sectorName == ''){
                this.errorSector.sectorNameError = true
                this.errorSector.sectorNameMsg = "Sector Name Cannot Be Null"
                error++
            }else{
                this.errorSector.sectorNameError = false
                this.errorSector.sectorNameMsg = null
            }
            if(error > 0){
                return false
            }
            return true
        },
        clearForm(isOpen){
            this.sector.isCreate = true
            this.sector.sectorID = null
            this.sector.sectorName = null
            this.isOpen = isOpen
        }
    },
    mounted(){
        Event.$on('updateDataSector', (data) => {
            this.sector.sectorID = data.sectorID
            this.sector.sectorName = data.sectorName
            this.sector.isCreate = data.isCreate
            this.isOpen = true
        })
    },
}
</script>

<style>

</style>