<template>
  <h1>Veja ou escute algumas obras:</h1>
  <section ref="section_obras" id="obras" class="flexColumn">
    <loadingComponent v-if="isLoading"></loadingComponent>
    <AlbumComponents
      v-if="albumComponentsIsVisible"
      @AlbumRequest="AlbumRequest"
      @finishLoading="finishLoading"
    ></AlbumComponents>
    <SongComponent
      v-if="!albumComponentsIsVisible && AlbumItem !== null"
      @finishLoading="finishLoading"
      :albumItem="AlbumItem"
      @clearAlbum="clearAlbumItem"
    ></SongComponent>
  </section>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import AlbumComponents from "@/components/AlbumViewComponent.vue";
import loadingComponent from "@/components/loadingComponent.vue";
import Album from "@/components/AlbumModel";
import SongComponent from "@/components/SongViewComponents.vue";
@Options({
  components: { AlbumComponents, loadingComponent, SongComponent },
  mounted() {
    (this.$refs.section_obras as HTMLElement).scrollIntoView();
  },
})
export default class SectionMusicas extends Vue {
  isLoading = true;
  albumComponentsIsVisible = true;
  AlbumItem: Album | null = null;
  finishLoading(isLoading: boolean | undefined = undefined) {
    if (isLoading == undefined) this.isLoading = false;
    this.isLoading = isLoading as boolean;
  }
  clearAlbumItem() {
    this.isLoading = true;
    this.AlbumItem = null;
    this.albumComponentsIsVisible = true;
  }
  AlbumRequest(album: Album) {
    this.albumComponentsIsVisible = false;
    this.AlbumItem = album;
    this.isLoading = true;
  }
}
</script>
<style scoped>
h1 {
  font-weight: 300;
  text-transform: uppercase;
  position: relative;
  font-size: 2vw;
  width: 100%;
  background-color: var(--corAzul);
  color: var(--corBranco);
  padding: 1% 2%;
}
h1::after {
  content: "";
  display: block;
  position: absolute;
  left: 5%;
  bottom: 10%;
  width: 90%;
  height: 0.2vw;
  background-color: var(--corAmarelo);
}
section {
  margin-top: 1%;
  width: 70%;
  height: 90%;
  min-height: 300px;
  margin: 0 auto;
  background-color: var(--corPreto);
  padding: 2%;
  position: relative;
}

@media (max-width: 1500px) {
  h1 {
    font-size: 30px;
  }
  section {
    width: 80%;
    height: 100%;
  }
}
@media (max-width: 900px) {
  section {
    width: 90%;
    overflow: auto;
  }
}
@media (max-width: 450px) {
  section {
    width: 100%;
  }
}
</style>
