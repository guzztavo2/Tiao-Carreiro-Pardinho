<template>
  <main class="w-100 flexRow justify-content-center align-items-center">
    <div class="title-wrapper w-50">
      <h1>
        O Legado Imortal de Tião Carreiro e Pardinho:<br />
        A Dupla que Encantou a Música Sertaneja Brasileira
      </h1>
    </div>
    <div class="image-wrapper w-50">
      <img src="@/assets/main-image.png" alt="" srcset="" />
    </div>
  </main>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
@Options({})
export default class MainSection extends Vue {}
</script>
<style scoped>
main {
  background-color: var(--corAmarelo);
}
.title-wrapper h1 {
  padding: 2%;
  font-size: 1.7vw;
  font-weight: 900;
  text-transform: uppercase;
  white-space: pre-wrap;
  text-shadow: 0 0 0.1vw var(--corBranco), 0 0 0.1vw var(--corBranco);
}
.image-wrapper img {
  width: 80%;
  padding: 5%;
  object-fit: contain;
  transition: ease-in-out 0.2s;
  min-height: 300px;
}
.image-wrapper > img:hover {
  transform: scale(102%);
}
@media (max-width: 1500px) {
  .title-wrapper h1 {
    padding: 4%;
    font-size: 30px;
    font-weight: 900;
    text-transform: uppercase;
    white-space: pre-wrap;
    text-shadow: 0 0 2px var(--corBranco), 0 0 2px var(--corBranco);
  }
}
@media (max-width: 700px) {
  .w-50 {
    width: 100%;
  }
  .flexRow {
    flex-flow: row wrap;
  }
  div.image-wrapper,
  div.title-wrapper {
    width: 100%;
    text-align: center;
  }
}
</style>
