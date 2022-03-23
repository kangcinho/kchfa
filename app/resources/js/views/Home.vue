<template>
<div class="columns is-mobile is-centered mt-10px">
  <div class="column is-four-fifths-desktop is-four-fifths-widescreen is-half-fullhd is-full-mobile is-full-tablet">
    <article class="message is-success is-large">
        <div class="message-body">
            Welcome to Kang Cin Ho Fundamentalist
        </div>
    </article>
  </div>
</div>
</template>

<script>
import Event from '../Event'
export default {
  created(){
    Event.$emit('isLoading', false)
  }
}
</script>

<style>

</style>