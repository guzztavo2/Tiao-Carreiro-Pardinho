<template>
  <div class="playerWrapper">
    <div class="player flexColumn">
      <div class="wrapper-progress">
        <input
          ref="progressMusic"
          step="33.3"
          min="0"
          max="100"
          type="range"
          name=""
          id=""
        />
        <div ref="progressElement" class="progress-element"></div>
      </div>
      <div class="music-detail-wrapper w-100 flexRow justify-content-between">
        <div class="name-wrapper">
          <h1>{{ actualPreviewProp?.getName() }}</h1>
        </div>
        <div class="time-wrapper">
          <h1 v-if="playerDuration !== null && playerCurrentTime !== null">
            {{ TimeToString(playerCurrentTime) }} |
            {{ TimeToString(playerDuration) }}
          </h1>
        </div>
      </div>
      <div
        class="music_config flexRow justify-content-center align-items-center"
      >
        <div class="back_wrapper" @click="$emit('prevSong')">
          <i class="fa-solid fa-backward-step"></i>
        </div>
        <div @click="startPauseMusic" v-if="!isPlay" class="play_wrapper">
          <i class="fa-solid fa-play"></i>
        </div>
        <div @click="startPauseMusic" v-else-if="isPlay" class="pause_wrapper">
          <i class="fa-solid fa-pause"></i>
        </div>
        <div class="next_wrapper" @click="$emit('nextSong')">
          <i class="fa-solid fa-forward-step"></i>
        </div>
        <div class="volume_wrapper" @click="changeVolumeValue">
          <div class="progress_volume_wrapper flexColumn align-items-center">
            <input
              type="range"
              ref="volumeElement"
              min="0"
              step="0.1"
              max="1"
              name=""
              id=""
              orient="vertical"
              @input="setVolume"
            />
            <h1>{{ volumeValue }}</h1>
          </div>
          <i class="fa-solid fa-volume-xmark" v-if="volumeValue == 0"></i>
          <i
            class="fa-solid fa-volume-low"
            v-else-if="volumeValue > 0 && volumeValue < 60"
          ></i>
          <i class="fa-solid fa-volume-high" v-else-if="volumeValue >= 60"></i>
        </div>
      </div>
    </div>
    <audio
      style="display: none; opacity: 0"
      preload="metadata"
      ref="player"
      autoplay="true"
      controls="true"
      src=""
    ></audio>
  </div>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Song from "./SongModel";
