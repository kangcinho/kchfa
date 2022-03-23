<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title"><b>{{ data.emitenName }}</b></p>
    </header>
    <section class="modal-card-body">
      <b-message :title="'Info '+ data.emitenName" has-icon type="is-info">
        {{ data.emitenInfo }}
      </b-message>
      
      <b-message :title="'Alamat '+ data.emitenName" has-icon type="is-info" icon='trash'>
        {{ data.emitenAddress }}
      </b-message>
      
      <b-message :title="'Sector '+ data.emitenName" has-icon type="is-info" icon='trash'>
        {{ data.sectorName }} - {{ data.subSectorName }}
      </b-message>
    </section>
    <footer class="modal-card-foot">
        <button class="button" type="button" @click="closeModal()">Batal</button>
    </footer>
  </div>
</template>

<script>
export default {
  name:"RasioModalComponent",
  props:['data'],
  methods:{
    closeModal(){
      this.$parent.close()
    },
  },
  computed:{
    objectRasio(){
      const object = Object.keys(this.data)
      return object.filter( (dataObject) => {
        if(this.data[dataObject] == true){
          return true;
        }
      })
    }
  },
  filters:{
    deleteIsWord(rasioField){
      return rasioField.replace('is', '')
    }
  }
}
</script>

<style>

</style>