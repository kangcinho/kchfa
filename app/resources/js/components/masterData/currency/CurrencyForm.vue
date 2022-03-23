<template>
    <div class="column mt-10px is-full">
        <article class="message is-primary is-normal">
            <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true" v-if="userData.isCreate">
                <p>Currency Data</p>
            </div>
            <div class="message-header" @click="isOpen = false" v-else>
                <p>Currency Data</p>
            </div>
            <div class="message-body" v-show="isOpen">
                <b-field label="Currency Name"
                    :type="errorCurrency.currencyNameError ? 'is-danger': ''"
                    :message="errorCurrency.currencyNameError ? errorCurrency.currencyNameMsg: ''"
                    >
                    <b-input 
                        rounded
                        v-model="currency.currencyName"
                        ref="currencyName"
                    />
                </b-field>
                <b-field label="Currency Country"
                    :type="errorCurrency.currencyCountryError ? 'is-danger': ''"
                    :message="errorCurrency.currencyCountryError ? errorCurrency.currencyCountryMsg: ''"
                    >
                    <b-input rounded v-model="currency.currencyCountry"></b-input>
                </b-field>
                <b-button type="is-info"  
                    rounded
                    icon-left="save"
                    @click.native="saveCurrency">
                    <span v-if="currency.isCreate">
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
    name: "CurrencyFormComponent",
    props: ['userData'],
    data(){
        return {
            currency: {
                currencyID: null,
                currencyName: null,
                currencyCountry: null,
                isCreate: true
            },
            errorCurrency: {
                currencyNameError: false,
                currencyNameMsg: null,
                currencyCountryError: false,
                currencyCountryMsg: null
            },
            isOpen: false
        }
    },
    methods:{
        saveCurrency(){
            if(this.validate()){
                Event.$emit('isLoading', true)
                if(this.currency.isCreate){
                    this.$store.dispatch('createCurrency', this.currency)
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
                    this.$store.dispatch('updateCurrency', this.currency)
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
            if(this.currency.currencyName == null || this.currency.currencyName == ''){
                this.errorCurrency.currencyNameError = true
                this.errorCurrency.currencyNameMsg = "Currency Name Cannot Be Null"
                error++
            }else{
                this.errorCurrency.currencyNameError = false
                this.errorCurrency.currencyNameMsg = null
            }

            if(this.currency.currencyCountry == null || this.currency.currencyCountry == ''){
                this.errorCurrency.currencyCountryError = true
                this.errorCurrency.currencyCountryMsg = "Currency Country Cannot Be Null"
                error++
            }else{
                this.errorCurrency.currencyCountryError = false
                this.errorCurrency.currencyCountryMsg = null
            }

            if(error > 0){
                return false
            }
            return true
        },
        clearForm(isOpen){
            this.currency.isCreate = true
            this.currency.currencyID = null
            this.currency.currencyName = null
            this.currency.currencyCountry = null
            this.isOpen = isOpen
        }
    },
    mounted(){
        Event.$on('updateDataCurrency', (data) => {
            this.currency.currencyID = data.currencyID
            this.currency.currencyName = data.currencyName
            this.currency.currencyCountry = data.currencyCountry
            this.currency.isCreate = data.isCreate
            this.isOpen = true
        })
    },
}
</script>

<style>

</style>