<template>
  <h1>Registre-se para fazer upload e editar as músicas e oss albuns!</h1>
  <form class="flexColumn align-items-center" @submit.prevent="" method="post">
    <label for="nomeUsuario">
      <p>Nome de usuário:</p>
      <input
        v-model="userProps.nomeUsuario"
        type="text"
        name=""
        id="nomeUsuario"
      />
      <small>Olá mundo</small>
    </label>
    <label for="senhaUsuario">
      <p>Senha:</p>
      <input
        v-model="userProps.senhaUsuario"
        type="password"
        name=""
        id="senhaUsuario"
      />
      <small>Olá mundo</small>
    </label>
    <input type="submit" value="Registrar" />
  </form>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
@Options({})
export default class registroComponent extends Vue {
  userProps = {
    nomeUsuario: {
      prop: "",
      setInvalid: (message: string) => {
        const label = document.querySelector(
          'label[for="nomeUsuario"]'
        ) as HTMLElement;
        if (label == null) return;
        label.classList.add("invalid");
        label.classList.remove("valid");
        (label.querySelector("small") as HTMLElement).innerHTML = message;
      },
    },
    senhaUsuario: "",
  };
}
</script>
<style scoped>
h1 {
  font-weight: 600;
  font-size: 1.2vw;
  text-align: center;
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
</style>
