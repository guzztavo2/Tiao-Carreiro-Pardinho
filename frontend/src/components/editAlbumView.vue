<template>
  <messageComponent
    v-if="MessageProps.isVisible"
    @setVisible="MessageProps.setVisible"
    :title="MessageProps.titleMessage"
    :message="MessageProps.Message"
  ></messageComponent>
  <h1 class="title">Editando álbum</h1>
  <h1 class="title" @click="$emit('AlbumPageLink')">Clique aqui para voltar</h1>
  <div class="flexRow w-100 justify-content-center wrapper">
    <form @submit.prevent="submitForm" method="post">
      <label for="name"
        ><h1>Nome do Álbum</h1>
        <input
          @keyup="checkName"
          v-model="inputReq.name"
          type="text"
          name="name"
          id=""
        />
        <small v-text="inputReq.errorName"></small> </label
      ><label for="date"
        ><h1>Data de lançamento do Álbum</h1>
        <input
          @keyup="checkDate"
          v-model="inputReq.dateLaunch"
          type="text"
          name="date"
          id="" /><small v-text="inputReq.errorDate"></small
      ></label>
      <label for="myfile"
        ><h1>Selecione uma imagem</h1>
        <input
          @change="uploadFile"
          type="file"
          id="myfile"
          name="myfile"
          ref="file"
        /><br /><br />
        <img v-bind:src="album?.imageurl" alt="" ref="img" />
      </label>
      <label
        for="musics"
        v-if="
          previewList !== undefined &&
          previewList !== null &&
          previewList.length > 0
        "
      >
        <h1>Músicas desse álbum:</h1>
        <div class="flexRow w-100 adc-music-button-wrapper">
          <h1 class="w-100 adc-music-button">Adicionar música ao álbum</h1>
        </div>
        <div
          class="w-100 flexRow song-wrapper align-items-center justify-content-center"
        >
          <div class="id title">
            <h1>Identificação</h1>
          </div>
          <div class="name title"><h1>Título</h1></div>
          <div class="duration title"><h1>Duração</h1></div>
          <div class="special title"><h1>*</h1></div>
        </div>
        <div
          v-for="item in previewList"
          v-bind:key="item.id"
          class="songs flexRow w-100"
        >
          <div class="id content"><h1 v-text="item.id"></h1></div>

          <div class="name content"><h1 v-text="item.name"></h1></div>
          <div class="duration content">
            <h1 v-text="(item.duration / 60).toString().substring(0, 4)"></h1>
          </div>
          <div class="special content flexRow">
            <h1 class="w-50">Editar</h1>
            <h1 class="w-50">Deletar</h1>
          </div>
        </div>
      </label>
      <input type="submit" value="Atualizar" />
    </form>
  </div>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Album from "./AlbumModel";
