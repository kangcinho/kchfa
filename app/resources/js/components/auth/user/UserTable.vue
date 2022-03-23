<template>
    <div class="column is-full container">
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dataUser in dataUsers" :key="dataUser.userID">
                    <td>{{ dataUser.username }}</td>
                    <td>{{ dataUser.name }}</td>
                    <td>
                        <b-button 
                            type="is-info"
                            size="is-small"
                            icon-right="edit" 
                            title="Edit Data User"
                            @click ="updateUser(dataUser)"/>
                        <b-button
                            type="is-danger"
                            size="is-small"
                            icon-right="trash-alt"
                            title="Delete Data User"
                            @click="deleteUser(dataUser)"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Event from '../../../Event'
import ModalKonfirmasiHapus from '../../masterData/modal/ModalKonfirmasiHapus'
export default {
    name: "UserTableComponent",
    data(){
        return {

        }
    },
    created(){
        Event.$emit('isLoading', true)
        this.$store.dispatch('getUser')
        .then((respon) => {
            Event.$emit('isLoading', false)
            this.$buefy.toast.open({
                message: respon,
                type: 'is-success'
            })
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
        dataUsers(){
            return this.$store.getters.getUserData
        }
    },
    methods:{
        updateUser(dataUser){
            Event.$emit('updateDataUser', dataUser)
        },
        deleteUser(dataUser){
            this.$buefy.modal.open({
                parent: this,
                component: ModalKonfirmasiHapus,
                hasModalCard: true,
                props:{
                    'nama': dataUser.username,
                    'data': dataUser,
                    'method': 'deleteUser',
                }
            })
        }
    }
}
</script>

<style>

</style>