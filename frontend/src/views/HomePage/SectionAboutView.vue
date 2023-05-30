<template>
  <section>
    <aboutTemplate>
      <template #image>
        <img src="@/assets/image-1.png" alt="" srcset="" />
      </template>
      <template #message>
        <p class="message">
          Bem-vindo ao mundo encantador da música sertaneja, onde as melodias
          tradicionais se unem às histórias do campo, transmitindo emoção e
          paixão. Nesse cenário, uma dupla conquistou corações e deixou um
          legado inesquecível: Tiao Carreiro e Pardinho. Tiao Carreiro, mestre
          da viola caipira, e Pardinho, dono de uma voz marcante, uniram seus
          talentos em 1954 e formaram uma parceria que perdurou por quase quatro
          décadas. Com uma habilidade ímpar na composição e interpretação, eles
          se tornaram pioneiros do estilo "pagode", uma vertente do sertanejo
          que trazia influências do violão e da música caipira. Ao longo de suas
          carreiras, eles brindaram o público com uma série de sucessos eternos,
          como "Adeus Mariana", "Saudade de Matão", "Cavalo Preto", "Rei do
          Gado" e "Boi Soberano". Suas letras retratavam a vida no campo, as
          agruras dos trabalhadores rurais e as belezas do interior do Brasil,
          conquistando admiradores por todo o país. Tiao Carreiro e Pardinho
          transcendem o tempo, e seu legado permanece vivo na memória e nos
          corações dos amantes da música sertaneja. Sua influência na cena
          musical é indiscutível, abrindo caminhos para gerações posteriores de
          artistas e provando que a música caipira tem um lugar especial na
          cultura brasileira.
        </p>
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
export default class SectionAbout extends Vue {}
</script>
<style scoped>
section {
  background: rgb(20, 33, 61);
  background: linear-gradient(90deg, var(--corAzul) 50%, rgb(0, 0, 0) 50%);
}
p.message {
  color: white;
  font-weight: 600;
  line-height: 1.7vw;
  letter-spacing: 0.1vw;
  font-size: 1.2vw;
}
img {
  width: 100%;
  height: auto;
  object-fit: contain;
  border: 0.5vw solid var(--corBranco);
  min-height: 300px;
}
@media (max-width: 1500px) {
  p.message {
    font-weight: 600;
    line-height: 20px;
    letter-spacing: 2px;
    font-size: 18px;
  }
  img {
    border: 10px solid var(--corBranco);
  }
}
@media (max-width: 750px) {
  section {
    background: rgb(20, 33, 61);
    background: linear-gradient(180deg, var(--corAzul) 55%, rgb(0, 0, 0) 45%);
  }
}
@media (max-width: 675px) {
  section {
    background: rgb(20, 33, 61);
    background: linear-gradient(180deg, var(--corAzul) 50%, rgb(0, 0, 0) 50%);
  }
}
@media (max-width: 604px) {
  section {
    background: rgb(0, 0, 0);
    background: linear-gradient(
      180deg,
      var(--corAzul) 40%,
      rgba(0, 0, 0, 1) 40%
    );
  }
}
@media (max-width: 490px) {
  section {
    background: rgb(0, 0, 0);
    background: linear-gradient(
      180deg,
      var(--corAzul) 30%,
      rgba(0, 0, 0, 1) 30%
    );
  }
}
@media (max-width: 400px) {
  section {
    background: rgb(0, 0, 0);
    background: linear-gradient(
      180deg,
      var(--corAzul) 10%,
      rgba(0, 0, 0, 1) 10%
    );
  }
}
@media (max-width: 210px) {
  section {
    background: rgb(0, 0, 0);
    background: linear-gradient(180deg, var(--corAzul) 5%, rgba(0, 0, 0, 1) 5%);
  }
}
@media (max-width: 145px) {
  section {
    background: rgb(0, 0, 0);
    background: linear-gradient(180deg, var(--corAzul) 0%, rgba(0, 0, 0, 1) 0%);
  }
}
</style>
