<template>
    <div class="column mt-10px is-full">
        <article class="message is-primary is-normal">
            <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
                <p>Quartal Data</p>
            </div>
            <div class="message-header" @click="isOpen = false" v-else>
                <p>Quartal Data</p>
            </div>
            <div class="message-body" v-show="isOpen">
                <b-field label="Quartal Name"
                    :type="errorQuartal.quartalNameError ? 'is-danger': ''"
                    :message="errorQuartal.quartalNameError ? errorQuartal.quartalNameMsg: ''"
                    >
                    <b-input 
                        rounded
                        v-model="quartal.quartalName"
                        ref="quartalName"
                    />
                </b-field>
                <b-field label="Quartal Calculate"
                    :type="errorQuartal.quartalCalculateError ? 'is-danger': ''"
                    :message="errorQuartal.quartalCalculateError ? errorQuartal.quartalCalculateMsg: ''"
                    >
                    <b-input rounded v-model="quartal.quartalCalculate"></b-input>
                </b-field>
                <b-button type="is-info"  
                    rounded
                    icon-left="save"
                    @click.native="saveQuartal">
                    <span v-if="quartal.isCreate">
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
    name: "QuartalFormComponent",
    props: ['userData'],
    data(){
        return {
            quartal: {
                quartalID: null,
                quartalName: null,
                quartalCalculate: null,
                isCreate: true
            },
            errorQuartal: {
                quartalNameError: false,
                quartalNameMsg: null,
                quartalCalculateError: false,
                quartalCalculateMsg: null
            },
            isOpen: false
        }
    },
    methods:{
        saveQuartal(){
            if(this.validate()){
                Event.$emit('isLoading', true)
                if(this.quartal.isCreate){
                    this.$store.dispatch('createQuartal', this.quartal)
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
                    this.$store.dispatch('updateQuartal', this.quartal)
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
            if(this.quartal.quartalName == null || this.quartal.quartalName == ''){
                this.errorQuartal.quartalNameError = true
                this.errorQuartal.quartalNameMsg = "Quartal Name Cannot Be Null"
                error++
            }else{
                this.errorQuartal.quartalNameError = false
                this.errorQuartal.quartalNameMsg = null
            }

            if(this.quartal.quartalCalculate == null || this.quartal.quartalCalculate == ''){
                this.errorQuartal.quartalCalculateError = true
                this.errorQuartal.quartalCalculateMsg = "Quartal Calculate Cannot Be Null"
                error++
            }else{
                this.errorQuartal.quartalCalculateError = false
                this.errorQuartal.quartalCalculateMsg = null
            }

            if(error > 0){
                return false
            }
            return true
        },
        clearForm(isOpen){
            this.quartal.isCreate = true
            this.quartal.quartalID = null
            this.quartal.quartalName = null
            this.quartal.quartalCalculate = null
            this.isOpen = isOpen
        }
    },
    mounted(){
        Event.$on('updateDataQuartal', (data) => {
            this.quartal.quartalID = data.quartalID
            this.quartal.quartalName = data.quartalName
            this.quartal.quartalCalculate = data.quartalCalculate
            this.quartal.isCreate = data.isCreate
            this.isOpen = true
        })
    },
}
</script>

<style>

</style>