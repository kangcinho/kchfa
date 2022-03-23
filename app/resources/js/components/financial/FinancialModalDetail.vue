<template>
  <div class="modal-card" style="width: auto" v-if="dataFinancial">
    <header class="modal-card-head">
      <p class="modal-card-title">
        <b>Rasio {{ dataFinancial.quartalName }} {{ dataFinancial.emitenKode }}</b> 
      </p>
    </header>
    <section class="modal-card-body">
      <div class="columns is-multiline">
        <div class="column is-3-fullhd is-3-widescreen is-4-desktop is-full-mobile is-6-tablet" v-for="(rasio) in dataFinancial.rasio" :key="rasio.rasioID">
          <b-message :title="rasio.rasioName" type="is-info">
            <i>{{ rasio.currencyName }}</i>
            <br/>
            <b v-if="rasio.rasioID == '191203RASIO-723316'">{{ rasio.price }}</b>
            <b v-else>{{ rasio.pricePerUnitCurrency + ' * ' + rasio.price + ' = ' }}{{ getPrice(rasio.pricePerUnitCurrency,rasio.price) }}</b>
          </b-message>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
        <b-button type="is-warning"
          rounded
          icon-left="times"
          @click="closeModal()">
          Close
        </b-button>
    </footer>
  </div>
</template>

<script>
import Event from '../../Event'
export default {
  name: 'FinancialModalDetail',
  props: ['dataFinancial'],
  methods:{
    closeModal(){
      this.$parent.close()
    },
    getPrice(priceSatuan, price){
      let satuanPrice = priceSatuan.replace(/\./g,'')
      let priceRasio = price.replace(/\./g,'')
      return this.formatMoney(priceRasio * satuanPrice)
    },
    formatMoney(amount, decimalCount = 2, decimal = ",", thousands = ".") {
      try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) ;
      } catch (e) {
        console.log(e)
      }
    }
  }
}
</script>

<style>

</style>
