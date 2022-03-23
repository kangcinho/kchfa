<template>
    <div class="column is-full container">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Quartal Name</th>
                    <th>Quartal Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dataQuartal in dataQuartals" :key="dataQuartal.quartalID">
                    <td>{{ dataQuartal.quartalName }}</td>
                    <td>{{ dataQuartal.quartalCalculate }}</td>
                    <td>
                        <b-button
                            v-if="userData.isUpdate"
                            type="is-info"
                            size="is-small"
                            icon-right="edit" 
                            title="Edit Data Quartal"
                            @click ="updateQuartal(dataQuartal)"/>
                        <b-button
                            v-if="userData.isDelete"
                            type="is-danger"
                            size="is-small"
                            icon-right="trash-alt"
                            title="Delete Data Quartal"
                            @click="deleteQuartal(dataQuartal)"/>
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
    name: "QuartalTableComponent",
    props: ['userData'],
    data(){
        return {
            quartal: {
                quartalID: null,
                quartalName: null,
                quartalCalculate: null,
                isCreate: false
            },
        }
    },
    created(){
        Event.$emit('isLoading', true)
        this.$store.dispatch('getQuartal')
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
        dataQuartals(){
            return this.$store.getters.getQuartalData
        }
    },
    methods:{
        updateQuartal(dataQuartal){
            this.quartal.quartalID = dataQuartal.quartalID
            this.quartal.quartalName = dataQuartal.quartalName
            this.quartal.quartalCalculate = dataQuartal.quartalCalculate
            this.quartal.isCreate = false
            Event.$emit('updateDataQuartal', this.quartal)
        },
        deleteQuartal(dataQuartal){
            this.$buefy.modal.open({
                parent: this,
                component: ModalKonfirmasiHapus,
                hasModalCard: true,
                props:{
                    'nama': dataQuartal.quartalName,
                    'data': dataQuartal,
                    'method': 'deleteQuartal',
                }
            })
        }
    }
}
</script>

<style>

</style>