<template>
  <div class="column mt-10px is-full">
      <article class="message is-primary is-normal">
          <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
              <p>Year Data</p>
          </div>
          <div class="message-header" @click="isOpen = false" v-else>
              <p>Year Data</p>
          </div>
          <div class="message-body" v-show="isOpen">
              <b-field label="Year Name"
                  :type="errorYear.yearNameError ? 'is-danger': ''"
                  :message="errorYear.yearNameError ? errorYear.yearNameMsg: ''"
                  >
                  <b-input 
                      rounded
                      v-model="year.yearName"
                      ref="yearName"
                  />
              </b-field>
              <b-button type="is-info"  
                  rounded
                  icon-left="save"
                  @click.native="saveYear">
                  <span v-if="year.isCreate">
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
    name: "YearFormComponent",
    props: ['userData'],
    data(){
        return {
            year: {
                yearID: null,
                yearName: null,
                isCreate: true
            },
            errorYear: {
                yearNameError: false,
                yearNameMsg: null,
            },
            isOpen: false
        }
    },
    methods:{
        saveYear(){
            if(this.validate()){
                Event.$emit('isLoading', true)
                if(this.year.isCreate){
                    this.$store.dispatch('createYear', this.year)
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
                    this.$store.dispatch('updateYear', this.year)
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
            if(this.year.yearName == null || this.year.yearName == ''){
                this.errorYear.yearNameError = true
                this.errorYear.yearNameMsg = "Year Name Cannot Be Null"
                error++
            }else{
                this.errorYear.yearNameError = false
                this.errorYear.yearNameMsg = null
            }
            if(error > 0){
                return false
            }
            return true
        },
        clearForm(isOpen){
            this.year.isCreate = true
            this.year.yearID = null
            this.year.yearName = null
            this.isOpen = isOpen
        }
    },
    mounted(){
        Event.$on('updateDataYear', (data) => {
            this.year.yearID = data.yearID
            this.year.yearName = data.yearName
            this.year.isCreate = data.isCreate
            this.isOpen = true
        })
    },
}
</script>

<style>

</style>