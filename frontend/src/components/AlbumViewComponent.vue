<template>
  <ModalComponent
    v-if="ModalConfig.ModalVisible"
    :modalType="ModalConfig.ModalType"
    :message="ModalConfig.ModalMessage"
    @setVisible="ModalConfig.setModalVisible"
  ></ModalComponent>
  <section class="albums_list">
    <div class="header w-100 flexRow d-none">
      <input
        class="w-100"
        type="text"
        name=""
        placeholder="Buscar por albums"
        @keyup="buscarAlbuns"
      />
    </div>
    <div class="w-100 d-none">
      <h1>Veja alguns dos Álbuns:</h1>
    </div>
    <div
      class="d-none flexRow albums-wrapper justify-content-center align-items-center"
    >
      <div
        class="album w-25 flexColumn align-items-center"
        v-for="album in listAlbuns"
        v-bind:key="album.id"
        v-on:click="albumRequest(album, album.id)"
      >
        <div class="image-wrapper">
          <img v-bind:src="album.imageurl" alt="" />
        </div>
        <div class="name-wrapper">
          <h2>{{ album.name }}</h2>
        </div>
        <div class="dateLaunch">
          <h2>Lançamento:{{ album.dateLaunch }}</h2>
        </div>
      </div>
    </div>
  </section>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import Album from "@/components/AlbumModel";
import ModalComponent from "./ModalComponent.vue";
@Options({
  emits: ["finishLoading", "AlbumRequest"],
  components: { ModalComponent },
  async mounted() {
    this.$emit("finishLoading", true);
    await Album.getAllAlbums()
      .then((resolve) => {
        this.listAlbuns = resolve;
        this.listAlbunsCopy = this.listAlbuns;
      })
      .catch((error) => {
        if (error.length == 0) {
          error = "Não foi possível se conectar ao servidor";
        }
        this.ModalConfig.ModalMessage = error;
        this.ModalConfig.setModalVisible();
      })
      .finally(() => {
        this.$emit("finishLoading");
        document.querySelectorAll(".d-none").forEach((item) => {
          item.classList.remove("d-none");
        });
      });
  },
})
export default class AlbumsComponent extends Vue {
  listAlbuns: Album[] = [];
  listAlbunsCopy: Album[] = [];

  ModalConfig = {
    ModalMessage: "Olá mundo",
    ModalType: 1,
    ModalVisible: false,
    setModalVisible: () => {
      this.ModalConfig.ModalVisible = !this.ModalConfig.ModalVisible;
    },
  };
  buscarAlbuns(event: Event) {
    const responseText = (event.target as HTMLInputElement).value;
    this.listAlbuns = this.listAlbunsCopy;
    const searchResults = this.listAlbuns.filter((element) =>
      element.name.includes(responseText)
    );

    this.listAlbuns = searchResults;
  }
  albumRequest(album: Album, albumId: number) {
    document
      .querySelectorAll(".album")
      [albumId - 1].classList.add("fade-out-top");
    document.querySelector("div.albums-wrapper")?.classList.add("fade-out");
    setTimeout(() => {
      this.$emit("AlbumRequest", album);
    }, 700);
  }
}
</script>
<style scoped>
div.header {
  padding: 1%;
  background-color: var(--corPreto);
}
section.albums_list {
  height: 100%;
  width: 100%;
  overflow: auto;
}
div.header input {
  border: 0;
  outline: 0;
  padding: 1% 0.5%;
  font-size: 1.2vw;
  background-color: transparent;
  color: white;
  position: relative;
  border-right: 0.1vw solid rgba(255, 255, 255, 0.01);
  border-top: 0.1vw solid rgba(255, 255, 255, 0.01);
  border-left: 0.1vw solid rgba(255, 255, 255, 0.01);
  border-bottom: 0.1vw solid white;
  width: 80%;
  margin: 0 auto;
  font-weight: 600;
  letter-spacing: 0.1vw;
}
div.header input:focus {
  border-right: 0.1vw solid white;
  border-top: 0.1vw solid white;
  border-left: 0.1vw solid white;
}
h2 {
  font-size: 1.2vw;
  font-weight: 900;
  transform: uppercases;
}
section div.albums-wrapper {
  flex-wrap: wrap;
  animation: fade-in 2s ease-in-out;
}
section div.albums-wrapper div.album {
  margin-top: 1%;
  text-align: center;
  padding: 2%;
  cursor: pointer;
  background-color: var(--corCinza);
  border-radius: 2%;
  transition: ease-in-out scale 0.3s;
}
div.album:hover {
  scale: 102%;
  outline: 0.5vw solid var(--corAzul);
}
div.albums-wrapper div.image-wrapper {
  width: 90%;
  background-color: var(--corAmarelo);
  padding: 2%;
}
div.albums-wrapper div.image-wrapper img {
  object-fit: contain;
  width: 100%;
  height: auto;
}
div.album div.name-wrapper {
  width: 100%;
}
div.album div.name-wrapper h2 {
  color: var(--corAmarelo);
  background-color: var(--corPreto);
  width: 100%;
  display: block;
}
h1 {
  font-size: 1.5vw;
  color: white;
  text-transform: uppercase;
  padding: 1%;
}

@media (max-width: 1500px) {
  div.header input {
    font-size: 21px;
  }
  h2 {
    font-size: 18px;
  }
  h1 {
    font-size: 15px;
  }
}
@media (max-width: 1050px) {
  div.album.w-25 {
    width: calc(100% / 2 - 2%);
  }
}
@media (max-width: 560px) {
  div.album.w-25[data-v-d505e14e] {
    width: calc(100% / 1 - 2%);
  }
}
div.fade-in {
  animation: fade-in 0.2s ease-in-out both;
}
div.fade-out {
  animation: fade-out 0.2s ease-in-out both;
}
@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 100;
  }
}
@keyframes fade-out {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
/* ----------------------------------------------
 * Generated by Animista on 2023-5-29 7:57:10
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info. 
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation fade-out-top
 * ----------------------------------------
 */

.fade-out-top {
  -webkit-animation: fade-out-top 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
  animation: fade-out-top 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
}
@-webkit-keyframes fade-out-top {
  0% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
  }
  100% {
    -webkit-transform: translateY(-50px);
    transform: translateY(-50px);
    opacity: 0;
  }
}
@keyframes fade-out-top {
  0% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
  }
  100% {
    -webkit-transform: translateY(-50px);
    transform: translateY(-50px);
    opacity: 0;
  }
}
</style>
