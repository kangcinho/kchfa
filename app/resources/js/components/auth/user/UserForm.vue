<template>
    <div class="column mt-10px is-full">
        <article class="message is-primary is-normal">
            <div class="message-header" @click="isOpen ? isOpen = false: isOpen = true">
                <p>User Data</p>
            </div>
            <div class="message-body" v-show="isOpen">
                <b-field label="Username"
                    :type="errorUser.usernameError ? 'is-danger': ''"
                    :message="errorUser.usernameError ? errorUser.usernameMsg : ''"    
                >
                    <b-input 
                        rounded
                        v-model="user.username"
                    />
                </b-field>
                <b-field label="Name User"
                    :type="errorUser.nameError ? 'is-danger': ''"
                    :message="errorUser.nameError ? errorUser.nameMsg : ''"
                >
                    <b-input rounded v-model="user.name"></b-input>
                </b-field>
                <b-field label="Password"
                    :type="errorUser.passwordError ? 'is-danger': ''"
                    :message="errorUser.passwordError ? errorUser.passwordMsg : ''"
                >
                    <b-input rounded v-model="user.password" type="password" password-reveal=""></b-input>
                </b-field>
                <b-field grouped>
                    <div class="field">
                        <b-switch v-model="user.isAdmin">
                            Admin
                        </b-switch>
                    </div>
                    <div class="field">
                        <b-switch v-model="user.isMaster">
                            Master Data
                        </b-switch>
                    </div>
                    <div class="field">
                        <b-switch v-model="user.isFA">
                            Finance Statement
                        </b-switch>
                    </div>
                    <div class="field">
                        <b-switch v-model="user.isCreate">
                            Create
                        </b-switch>
                    </div>
                    <div class="field">
                        <b-switch v-model="user.isUpdate">
                            Update
                        </b-switch>
                    </div>
                    <div class="field">
                        <b-switch v-model="user.isDelete">
                            Delete
                        </b-switch>
                    </div>
                </b-field>
                <b-button type="is-info"
                    rounded
                    icon-left="save"
                    @click="saveUser">
                    <span v-if="user.isCreateMode">
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
    name: "UserFormComponent",
    data(){
        return {
            user: {
                userID: null,
                username: null,
                name: null,
                password: null,
                isAdmin: false,
                isMaster: false,
                isFA: false,
                isCreate: false,
                isUpdate: false,
                isDelete: false,
                isCreateMode: true
            },
            errorUser: {
                usernameError: false,
                usernameMsg: null,
                nameError: false,
                nameMsg: null,
                passwordError: false,
                passwordMsg: null,
            },
            isOpen: false
        }
    },
    methods:{
        saveUser(){
            if(this.validate()){
                Event.$emit('isLoading', true)
                if(this.user.isCreateMode){
                    this.$store.dispatch('createUser', this.user)
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
                    this.$store.dispatch('updateUser', this.user)
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
            if(this.user.username == '' || this.user.username == null || this.user.username =='null'){
                this.errorUser.usernameError = true
                this.errorUser.usernameMsg = "Username Cannot Be Null"
                error++
            }else{
                this.errorUser.usernameError = false
                this.errorUser.usernameMsg = null
            }
            
            if(this.user.name == '' || this.user.name == null || this.user.name =='null'){
                this.errorUser.nameError = true
                this.errorUser.nameMsg = "Name Cannot Be Null"
                error++
            }else{
                this.errorUser.nameError = false
                this.errorUser.nameMsg = null
            }
            if(this.user.isCreateMode){
                if(this.user.password == '' || this.user.password == null || this.user.password =='null'){
                    this.errorUser.passwordError = true
                    this.errorUser.passwordMsg = "Password Cannot Be Null"
                    error++
                }else{
                    this.errorUser.passwordError = false
                    this.errorUser.passwordMsg = null
                }
            }
            
            if(error > 0){
                return false
            }
            return true
        },
        clearForm(isOpen){
            this.user.isCreateMode = true
            this.user.userID = null
            this.user.username = null
            this.user.name = null
            this.user.password = null
            this.user.isAdmin = false
            this.user.isMaster = false
            this.user.isFA = false
            this.user.isCreate = false
            this.user.isUpdate = false
            this.user.isDelete = false
            this.isOpen = isOpen
        }
    },
    mounted(){
        Event.$on('updateDataUser', (data) => {
            this.user.isCreateMode = false
            this.user.userID = data.userID
            this.user.username = data.username
            this.user.name = data.name
            this.user.password = data.password
            this.user.isAdmin = data.isAdmin
            this.user.isMaster = data.isMaster
            this.user.isFA = data.isFA
            this.user.isCreate = data.isCreate
            this.user.isUpdate = data.isUpdate
            this.user.isDelete = data.isDelete
            this.isOpen = true
        })
    },
}
</script>

<style>

</style>