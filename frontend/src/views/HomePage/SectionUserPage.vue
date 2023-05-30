<template>
  <section>
    <albumComponent></albumComponent>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import albumComponent from "@/components/AlbumConfigComponent.vue";
@Options({
  components: { albumComponent },
})
export default class UserPage extends Vue {}
</script>
<style scoped>
section {
  background-color: var(--corAzul);
  width: 100%;
  height: 100%;
  overflow: auto;
  padding: 1%;
}
h1 {
  font-size: 1.2vw;
  color: white;
  text-transform: uppercase;
  font-weight: 600;
  border-bottom: 2px solid white;
}
</style>
