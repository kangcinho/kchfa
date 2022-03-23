<template>
    <div class="column is-full container">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Currency Name</th>
                    <th>Currency Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dataCurrency in dataCurrencies" :key="dataCurrency.currencyID">
                    <td>{{ dataCurrency.currencyName }}</td>
                    <td>{{ dataCurrency.currencyCountry }}</td>
                    <td>
                        <b-button
                            v-if="userData.isUpdate"
                            type="is-info"
                            size="is-small"
                            icon-right="edit" 
                            title="Edit Data Currency"
                            @click ="updateCurrency(dataCurrency)"/>
                        <b-button
                            v-if="userData.isDelete"
                            type="is-danger"
                            size="is-small"
                            icon-right="trash-alt"
                            title="Delete Data Currency"
                            @click="deleteCurrency(dataCurrency)"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Event from '../../../Event'
import ModalKonfirmasiHapus from '../modal/ModalKonfirmasiHapus'
export default {
    name: "CurrencyTableComponent",
    props: ['userData'],
    data(){
        return {
            currency: {
                currencyID: null,
                currencyName: null,
                currencyCountry: null,
                isCreate: false
            },
        }
    },
    created(){
        Event.$emit('isLoading', true)
        this.$store.dispatch('getCurrency')
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
        dataCurrencies(){
            return this.$store.getters.getCurrencyData
        }
    },
    methods:{
        updateCurrency(dataCurrency){
            this.currency.currencyID = dataCurrency.currencyID
            this.currency.currencyName = dataCurrency.currencyName
            this.currency.currencyCountry = dataCurrency.currencyCountry
            this.currency.isCreate = false
            Event.$emit('updateDataCurrency', this.currency)
        },
        deleteCurrency(dataCurrency){
            this.$buefy.modal.open({
                parent: this,
                component: ModalKonfirmasiHapus,
                hasModalCard: true,
                props:{
                    'nama': dataCurrency.currencyName,
                    'data': dataCurrency,
                    'method': 'deleteCurrency',
                }
            })
        }
    }
}
</script>

<style>

</style>