@Options({
  props: ["actualPreview"],
  emits: ["nextSong", "prevSong"],
  data() {
    return {
      playerCurrentTime: {
        type: Date,
      },
      isPlay: {
        type: Boolean,
      },
    };
  },
  watch: {
    actualPreview() {
      this.actualPreviewProp = this.actualPreview;
      this.Player = this.$refs.player as HTMLAudioElement;
      this.Player.volume = 0.05;

      this.progressMusic = this.$refs.progressMusic as HTMLInputElement;
      this.startPlay();
    },
  },
  mounted() {
    this.actualPreviewProp = this.actualPreview;
    this.Player = this.$refs.player as HTMLAudioElement;
    this.Player.volume = 0.05;

    this.progressMusic = this.$refs.progressMusic as HTMLInputElement;
    this.startPlay();
  },
})
export default class PlayerComponent extends Vue {
  listSongs: [] = [];
  volumeValue = 100;
  actualPreviewProp: Song | null = null;
  Player: HTMLAudioElement | null = null;
  currentSong = 0;
  isPlay = true;
  progressMusic: HTMLInputElement | null = null;
  currentIntervalLooping!: number;
  playerCurrentTime: Date | null = null;
  playerDuration: Date | null = null;
  setVolume() {
    this.volumeValue =
      Number((this.$refs.volumeElement as HTMLInputElement).value) * 100;
    (this.Player as HTMLAudioElement).volume = Number(
      (this.$refs.volumeElement as HTMLInputElement).value
    );
  }
  changeVolumeValue(event: Event) {
    if (event.target == this.$refs.volumeElement) return;
    if (this.volumeValue == 100) this.volumeValue = 0;
    else if (this.volumeValue == 0) this.volumeValue = 50;
    else this.volumeValue = 100;

    (this.$refs.volumeElement as HTMLInputElement).value = (
      this.volumeValue / 100
    ).toString();
    this.setVolume();
  }
  setWidthProgress() {
    if (this.progressMusic == null) return;
    if (
      (this.$refs.progressElement as HTMLElement).getAttribute("style") ==
      "width:99.5%"
    ) {
      (this.$refs.progressElement as HTMLElement).setAttribute(
        "style",
        "width:" +
          Math.round(Number.parseInt(this.progressMusic.value)) +
          "100%"
      );
      return;
    }
    (this.$refs.progressElement as HTMLElement).setAttribute(
      "style",
      "width:" + Math.round(Number.parseInt(this.progressMusic.value)) + ".5%"
    );
  }
  TimeToString(time: Date | undefined): string {
    const charVerify = (time: string) => {
      if (time.length == 1) return "0" + time;
      return time;
    };
    if (time == undefined) return "00:00";
    else {
      time = new Date(time);
      if (time.toString() == "Invalid Date") return "00:00";
      const minute = charVerify(time.getMinutes().toString());
      const seconds = charVerify(time.getSeconds().toString());
      return minute + ":" + seconds;
    }
  }
  setTimerSeconds(seconds: number): Date {
    return new Date(0, 0, 0, 0, 0, seconds);
  }
  MusicLoop() {
    this.playerCurrentTime = this.setTimerSeconds(
      this.Player?.currentTime as number
    );
    if (this.progressMusic == null) return;
    if (this.progressMusic.value >= "99") this.pauseMusic();
    const posicaoAtual =
      this.Player !== null ? this.Player.currentTime : undefined;
    if (posicaoAtual == undefined) return;
    const porcentagemAtual =
      (posicaoAtual / (this.Player as HTMLAudioElement).duration) * 100;
    this.progressMusic.value = porcentagemAtual.toString();
    this.setWidthProgress();
  }
  startPlay() {
    if (this.Player == null || this.actualPreviewProp == null) return;
    this.Player.volume = 0.2;
    this.Player.src = this.actualPreviewProp.getPreview();
    this.Player.load();
    this.Player.onloadedmetadata = () => {
      if (this.Player == null || this.progressMusic == undefined) return;
      this.setProgress();
      this.playerDuration = this.setTimerSeconds(
        Math.round(this.Player.duration) - 1
      );
      this.isPlay = true;
      this.currentIntervalLooping = setInterval(this.MusicLoop, 1);
    };
  }
  startPauseMusic() {
    if (this.isPlay) this.pauseMusic();
    else this.playMusic();
  }
  pauseMusic() {
    this.Player?.pause();
    if (this.currentIntervalLooping !== undefined)
      clearInterval(this.currentIntervalLooping);
    this.isPlay = false;
  }
  playMusic() {
    this.Player?.play();
    this.currentIntervalLooping = setInterval(this.MusicLoop, 1);
    this.isPlay = true;
  }
  setProgress() {
    if (this.progressMusic == null) return;

    this.progressMusic.step = (
      (this.Player as HTMLAudioElement).duration * 0.01
    ).toString();
    this.progressMusic.addEventListener("mousedown", () => {
      clearInterval(this.currentIntervalLooping);
      this.currentIntervalLooping = setInterval(this.MusicLoop, 1);
      this.isPlay = false;
      this.Player?.pause();
    });
    this.progressMusic.addEventListener("mouseup", () => {
      if (this.Player?.paused) {
        this.isPlay = true;
        this.Player?.play();
      }
    });

    this.progressMusic.addEventListener("input", () => {
      if (this.progressMusic == null) return;
      const porcentagemSelecionada = Number.parseInt(this.progressMusic.value);
      const novaPosicao =
        (porcentagemSelecionada / 100) *
        (this.Player as HTMLAudioElement).duration;
      (this.Player as HTMLAudioElement).currentTime = novaPosicao;
      this.setWidthProgress(); // função para atualizar a barra de progresso personalizada
    });
    this.progressMusic.value = "0";

    this.progressMusic.onchange = () => {
      this.setWidthProgress();
    };
  }
}
</script>
<style scoped>
div.music-detail-wrapper {
  padding: 2% 5%;
}
div.progress-element {
  position: absolute;
  padding: 0.5vw 0;
  z-index: 0;
  left: 0%;
  min-width: 2%;
  max-width: 100%;
  top: 0%;
  display: block;
  background-color: var(--corBranco);
  border-radius: 2vw;
  transition: ease-out;
}
div.wrapper-progress {
  position: relative;
  width: 100%;
}
div.progress_volume_wrapper {
  position: absolute;
  width: 100%;
  left: 0;
  bottom: 100%;

  display: none;
}
div.volume_wrapper:hover > div {
  display: flex;
}
div.progress_volume_wrapper input[type="range"] {
  /* background-color: red !important; */
  padding: 1% !important;
}
div.progress_volume_wrapper input[type="range"]::-webkit-slider-runnable-track {
  background-color: #ff9d00;
  border-radius: 0.5rem;
  height: 8vw;
  padding: 0% 12%;
}
div.progress_volume_wrapper input[type="range"]::-moz-range-track {
  background-color: #ff9d00;
  border-radius: 0.5rem;
  height: 8vw;
  padding: 0% 12%;
}
div.playerWrapper {
  width: 100%;
  padding: 1%;
}
div.music_config {
  width: 100%;
  padding: 1%;
}
div.player {
  padding: 1%;
  width: 100%;
}
div.playerWrapper audio {
  width: 100%;
  height: 100%;
}
h1 {
  font-size: 1.2vw;
  font-weight: 600;
  color: white;
}
div.music_config i {
  font-size: 3.5vw;
}
div.play_wrapper,
div.resetar-wrapper,
div.next_wrapper,
div.pause_wrapper,
div.volume_wrapper,
div.back_wrapper {
  position: relative;
  padding: 2%;
  margin: 0 5%;
  width: fit-content;
  cursor: pointer;
  color: var(--corAmarelo);
  text-shadow: 0 0 2px var(--corAmarelo), 0 0 2px var(--corAmarelo),
    0 0 2px var(--corAmarelo), 0 0 2px var(--corAmarelo);
}
div.play_wrapper:hover,
div.next_wrapper:hover,
div.back_wrapper:hover,
div.volume_wrapper:hover,
div.pause_wrapper:hover {
  color: var(--corAzul);
  text-shadow: 0;
}

