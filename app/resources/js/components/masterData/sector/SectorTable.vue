<template>
    <div class="column is-full container">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Sector Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dataSector in dataSectors" :key="dataSector.sectorID">
                    <td>{{ dataSector.sectorName }}</td>
                    <td>
                        <b-button 
                            v-if="userData.isUpdate"
                            type="is-info"
                            size="is-small"
                            icon-right="edit" 
                            title="Edit Data Sector"
                            @click ="updateSector(dataSector)"/>
                        <b-button
                            v-if="userData.isDelete"
                            type="is-danger"
                            size="is-small"
                            icon-right="trash-alt"
                            title="Delete Data Sector"
                            @click="deleteSector(dataSector)"/>
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
    name: "SectorTableComponent",
    props: ['userData'],
    data(){
        return {
            sector: {
                sectorID: null,
                sectorName: null,
                isCreate: false
            },
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
            return this.$store.getters.getSectorData
        }
    },
    methods:{
        updateSector(dataSector){
            this.sector.sectorID = dataSector.sectorID
            this.sector.sectorName = dataSector.sectorName
            this.sector.isCreate = false
            Event.$emit('updateDataSector', this.sector)
        },
        deleteSector(dataSector){
            this.$buefy.modal.open({
                parent: this,
                component: ModalKonfirmasiHapus,
                hasModalCard: true,
                props:{
                    'nama': dataSector.sectorName,
                    'data': dataSector,
                    'method': 'deleteSector',
                }
            })
        }
    }
}
</script>

<style>

</style>