import messageComponent from "./MessageBoxComp.vue";
import Song from "./SongModel";
@Options({
  components: { messageComponent },
  props: {
    Album: {
      require: true,
      type: Album,
    },
  },
  emits: ["isLoading", "AlbumPageLink"],
  async created() {
    this.album = this.Album;
    this.previewList = new Song(this.album);
    this.previewList = await this.previewList.getServerData().then();
  },
  mounted() {
    this.$emit("isLoading", false);
    this.setVarValues();
  },
})
export default class EditAlbum extends Vue {
  album: Album | null = null;
  previewList: Song[] | null = null;
  inputReq = {
    name: "",
    dateLaunch: "",
    errorName: "",
    errorDate: "",
  };
  File!: File;
  MessageProps = {
    isVisible: false,
    titleMessage: "",
    Message: "",
    setVisible: (visible: boolean, closeComponent: boolean | null = null) => {
      if (closeComponent !== null) this.$emit("closeComponent");
      this.MessageProps.isVisible = visible;
    },
  };
  setVarValues() {
    if (this.album == null) return;
    this.inputReq.name = this.album.name as string;
    this.inputReq.dateLaunch = this.album.dateLaunch as string;
  }
  uploadFile() {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const file = (this as any).$refs.file.files[0] as File;
    const refImg = this.$refs.img as HTMLImageElement;
    if (file.type !== "image/jpg" && file.type !== "image/png") {
      this.MessageProps.Message =
        "Não é possível fazer a requisição com um tipo diferente de imagem! Por favor, tente com os seguintes tipos: JPG ou PNG.";
      this.MessageProps.titleMessage = "Erro!";
      this.MessageProps.isVisible = true;
    }
    // O que falta: Testar tamanho do arquivo!

    const reader = new FileReader();
    reader.onload = function (e) {
      const image = new Image();
      if (e.target == null) return;
      image.src = e.target.result as string;
      refImg.src = image.src;
    };
    reader.readAsDataURL(file);
    this.File = file;
  }
  checkName() {
    const name = this.inputReq.name;
    if (name.length == 0) {
      this.inputReq.errorName =
        "Se você deixar os valores vazios, eles não serão atualizados!";
      setTimeout(() => {
        this.inputReq.errorName = "";
      }, 2000);
      return;
    }

    if (name.length < 5) {
      // eslint-disable-next-line @typescript-eslint/no-unused-vars
      this.inputReq.errorName =
        " nome do álbum precisa ter " + (5 - name.length) + " caracteres";
    } else if (name.length >= 5 && name.length <= 20)
      this.inputReq.errorName = "";
    else {
      this.inputReq.errorName =
        " nome do álbum precisar ter 20 caracteres, e precisa remover: " +
        (name.length - 20) +
        " caracteres";
    }
  }
  checkDate() {
    if (this.inputReq.dateLaunch.length == 0) return;
    this.inputReq.dateLaunch = this.inputReq.dateLaunch.replace(/\D/g, "");
    let date = this.inputReq.dateLaunch;
    this.inputReq.dateLaunch = date
      .replace(/(\d{2})(\d{2})(\d{4})/, "$1-$2-$3")
      .substring(0, 10);

    if (this.inputReq.dateLaunch.length < 10) {
      this.inputReq.errorDate = "A data é necessário ter mais caracteres!";
      return;
    } else {
      const [day, month, year] = this.inputReq.dateLaunch.split("-");
      const date = new Date(`${month}/${day}/${year}`);
      if (date.toString() == "Invalid Date") {
        this.inputReq.errorDate =
          "A data precisa ser válida para registrar o álbum.";
        return;
      }

      this.inputReq.errorDate = "";
    }
  }
  async submitForm() {
    if (this.File == null) {
      this.MessageProps.Message =
        "Não é possível fazer a solicitação pois é necessário uma imagem para poder criar um novo álbum!";
      this.MessageProps.titleMessage = "Erro";
      this.MessageProps.isVisible = true;
      return;
    }
    this.$emit("isLoading", true);
    await Album.createAlbum({
      name: this.inputReq.name,
      date: this.inputReq.dateLaunch,
      file: this.File,
    })
      .then(() => {
        this.MessageProps.Message = "Album registrado com sucesso!";
        this.MessageProps.titleMessage = "Sucesso!";
        this.MessageProps.isVisible = true;
        setTimeout(async () => {
          this.$emit("AlbumPageLink");
          await Album.localStorage.cleanAlbums();
        }, 1500);
      })
      .catch((error) => {
        if (error.length == 0) {
          this.MessageProps.Message =
            "Não é possível fazer a solicitação para criar um novo álbum, o servidor encontra-se fora do ar! Recarregue a página e tente novamente!";
          this.MessageProps.titleMessage = "Erro";
          this.MessageProps.isVisible = true;
          return;
        }
        this.MessageProps.Message =
          "Não é possível fazer a solicitação para criar um novo álbum: " +
          error;
        this.MessageProps.titleMessage = "Erro";
        this.MessageProps.isVisible = true;
      })
      .finally(() => {
        this.$emit("isLoading", false);
      });
  }
}
</script>
<style scoped>
form {
  width: 60%;
  margin-top: 1%;
}
h1.title {
  font-size: 1.2vw;
  color: white;
  text-transform: uppercase;
  font-weight: 600;
  border-bottom: 2px solid white;
}
label {
  background-color: var(--corAmarelo);
  display: block;
  width: 100%;
  padding: 1%;
  margin-top: 1%;
}
label h1,
input {
  font-size: 1.2vw;
}
input {
  width: 100%;
  padding: 1%;
  outline: 0;
  border: 0;
}
img {
  width: 100%;
  object-fit: contain;
}
div.wrapper {
  width: 100%;
  height: 100%;
}
small {
  font-size: 1vw;
  font-weight: 600;
  color: red;
  text-transform: uppercase;
}
div.song-wrapper {
  background-color: var(--corPreto);
  color: var(--corAmarelo);
}
div.song-wrapper div.title {
  background-color: red;
  padding: 0 1%;
}
div.song-wrapper div.title,
div.content {
  width: calc(100% / 4);
  text-align: center;
}

h1.adc-music-button {
  background-color: var(--corPreto);
  color: var(--corBranco);
  padding: 1%;
  text-align: center;
  max-width: 50%;
  cursor: pointer;
  border: 1px solid var(--corBranco);
}
div.adc-music-button-wrapper {
  justify-content: end;
  padding: 1%;
}
</style>
