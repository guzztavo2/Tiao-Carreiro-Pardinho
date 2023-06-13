<template>
  <section ref="section" class="music_album flexRow fade-in">
    <div class="albumWrapper w-50 fade-in" v-if="albumItemObj !== null">
      <h1 @click="backToAlbums" id="backToAlbums">
        <i class="fa-solid fa-left-long fade-in"></i> Voltar para os albuns.
      </h1>
      <div class="image-albumWrapper w-100 fade-in">
        <img v-bind:src="albumItemObj.imageurl" alt="" />
      </div>
      <div class="name-albumWrapper w-100 fade-in">
        <h1>{{ albumItemObj.name }}</h1>
      </div>
      <div class="dateLaunch-albumWrapper w-100 fade-in">
        <h1>Lançamento: {{ albumItemObj.dateLaunch }}</h1>
      </div>
      <PlayerComponent
        @nextSong="nextSong"
        @prevSong="prevSong"
        v-if="actualPreview !== null"
        :actualPreview="actualPreview"
      ></PlayerComponent>
    </div>
    <div class="songWrapper w-50 fade-in">
      <div
        v-for="song in songList"
        v-bind:key="song.getId()"
        v-on:click="playPreview(song, $event)"
        class="song flexRow justify-content-center align-items-center fade-in"
      >
        <div class="image w-50">
          <img
            v-if="albumItemObj !== null"
            v-bind:src="albumItemObj.imageurl"
            alt=""
          />
        </div>
        <div class="w-50 song_data fade-in">
          <div class="name">
            <h1>{{ song.getName() }}</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Album from "./AlbumModel";
import Song from "./SongModel";
import PlayerComponent from "./PlayerPreviewComponent.vue";
@Options({
  emits: ["finishLoading", "clearAlbum"],
  props: ["albumItem"],
  async mounted() {
    const song = new Song(this.albumItem);
    this.albumItemObj = this.albumItem;
    await song.getServerData().then((result) => {
      this.songList = result;
      this.actualPreview = this.songList[0];
    });
    this.$emit("finishLoading");
  },
  components: { PlayerComponent },
})
export default class SongComponent extends Vue {
  albumItemObj: Album | null = null;
  songList: Song[] | null = null;
  actualPreview: Song | null = null;
  nextSong() {
    let result = this.songList?.findIndex(
      (element) => element == this.actualPreview
    );
    result = ++(result as number);
    if (result > (this.songList as Song[]).length - 1) result = 0;
    this.actualPreview = (this.songList as Song[])[result];

    this.$el.querySelector(".song.active")?.classList.remove("active");
    console.log(this.$el.querySelectorAll(".song"));
    this.$el.querySelectorAll(".song")[result].classList.add("active");
    this.$el.querySelectorAll(".song")[result].scrollIntoView();
  }
  prevSong() {
    let result = this.songList?.findIndex(
      (element) => element == this.actualPreview
    );
    if (result == 0) result = (this.songList as Song[]).length - 1;
    else result = --(result as number);
    this.actualPreview = (this.songList as Song[])[result];
    this.$el.querySelector(".song.active")?.classList.remove("active");
    console.log(this.$el.querySelectorAll(".song"));
    this.$el.querySelectorAll(".song")[result].classList.add("active");
    this.$el.querySelectorAll(".song")[result].scrollIntoView();
  }
  playPreview(song: Song, event: Event) {
    this.actualPreview = song;
    if (document.querySelectorAll(".song.active").length > 0) {
      document.querySelectorAll(".song.active").forEach((item) => {
        item.classList.remove("active");
      });
    }
    (event.currentTarget as HTMLElement).classList.add("active");
  }
  backToAlbums() {
    (this.$refs.section as HTMLElement).classList.replace(
      "fade-in",
      "fade-out"
    );
    setTimeout(() => {
      this.$emit("clearAlbum");
    }, 1200);
  }
}
</script>
<style scoped>
section.music_album {
  width: 100%;
  height: 100%;
  background-color: var(--corPreto);
}
section.music_album div.albumWrapper {
  border-right: 0.1vw solid var(--corAmarelo);
}
div.image-albumWrapper {
  text-align: center;
}
div.image-albumWrapper img {
  width: 80%;
  height: auto;
  object-fit: contain;
}
h1 {
  font-size: 1.2vw;
  color: var(--corAmarelo);
}
h1#backToAlbums {
  display: block;
  padding: 2%;
  text-align: center;
  cursor: pointer;
  text-transform: uppercase;
}
h1#backToAlbums:hover {
  background-color: white;
}
div.name-albumWrapper h1 {
  text-align: center;
  border-bottom: 0.1vw solid var(--corAmarelo);
  text-transform: uppercase;
}
div.dateLaunch-albumWrapper h1 {
  text-align: center;
  text-transform: lowercase;
}
div.songWrapper {
  height: 100%;
  overflow: auto;
  position: relative;
}
div.songWrapper div.song {
  padding: 2%;
  background-color: var(--corAmarelo);
  margin-top: 1%;
  cursor: pointer;
}
div.song div.image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
div.song_data {
  width: 80%;
}
div.song_data h1 {
  font-weight: 900;
  text-transform: uppercase;
  font-size: 1.2vw;
  text-align: left;
}
div.song_data div.duration h1 {
  text-align: right;
  font-size: 1vw;
  text-transform: lowercase;
}
div.songWrapper .song h1 {
  color: var(--corBranco);
}
div.songWrapper .song:hover {
  background-color: white;
}
div.songWrapper .song:hover h1 {
  color: var(--corPreto);
}
div.songWrapper .song.active {
  background-color: var(--corAzul);
  color: var(--corBranco) !important;
}
div.songWrapper .song.active:hover h1 {
  color: var(--corBranco);
}
.fade-in {
  -webkit-animation: fade-in 1.7s cubic-bezier(0.39, 0.575, 0.565, 1) both;
  animation: fade-in 1.7s cubic-bezier(0.39, 0.575, 0.565, 1) both;
}
/* ----------------------------------------------
 * Generated by Animista on 2023-6-5 10:2:30
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info. 
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation fade-in
 * ----------------------------------------
 */
@-webkit-keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

@media (max-width: 1500px) {
  h1 {
    font-size: 25px;
  }
  div.song_data div.duration h1 {
    font-size: 20px;
  }
  div.song_data h1 {
    font-size: 20px;
  }
}
@media (max-width: 900px) {
  section.music_album {
    flex-wrap: wrap;
    overflow: unset;
  }
  div.albumWrapper,
  div.songWrapper {
    width: 100%;
  }
  div.songWrapper div.song {
    height: 150px;
  }
  div.song div.image img {
    height: 120px;
    object-fit: contain;
  }
}
</style>
