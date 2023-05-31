<template>
  <section>
    <loadingComponent v-if="isLoading"></loadingComponent>
    <albumComponent
      v-if="propSection_ == 1"
      @closeComponent="closeComponent"
      @isLoading="isLoadingHandler"
      @albumCreateLink="albumCreateLink"
      @albumEditLink="albumEditLink"
      @setAlbum="setAlbum"
    ></albumComponent>
    <createAlbum
      v-if="propSection_ == 2"
      @isLoading="isLoadingHandler"
      @AlbumPageLink="albumComponentLink"
    ></createAlbum>
    <EditAlbum
      v-if="propSection_ == 3"
      @isLoading="isLoadingHandler"
      @AlbumPageLink="albumComponentLink"
      :Album="album"
    >
    </EditAlbum>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import albumComponent from "@/components/AlbumConfigComponent.vue";
import loadingComponent from "@/components/loadingComponent.vue";
import createAlbum from "@/components/CreateAlbum.vue";
import EditAlbum from "@/components/editAlbumView.vue";
import Album from "@/components/AlbumModel";
@Options({
  props: {
    propSection: {
      require: true,
      type: Number,
    },
  },
  async created() {
    this.propSection_ = this.propSection;
  },
  components: { albumComponent, loadingComponent, createAlbum, EditAlbum },
  emits: ["closeComponent"],
})
export default class UserPage extends Vue {
  album!: Album;
  propSection_ = 0;
  isLoading = true;
  closeComponent() {
    this.$emit("closeComponent");
  }
  isLoadingHandler(isLoading: boolean) {
    this.isLoading = isLoading;
  }
  setAlbum(album: Album) {
    this.album = album;
  }
  albumComponentLink() {
    this.propSection_ = 1;
  }
  albumCreateLink() {
    this.propSection_ = 2;
  }

  albumEditLink() {
    this.propSection_ = 3;
  }
}
</script>
<style scoped>
section {
  background-color: var(--corAzul);
  width: 100%;
  height: 100%;
  overflow: auto;
  padding: 1%;
}
h1.title {
  font-size: 1.2vw;
  color: white;
  text-transform: uppercase;
  font-weight: 600;
  border-bottom: 2px solid white;
}
</style>
