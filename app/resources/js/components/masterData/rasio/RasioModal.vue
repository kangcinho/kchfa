<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">List Rasio {{ data.rasioName }}</p>
    </header>
    <section class="modal-card-body">
      <b-message type="is-info" has-icon>
        {{ data.note }}
      </b-message>
      <b-message type="is-info" has-icon>
        <b-taglist>
          <b-tag type="is-info" v-for="object in objectRasio" :key="object" size="is-medium">
              {{ object | deleteIsWord }}
          </b-tag>
        </b-taglist>
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