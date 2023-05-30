<template>
  <section class="flexRow w-100 justify-content-center align-items-center">
    <div class="w-50">
      <slot name="image"></slot>
    </div>
    <div class="w-50">
      <div>
        <slot name="message"></slot>
      </div>
    </div>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
@Options({})
export default class aboutTemplate extends Vue {}
</script>
<style scoped>
div.w-50 {
  padding: 2%;
}
@media (max-width: 750px) {
  section {
    flex-wrap: wrap;
  }
  div.w-50 {
    width: 100%;
  }
}
</style>
