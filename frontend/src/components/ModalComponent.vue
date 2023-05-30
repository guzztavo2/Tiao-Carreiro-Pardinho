<template>
  <section
    id="modal"
    class="fade-in-top flexColumn justify-content-center align-items-center"
  >
    <div
      v-if="typeOfComponent < 4 && typeOfComponent > 0"
      class="modalWrapper flexColumn"
    >
      <section v-if="typeOfComponent === 1">
        <h1>
          <slot
            v-if="messageProp == undefined || messageProp.length > 0"
            name="message"
          ></slot>
          {{ messageProp }}
        </h1>
      </section>
      <registroComponent
        @errorCapture="captureFail"
        @loginComponentLink="loginComponentLink"
        v-if="typeOfComponent === 2"
      ></registroComponent>
      <loginComponent
        @errorCapture="captureFail"
        @registerComponentLink="registerComponentLink"
        v-if="typeOfComponent === 3"
      ></loginComponent>
    </div>
    <section id="userPage" class="flexColumn" v-if="typeOfComponent == 4">
      <div class="flexRow justify-content-between align-items-center">
        <h1>
          Seja bem vindo, {{ getTokenUser().userName }} ao painel de
          configurações!
        </h1>
        <i id="modal" class="fa-regular fa-circle-xmark"></i>
      </div>
      <main class="flexColumn">
        <UserPage></UserPage>
      </main>
    </section>
  </section>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import registroComponent from "./Modal-RegistroComponent.vue";
import loginComponent from "./Modal-LoginComponent.vue";
import User from "./UserModel";
import UserPage from "@/views/HomePage/SectionUserPage.vue";
@Options({
  props: {
    modalType: {
      type: Number,
      require: true,
    },
    message: {
      type: String,
      require: false,
    },
  },
  emits: ["setVisible"],
  components: { registroComponent, loginComponent, UserPage },
  created() {
    if (
      ((this.modalType == 2 || this.modalType == 3) &&
        User.getToken().token !== null) ||
      (this.modalType == 4 && User.getToken().token == null)
    )
      this.$emit("setVisible");
  },
  methods: {
    closeModalOnClick() {
      window.addEventListener("click", (event: Event) => {
        if ((event.target as HTMLElement).getAttribute("id") == "modal") {
          if (this.lastOpenedComponent == 0) this.$emit("setVisible");
          else {
            this.typeOfComponent = this.lastOpenedComponent;
            this.lastOpenedComponent = 0;
          }
        }
      });
    },
  },
  mounted() {
    this.messageProp = this.message;
    this.closeModalOnClick();
    document.querySelector("#modal")?.classList.add("fade-in-top");
    this.typeOfComponent = this.modalType;
    document.body.setAttribute("style", "overflow:hidden");
    document.querySelector("#modal")?.scrollIntoView({ behavior: "auto" });
  },
  beforeUnmount() {
    document.body.setAttribute("style", "");
  },
})
export default class ModalComponent extends Vue {
  typeOfComponent = 0;
  messageProp = "";
  lastOpenedComponent = 0;
  captureFail(message: string, redirect = false) {
    if (redirect) this.lastOpenedComponent = this.typeOfComponent;
    this.typeOfComponent = 1;
    this.messageProp = message;
  }
  registerComponentLink() {
    this.typeOfComponent = 2;
  }
  loginComponentLink() {
    this.typeOfComponent = 3;
  }
  getTokenUser() {
    return User.getToken();
  }
}
</script>
<style scoped>
section#modal {
  background-color: rgba(0, 0, 0, 0.705);
  width: 100%;
  height: 100%;
  position: fixed;
  z-index: 99;
  top: 0;
  left: 0;
  padding-top: 4%;
}
div.modalWrapper {
  background-color: var(--corPreto);
  border: 0.2vw solid var(--corBranco);
  width: 30%;
  min-width: 300px;
  border-radius: 1.2vw;
  color: var(--corBranco);
  padding: 2%;
  overflow: auto;
}
h1 {
  font-size: 1.2vw;
  font-weight: 900;
  text-transform: uppercase;
}
section#userPage {
  width: 95%;
  height: 95%;
  background-color: var(--corPreto);
  border: 2px solid white;
  padding: 1%;
}
section#userPage main {
  width: 100%;
  height: 92%;
}
section#userPage div {
  padding: 0 2%;
  height: 8%;
}
section#userPage h1 {
  font-size: 1.2vw;
  color: var(--corBranco);
  text-transform: uppercase;
}
section#userPage i {
  font-size: 2vw;
  cursor: pointer;
  background-color: var(--corAzul);
  color: var(--corAmarelo);
  height: 100%;
  padding: 0 1%;
  display: flex;
  align-items: center;
  margin-bottom: 1%;
}
@media (max-width: 1500px) {
  h1 {
    font-size: 25px;
  }
  div.modalWrapper {
    width: 60%;
  }
  section#userPage h1 {
    font-size: 22px;
    color: var(--corBranco);
    text-transform: uppercase;
  }
  section#userPage i {
    font-size: 40px;
    cursor: pointer;
    color: var(--corAmarelo);
    padding: 0 2%;
  }
}
@media (max-width: 800px) {
  section#userPage main {
    height: 90%;
  }
  section#userPage div {
    height: 10%;
  }
}
@media (max-width: 500px) {
  section#userPage main {
    height: 85%;
  }
  section#userPage div {
    height: 15%;
  }
  div.modalWrapper {
    width: 90%;
    padding: 4%;
  }
}
@media (max-width: 350px) {
  section#userPage main {
    height: 80%;
  }
  section#userPage div {
    height: 20%;
  }
}
.fade-in-top {
  -webkit-animation: fade-in-top 0.6s cubic-bezier(0.39, 0.575, 0.565, 1) both;
  animation: fade-in-top 0.6s cubic-bezier(0.39, 0.575, 0.565, 1) both;
}
.fade-out-top {
  -webkit-animation: fade-out-top 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
  animation: fade-out-top 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
}
/* ----------------------------------------------
 * Generated by Animista on 2023-5-30 13:14:9
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info.
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation fade-out-top
 * ----------------------------------------
 */
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

/* ----------------------------------------------
 * Generated by Animista on 2023-5-30 10:56:6
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info.
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation fade-in-top
 * ----------------------------------------
 */
@-webkit-keyframes fade-in-top {
  0% {
    -webkit-transform: translateY(-50px);
    transform: translateY(-50px);
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
  }
}
@keyframes fade-in-top {
  0% {
    -webkit-transform: translateY(-50px);
    transform: translateY(-50px);
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
  }
}
</style>
