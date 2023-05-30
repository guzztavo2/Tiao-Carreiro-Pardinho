<template>
  <section>
    <aboutTemplate>
      <template #image>
        <p class="message">
          Uma viagem pela trajetória desses ícones, compartilhando histórias
          fascinantes, curiosidades e, é claro, suas músicas atemporais. Explore
          a discografia completa, assista a vídeos emocionantes de suas
          apresentações e mergulhe na riqueza da herança deixada por essa dupla
          extraordinária. Seja você um fã de longa data ou esteja descobrindo a
          magia de Tiao Carreiro e Pardinho agora, junte-se a nós nessa jornada
          musical. Celebre a vida no campo, desfrute das melodias cativantes e
          deixe-se envolver pela emoção transmitida por esses mestres da música
          sertaneja. Prepare-se para uma experiência única e emocionante. Tiao
          Carreiro e Pardinho: a lenda da música sertaneja que vive em cada
          acorde, em cada verso e em cada coração que se rende ao encanto dessa
          dupla inesquecível.
        </p>
      </template>
      <template #message>
        <img src="@/assets/image-2.png" alt="" srcset="" />
      </template>
    </aboutTemplate>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import aboutTemplate from "@/components/AboutTemplate.vue";
@Options({
  components: { aboutTemplate },
})
export default class SectionAbout2 extends Vue {}
</script>
<style scoped>
section {
  background: rgb(20, 33, 61);
  background: linear-gradient(
    90deg,
    rgb(255, 255, 255) 50%,
    var(--corAmarelo) 50%
  );
}
p.message {
  color: black;
  font-weight: 600;
  line-height: 1.7vw;
  letter-spacing: 0.1vw;
  font-size: 1.2vw;
}
img {
  width: 100%;
  height: auto;
  object-fit: contain;
  border: 0.5vw solid var(--corAzul);
  min-height: 300px;
}
@media (max-width: 1500px) {
  p.message {
    line-height: 20px;
    letter-spacing: 2px;
    font-size: 18px;
  }
  img {
    border: 10px solid var(--corAzul);
  }
}
@media (max-width: 750px) {
  section {
    background: rgb(20, 33, 61);
    background: linear-gradient(
      180deg,
      rgb(255, 255, 255) 55%,
      var(--corAmarelo) 45%
    );
    background-color: red;
  }
}
@media (max-width: 675px) {
  section {
    background: rgb(20, 33, 61);
    background: linear-gradient(
      180deg,
      rgb(255, 255, 255) 50%,
      var(--corAmarelo) 50%
    );
  }
}
@media (max-width: 604px) {
  section {
    background: var(--corAmarelo);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 1) 50%,
      var(--corAmarelo) 50%
    );
  }
}
@media (max-width: 490px) {
  section {
    background: var(--corAmarelo);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 1) 60%,
      var(--corAmarelo) 60%
    );
  }
}
@media (max-width: 400px) {
  section {
    background: var(--corAmarelo);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 1) 85%,
      var(--corAmarelo) 85%
    );
  }
}
@media (max-width: 210px) {
  section {
    background: var(--corAmarelo);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 1) 90%,
      var(--corAmarelo) 90%
    );
  }
}
@media (max-width: 145px) {
  section {
    background: var(--corAmarelo);
    background: linear-gradient(
      180deg,
      rgba(255, 255, 255, 1) 99%,
      var(--corAmarelo) 99%
    );
  }
}
</style>
