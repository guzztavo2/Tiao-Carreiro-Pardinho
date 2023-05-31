<template>
  <messageComponent
    v-if="MessageProps.isVisible"
    @setVisible="MessageProps.setVisible"
    :title="MessageProps.titleMessage"
    :message="MessageProps.Message"
  ></messageComponent>
  <h1 class="title">Adicionar novo álbum</h1>
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
        <img src="" alt="" ref="img" />
      </label>
      <input type="submit" value="Criar" />
    </form>
  </div>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import Album from "./AlbumModel";
import messageComponent from "./MessageBoxComp.vue";
@Options({
  components: { messageComponent },
  emits: ["isLoading", "AlbumPageLink"],
  mounted() {
    this.$emit("isLoading", false);
  },
})
export default class createAlbum extends Vue {
  Album: Album | null = null;
  inputReq = {
    name: "2222222",
    dateLaunch: "22-22-2222",
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
    if (name.length == 0) return;

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
    } else if (
      this.inputReq.errorDate.length !== 0 ||
      this.inputReq.errorName.length !== 0
    ) {
      this.MessageProps.Message =
        "Não é possível fazer a solicitação para criar um novo álbum, com o formulário com dados inválidos!";
      this.MessageProps.titleMessage = "Erro";
      this.MessageProps.isVisible = true;
      return;
    }
    if (this.inputReq.dateLaunch.length == 0) {
      this.inputReq.errorDate =
        "É necessário ter uma data para salvar esse álbum!";
      return;
    } else if (this.inputReq.name.length == 0) {
      this.inputReq.errorName =
        "É necessário ter 5 caracteres para salvar esse álbum!";
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
</style>
