<template>
    <div class="column is-full container">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Year Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dataYear in dataYears" :key="dataYear.yearID">
                    <td>{{ dataYear.yearName }}</td>
                    <td>
                        <b-button
                            v-if="userData.isUpdate"
                            type="is-info"
                            size="is-small"
                            icon-right="edit" 
                            title="Edit Data Year"
                            @click ="updateYear(dataYear)"/>
                        <b-button
                            v-if="userData.isDelete"
                            type="is-danger"
                            size="is-small"
                            icon-right="trash-alt"
                            title="Delete Data Year"
                            @click="deleteYear(dataYear)"/>
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
    name: "YearTableComponent",
    props: ['userData'],
    data(){
        return {
            year: {
                yearID: null,
                yearName: null,
                isCreate: false
            },
        }
    },
    created(){
        Event.$emit('isLoading', true)
        this.$store.dispatch('getYear')
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
        dataYears(){
            return this.$store.getters.getYearData
        }
    },
    methods:{
        updateYear(dataYear){
            this.year.yearID = dataYear.yearID
            this.year.yearName = dataYear.yearName
            this.year.isCreate = false
            Event.$emit('updateDataYear', this.year)
        },
        deleteYear(dataYear){
            this.$buefy.modal.open({
                parent: this,
                component: ModalKonfirmasiHapus,
                hasModalCard: true,
                props:{
                    'nama': dataYear.yearName,
                    'data': dataYear,
                    'method': 'deleteYear',
                }
            })
        }
    }
}
</script>

<style>

</style>