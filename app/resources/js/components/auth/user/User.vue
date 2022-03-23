<template>
  <div class="columns is-centered is-multiline">
    <UserForm/>
    <UserTable/>
  </div>
</template>

<script>
import UserForm from './UserForm'
import UserTable from './UserTable'

export default {
  name: "UserMasterComponent",
  components:{
    UserForm,
    UserTable
  }
}
</script>

<style>

</style>