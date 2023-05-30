<template>
  <div class="playerWrapper">
    <audio autoplay="true" controls="true" id="player" src=""></audio>
    <h1>{{ actualPreviewProp?.getName() }}</h1>
  </div>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Song from "./SongModel";
@Options({
  props: ["actualPreview"],
  watch: {
    actualPreview() {
      this.actualPreviewProp = this.actualPreview;
      this.startPlay();
    },
  },
  mounted() {
    this.actualPreviewProp = this.actualPreview;
    this.Player = document.querySelector("#player") as HTMLAudioElement;
    this.Player.volume = 0.05;
    this.startPlay();
  },
})
export default class PlayerComponent extends Vue {
  listSongs: [] = [];
  actualPreviewProp: Song | null = null;
  Player: HTMLAudioElement | null = null;
  currentSong = 0;
  startPlay() {
    if (this.Player == null || this.actualPreviewProp == null) return;
    this.Player.volume = 0.2;
    this.Player.src = this.actualPreviewProp.getPreview();
    // Método play não funciona, sem tempo para arrumar.
  }
}
</script>
<style scoped>
div.playerWrapper {
  background-color: var(--corAmarelo);
  width: 100%;
  padding: 1%;
}
div.playerWrapper audio {
  width: 100%;
  height: 100%;
}
h1 {
  font-size: 1.2vw;
  font-weight: 600;
  text-align: center;
  color: white;
  text-transform: uppercase;
  position: relative;
}
h1::after {
  content: "";
  width: 100%;
  height: 2px;
  position: absolute;
  background-color: white;
  top: 100%;
  left: 0;
}
@media (max-width: 1500px) {
  h1 {
    font-size: 20px;
  }
}
</style>