/*********** Baseline, reset styles ***********/
input[type="range"] {
  -webkit-appearance: none;
  appearance: none;
  background: transparent;
  cursor: pointer;
  width: 100%;
  position: relative;
  z-index: 1;
  height: 80%;
}

/* Removes default focus */
input[type="range"]:focus {
  outline: none;
}

/******** Chrome, Safari, Opera and Edge Chromium styles ********/
/* slider track */
input[type="range"]::-webkit-slider-runnable-track {
  background-color: #fca21170;
  border-radius: 0.5rem;
  height: 0.5rem;
  padding: 2% 0;
}

/* slider thumb */
input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none; /* Override default look */
  appearance: none;
  margin-top: -2.2%; /* Centers thumb on the track */
  background-color: #000000;
  border-radius: 1rem;
  height: 1.5rem;
  width: 1.5rem;
}

/*********** Firefox styles ***********/
/* slider track */
input[type="range"]::-moz-range-track {
  background-color: #fca21170;
  border-radius: 0.5rem;
  height: 0.5rem;
  padding: 1% 0;
}

/* slider thumb */
input[type="range"]::-moz-range-thumb {
  background-color: #000000;
  border: none; /*Removes extra border that FF applies*/
  border-radius: 1rem;
  height: 1.5rem;
  width: 1.5rem;
}
div.wrapper-progress input[type="range"]::-moz-range-thumb {
  background-color: #000000;
  border: none; /*Removes extra border that FF applies*/
  border-radius: 1rem;
  height: 1.5rem;
  width: 1.5rem;
  opacity: 0 !important;
}
input[type="range"]:focus::-moz-range-thumb {
  outline: 3px solid #000000;
  outline-offset: 0.125rem;
}
@media (max-width: 1500px) {
  h1 {
    font-size: 20px;
  }
  div.wrapper-progress {
    height: 30px;
  }
  div.progress-element {
    height: 100%;
    padding: unset;
  }
  input[type="range"]::-webkit-slider-runnable-track {
    background-color: #fca21170;
    border-radius: 0.5rem;
    height: 70%;
    padding: 2% 0;
  }
  input[type="range"]::-moz-range-track {
    background-color: #fca21170;
    border-radius: 0.5rem;
    height: 70%;
    padding: 1% 0;
  }
}
</style>
