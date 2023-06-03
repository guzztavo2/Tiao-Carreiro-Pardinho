<template>
  <loadingComponent v-if="isLoading"></loadingComponent>
  <h1>Realize o login para fazer upload e editar as músicas e os albuns:</h1>
  <a @click="registerComponentLink"
    >Caso ainda não tenha uma conta, clique aqui para registrar!</a
  >
  <form
    class="flexColumn align-items-center"
    @submit.prevent="loginUser"
    method="post"
  >
    <label for="nomeUsuario">
      <p>Nome de usuário:</p>
      <input
        v-model="userProps.nomeUsuario.prop"
        type="text"
        name=""
        placeholder="Digite o nome de usuário"
        id="nomeUsuario"
        @keyup="verificarInput(true)"
      />
      <small></small>
    </label>
    <label for="senhaUsuario">
      <p>Senha:</p>
      <input
        v-model="userProps.senhaUsuario.prop"
        type="password"
        name=""
        placeholder="Digite sua senha de usuário"
        id="senhaUsuario"
        @keyup="verificarInput(false)"
      />
      <small></small>
    </label>
    <input type="submit" value="Realizar Login" />
  </form>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import loadingComponent from "./loadingComponent.vue";
import User from "@/components/UserModel";
@Options({
  emits: ["registerComponentLink", "errorCapture"],
  components: { loadingComponent },
  mounted() {
    this.isLoading = false;
  },
})
export default class loginComponent extends Vue {
  isLoading = true;
  userProps = {
    nomeUsuario: {
      prop: "guzztavo2",
      setInvalid: (message: string) => {
        loginComponent.setInvalid('label[for="nomeUsuario"]', message);
      },
      setValid: (message: string) => {
        loginComponent.setValid('label[for="nomeUsuario"]', message);
      },
    },
    senhaUsuario: {
      prop: "12345",
      setInvalid: (message: string) => {
        loginComponent.setInvalid('label[for="senhaUsuario"]', message);
      },
      setValid: (message: string) => {
        loginComponent.setValid('label[for="senhaUsuario"]', message);
      },
    },
  };
  registerComponentLink() {
    this.$emit("registerComponentLink");
  }
  static setInvalid(labelStr: string, message: string) {
    const label = document.querySelector(labelStr) as HTMLElement;
    if (label == null) return;
    loginComponent.addRemoveClass(label, "valid", "invalid");
    (label.querySelector("small") as HTMLElement).innerHTML = message;
  }
  static setValid(labelStr: string, message: string) {
    const label = document.querySelector(labelStr) as HTMLElement;
    if (label == null) return;
    loginComponent.addRemoveClass(label, "invalid", "valid");
    (label.querySelector("small") as HTMLElement).innerHTML = message;
  }
  static addRemoveClass(
    element: HTMLElement,
    removeElement: string | null = null,
    addElement: string | null = null
  ) {
    if (removeElement !== null) element.classList.remove(removeElement);
    if (addElement !== null) element.classList.add(addElement);
  }
  async verificarInput(isNomeUsuario: boolean) {
    const maxChar = 30;
    const minChar = 5;
    const prop = isNomeUsuario
      ? this.userProps.nomeUsuario.prop
      : this.userProps.senhaUsuario.prop;

    if (prop.length === 0) {
      const campo = isNomeUsuario ? "nomeUsuario" : "senhaUsuario";
      this.userProps[campo].setInvalid("O campo não pode ser vazio!");
      return;
    }

    if (prop.length < minChar) {
      const faltando = minChar - prop.length;
      const campo = isNomeUsuario ? "nomeUsuario" : "senhaUsuario";
      this.userProps[campo].setInvalid(
        `Faltando: ${faltando} / ${prop.length} caracteres`
      );
    } else if (prop.length >= minChar && prop.length <= maxChar) {
      const campo = isNomeUsuario ? "nomeUsuario" : "senhaUsuario";
      this.userProps[campo].setValid("");
      return true;
    } else {
      const campo = isNomeUsuario ? "nomeUsuario" : "senhaUsuario";
      this.userProps[campo].setInvalid(
        `Caracteres: ${maxChar} / ${prop.length}`
      );
    }

    return false;
  }

  async loginUser() {
    this.isLoading = true;
    if (
      (await this.verificarInput(true)) == false ||
      (await this.verificarInput(false)) == false
    ) {
      this.$emit(
        "errorCapture",
        "Os campos estão inválidos para conseguir fazer o registro!"
      );
      return;
    }
    const user = new User(
      this.userProps.nomeUsuario.prop,
      this.userProps.senhaUsuario.prop
    );
    await user
      .login()
      .then((resolve) => {
        const response = JSON.parse(resolve as string);
        User.setToken(response.token, response.userName);
        this.$emit("errorCapture", "Você agora tem acessso ao sistema");
      })
      .catch((error) => {
        this.$emit("errorCapture", JSON.parse(error));
      })
      .finally(() => {
        this.isLoading = false;
      });
  }
}
</script>
<style scoped>
h1 {
  font-weight: 600;
  font-size: 1.2vw;
  text-align: center;
}
a {
  background-color: var(--corAmarelo);
  color: var(--corPreto);
  display: block;
  width: 100%;
  font-size: 1vw;
  padding: 1%;
  text-align: center;
  cursor: pointer;
}
form {
  width: 100%;
  padding: 2%;
}
form label {
  width: 100%;
  padding: 2%;
  display: flex;
  flex-flow: column wrap;
  align-items: start;
  justify-content: center;
}
form label.invalid input {
  border: 0.2vw solid red;
}
form label.valid input {
  border: 0.2vw solid green;
}
small {
  font-size: 0.9vw;
  padding: 1%;
}
form label.invalid small {
  color: red;
}
form label.valid small {
  color: green;
}
form label p {
  font-size: 1.2vw;
  font-weight: 900;
}
form label input {
  border: 0;
  outline: 0;
  width: 100%;
  padding: 3% 2%;
  font-size: 1vw;
}
form label input:focus {
  background-color: var(--corCinza);
  outline: 2px solid var(--corAmarelo);
}
form input[type="submit"] {
  border: 0;
  outline: 0;
  font-size: 1.2vw;
  text-transform: uppercase;
  padding: 2%;
  width: 90%;
  cursor: pointer;
  border-radius: 0.4vw;
  background-color: black;
  color: white;
  border: 1px solid white;
}
form input[type="submit"]:hover {
  background-color: white;
  color: black;
}
@media (max-width: 1500px) {
  a {
    font-size: 18px;
  }
  h1 {
    font-size: 23px;
  }
  form label.invalid input {
    border: 3px solid red;
  }
  form label.valid input {
    border: 3px solid green;
  }
  small {
    font-size: 19px;
  }
  form label p {
    font-size: 22px;
  }
  form label input {
    padding: 3% 2%;
    font-size: 20px;
  }
  form input[type="submit"] {
    font-size: 22px;

    border: 1px solid white;
  }
}
</style>
