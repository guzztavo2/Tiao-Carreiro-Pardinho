<template>
  <h1>Registre-se para fazer upload e editar as músicas e os albuns:</h1>
  <a @click="loginComponentLink"
    >Caso já tenha uma conta, é só clicar aqui para logar!</a
  >
  <form
    class="flexColumn align-items-center"
    @submit.prevent="registerUser"
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
    <input type="submit" value="Registrar" />
  </form>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import User from "@/components/UserModel";
@Options({
  emits: ["errorCapture", "loginComponentLink"],
})
export default class registroComponent extends Vue {
  loginComponentLink() {
    this.$emit("loginComponentLink");
  }
  userProps = {
    nomeUsuario: {
      prop: "",
      setInvalid: (message: string) => {
        registroComponent.setInvalid('label[for="nomeUsuario"]', message);
      },
      setValid: (message: string) => {
        registroComponent.setValid('label[for="nomeUsuario"]', message);
      },
    },
    senhaUsuario: {
      prop: "",
      setInvalid: (message: string) => {
        registroComponent.setInvalid('label[for="senhaUsuario"]', message);
      },
      setValid: (message: string) => {
        registroComponent.setValid('label[for="senhaUsuario"]', message);
      },
    },
  };
  async CheckUserName() {
    if (this.userProps.nomeUsuario.prop.length == 0) return;
    const response = await User.checkUserName(this.userProps.nomeUsuario.prop);
    if (response.error !== null && response !== 200) {
      this.userProps.nomeUsuario.setInvalid(response.error);
      return false;
    }
    return true;
  }
  static setInvalid(labelStr: string, message: string) {
    const label = document.querySelector(labelStr) as HTMLElement;
    if (label == null) return;
    registroComponent.addRemoveClass(label, "valid", "invalid");
    (label.querySelector("small") as HTMLElement).innerHTML = message;
  }
  static setValid(labelStr: string, message: string) {
    const label = document.querySelector(labelStr) as HTMLElement;
    if (label == null) return;
    registroComponent.addRemoveClass(label, "invalid", "valid");
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
      this.userProps[campo].setValid(
        isNomeUsuario
          ? "Esse nome está correto e disponível para registro."
          : "Esse campo está correto e disponível para registro."
      );
      return true;
    } else {
      const campo = isNomeUsuario ? "nomeUsuario" : "senhaUsuario";
      this.userProps[campo].setInvalid(
        `Caracteres: ${maxChar} / ${prop.length}`
      );
    }

    return false;
  }

  async registerUser() {
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
    if (await !this.CheckUserName()) return;

    const user = new User(
      this.userProps.nomeUsuario.prop,
      this.userProps.senhaUsuario.prop
    );
    await user
      .registro()
      .then(() => {
        this.$emit(
          "errorCapture",
          "Registro concluído com sucesso, é só acessar utilizando suas informações!",
          true
        );
      })
      .catch((error) => {
        this.$emit("errorCapture", JSON.parse(error).Error);
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
  align-items: flex-start;
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
