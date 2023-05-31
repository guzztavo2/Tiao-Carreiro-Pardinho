<template>
  <section
    ref="section"
    @click="compClick"
    id="messageBox"
    class="flexColumn align-items-center justify-content-center"
  >
    <div class="message-wrapper flexColumn">
      <h1 class="title flexRow justify-content-between">
        <span v-text="Title"></span>
        <i ref="closeBtn" class="fa-regular fa-circle-xmark"></i>
      </h1>

      <h1 class="message">
        <span v-text="Message"></span>
      </h1>
    </div>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
@Options({
  created() {
    this.Message = this.$props.message;
    this.Title = this.$props.title;
  },
  props: {
    title: {
      type: String,
      require: true,
    },
    message: {
      type: String,
      require: true,
    },
  },
  emits: ["setVisible"],
})
export default class messageComponent extends Vue {
  Message!: string;
  Title!: string;
  compClick(event: Event) {
    if (
      event.target !== this.$refs.section &&
      event.target !== this.$refs.closeBtn
    )
      return;
    this.$emit("setVisible", false, true);
  }
}
</script>
<style scoped>
section#messageBox {
  width: 100%;
  height: 100%;
  position: fixed;
  overflow: auto;
  min-height: 400px;
  top: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.568);
}
div.message-wrapper {
  width: 50%;
  height: 40%;
  min-height: 400px;
  border: 4px solid var(--corAmarelo);
}

h1.title {
  background-color: var(--corAmarelo);
  font-size: 1.2vw;
  padding: 1%;
  font-weight: 600;
  border-bottom: 0.1vw solid black;
}
h1.title > i {
  cursor: pointer;
  color: var(--corPreto);
}
h1.title > i:hover {
  color: var(--corBranco);
}
h1.message {
  font-size: 1vw;
  height: 90%;
  padding: 1%;
  text-align: center;
  overflow: auto;
  background-color: var(--corBranco);
}
@media (max-width: 1500px) {
  h1.title {
    font-size: 22px;
    border-bottom: 2px solid black;
    padding: 2% 3%;
  }
  h1.message {
    font-size: 20px;
  }
  h1.title i {
    font-size: 40px;
  }
}
@media (max-width: 750px) {
  div.message-wrapper {
    width: 80%;
  }
}
@media (max-width: 450px) {
  div.message-wrapper {
    width: 98%;
  }
}
</style>
