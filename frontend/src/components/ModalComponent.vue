<template>
  <section id="modal" class="flexRow justify-content-center align-items-center">
    <div class="modalWrapper flexColumn">
      <registroComponent></registroComponent>
    </div>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import registroComponent from "./Modal-RegistroComponent.vue";
@Options({
  components: { registroComponent },
  mounted() {
    document.body.setAttribute("style", "overflow:hidden");
  },
})
export default class ModalComponent extends Vue {}
</script>
<style scoped>
section#modal {
  background-color: green;
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 99;
  top: 0;
  left: 0;
}
div.modalWrapper {
  background-color: var(--corPreto);
  border: 0.2vw solid var(--corBranco);
  width: 30%;
  border-radius: 1.2vw;
  overflow-y: auto;
  color: var(--corBranco);
  padding: 2%;
}
</style>
