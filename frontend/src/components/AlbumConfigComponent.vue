<template>
  <h1>Albuns e previews</h1>
  <div id="albuns" class="flexRow w-100 align-items-center"></div>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
@Options({})
export default class albumComponent extends Vue {}
</script>
<style scoped>
h1 {
  font-size: 1.2vw;
  color: white;
  text-transform: uppercase;
  font-weight: 600;
  border-bottom: 2px solid white;
}
</style>
