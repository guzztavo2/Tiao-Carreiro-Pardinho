<template>
  <messageComponent
    v-if="MessageProps.isVisible"
    @setVisible="MessageProps.setVisible"
    :title="MessageProps.titleMessage"
    :message="MessageProps.Message"
  ></messageComponent>
  <section id="albumComp" class="flexColumn justify-content-center">
    <div class="flexRow">
      <h1 class="title">Álbuns e previews</h1>
      <div class="add-wrapper w-100">
        <h1 @click="$emit('albumCreateLink')">Adicionar um novo álbum</h1>
      </div>
    </div>
    <div
      class="flexRow w-100 justify-content-center align-items-center album-wrapper title"
    >
      <div class="id-wrapper content">
        <h1>Identificação</h1>
      </div>
      <div class="name-wrapper content">
        <h1>Álbum</h1>
      </div>
      <div class="datelaunch-wrapper content">
        <h1>Lançamento</h1>
      </div>
      <div class="image-wrapper content"><h1>imagem</h1></div>
      <div class="special-wrapper content">
        <h1>Editar/Deletar</h1>
      </div>
    </div>
    <div class="flexRow w-100 align-items-center wrapper-content">
      <div
        v-for="album in listOfAlbums"
        v-bind:key="album.id"
        class="flexRow w-100 align-items-center justify-content-center album-wrapper content"
      >
        <div class="id-wrapper content">
          <h1 v-text="album.id"></h1>
        </div>
        <div class="name-wrapper content">
          <h1 v-text="album.name.substring(0, 20) + '...'"></h1>
        </div>
        <div class="datelaunch-wrapper content">
          <h1 v-text="album.dateLaunch"></h1>
        </div>
        <div class="image-wrapper content">
          <img v-bind:src="album.imageurl" alt="" srcset="" />
        </div>
        <div class="special-wrapper content flexRow">
          <div class="w-50" @click="editAlbum(album)">
            <h1>Editar</h1>
          </div>
          <div class="w-50"><h1>Deletar</h1></div>
        </div>
      </div>
    </div>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Album from "./AlbumModel";
import messageComponent from "./MessageBoxComp.vue";
@Options({
  components: { messageComponent },
  emits: [
    "isLoading",
    "closeComponent",
    "albumCreateLink",
    "albumEditLink",
    "setAlbum",
  ],
  async mounted() {
    this.listOfAlbums = await Album.getAllAlbums();
    if (this.listOfAlbums == false) {
      this.MessageProps.titleMessage =
        "Não foi possível se conectar ao servidor";
      this.MessageProps.Message = `O servidor está com algum erro ou problema.Recarregue a página, se o error persistir, aguarde até arrumarem.`;
      this.MessageProps.isVisible = true;
    }
    this.$emit("isLoading", false);
  },
})
export default class albumComponent extends Vue {
  listOfAlbums: Album[] = [];
  editAlbum(album: Album) {
    this.$emit("setAlbum", album);
    this.$emit("albumEditLink");
  }
  MessageProps = {
    isVisible: false,
    titleMessage: "",
    Message: "",
    setVisible: (visible: boolean, closeComponent: boolean | null = null) => {
      if (closeComponent !== null) this.$emit("closeComponent");
      this.MessageProps.isVisible = visible;
    },
  };
}
</script>
<style scoped>
div.album-wrapper {
  flex-wrap: nowrap;
}
div.album-wrapper.content {
  height: calc(100% / 10);
  background-color: var(--corBranco);
  border: 0.1vw solid var(--corPreto);
  margin-top: 1%;
}
div.album-wrapper.content:hover {
  background-color: var(--corAmarelo);
}
div.album-wrapper div.content {
  width: calc(100% / 5 - 1%);
  min-width: 200px;
}
div.album-wrapper h1 {
  width: 100%;
  cursor: pointer;
  padding: 2%;
  font-weight: 600;
  text-align: center;
  font-size: 1vw;
}
div.album-wrapper.title h1 {
  background-color: var(--corAmarelo);
  transition: ease-in-out 0.2s;
}
div.album-wrapper.title h1:hover {
  background-color: var(--corPreto);
  color: var(--corBranco);
}
div.album-wrapper.title h1 {
  font-size: 1.2vw;
}
h1.title {
  font-size: 1.2vw;
  color: white;
  text-transform: uppercase;
  font-weight: 600;
  border-bottom: 2px solid white;
  margin-bottom: 1%;
  width: 50%;
}
div.wrapper-content {
  height: 87%;
  margin-top: 0.1%;
  flex-wrap: wrap;
}
section#albumComp {
  width: 100%;
  height: 100%;
}
div.image-wrapper.content {
  text-align: center;
  height: 100%;
}
div.image-wrapper.content img {
  height: 100%;
  width: auto;
  object-fit: contain;
}
div.add-wrapper {
  width: 50%;
  text-align: right;
}
div.add-wrapper h1 {
  font-size: 1.2vw;
  background-color: var(--corAmarelo);
  width: auto;
  display: inline;
  padding: 1%;
  border-radius: 30px;
  cursor: pointer;
}
div.add-wrapper h1:hover {
  background-color: white;
}
@media (max-width: 1500px) {
  div.image-wrapper.content {
    text-align: center;
    height: 2vw;
  }
  div.album-wrapper h1 {
    font-size: 18px;
  }
  div.album-wrapper.title h1 {
    font-size: 20px;
  }
  h1.title {
    font-size: 30px;
  }
}
</style>
