<template>
  <nav class="flexRow align-items-center justify-content-around">
    <div
      @click="panel_registerLogin"
      id="userAccountClick"
      class="user-click-wrapper"
    >
      <i class="fa-solid fa-user" id="userAccountClick"></i>
      <div
        v-if="panelRegisterLogin.isVisible"
        id="userAccountClick"
        class="user-wrapper flexColumn align-items-center"
      >
        <a><i class="fa-solid fa-address-card"></i>registro</a>
        <a> <i class="fa-solid fa-user"></i> login</a>
      </div>
    </div>
  </nav>
  <ModalComponent></ModalComponent>
</template>
<script lang="ts">
import { Vue, Options } from "vue-class-component";
import ModalComponent from "./ModalComponent.vue";
@Options({ components: { ModalComponent } })
export default class HeaderApp extends Vue {
  panelRegisterLogin = {
    isVisible: false,
    user_wrapper: () => {
      return document.getElementsByClassName("user-wrapper")[0];
    },
  };

  panel_registerLogin() {
    const element = { element: this.panelRegisterLogin.user_wrapper };
    const event = (event: Event) => {
      if (this.panelRegisterLogin.isVisible) {
        if (
          (event.target as HTMLElement).getAttribute("id") == "userAccountClick"
        )
          return;
        HeaderApp.animation(true, element);
        setTimeout(() => {
          this.panelRegisterLogin.isVisible = false;
        }, 400);
      }
    };
    const eventListener = (remove: boolean) => {
      if (!remove) window.addEventListener("click", event);
      else window.removeEventListener("click", event);
    };
    const isVisible = this.panelRegisterLogin.isVisible;
    if (isVisible) {
      HeaderApp.animation(isVisible, element);
      setTimeout(() => {
        this.panelRegisterLogin.isVisible = !isVisible;
      }, 400);
      eventListener(isVisible);
    } else {
      eventListener(isVisible);
      this.panelRegisterLogin.isVisible = !isVisible;
      this.$nextTick(() => {
        HeaderApp.animation(isVisible, element);
      });
    }
  }

  // eslint-disable-next-line @typescript-eslint/ban-types
  private static animation(isVisible: boolean, element: { element: Function }) {
    if (isVisible) {
      element.element().classList.remove("fade-in-top");
      element.element().classList.add("fade-out-top");
    } else {
      element.element().classList.remove("fade-out-top");
      element.element().classList.add("fade-in-top");
    }
  }
}
</script>
<style scoped>
nav {
  width: 100%;
  background-color: var(--corPreto);
  padding: 1%;
  position: relative;
  border-bottom: 0.1vw solid white;
  box-shadow: 0 0 0.1vw white;
}
a {
  font-size: 1.2vw;
  padding: 2%;
  text-decoration: none;
  color: var(--corBranco);
}
i {
  font-size: 2vw;
}

div.user-click-wrapper {
  position: relative;
  background-color: var(--corAmarelo);
  padding: 1% 1.5%;
  cursor: pointer;
  border: 0.1vw solid var(--corBranco);
  box-shadow: 0 0 0.2vw var(--corBranco);
  transition: ease-in-out 0.2s;
}
div.user-click-wrapper:hover {
  background-color: var(--corAzul);
  color: var(--corBranco);
}
div.user-wrapper {
  position: absolute;
  background-color: var(--corAzul);
  border: 0.1vw solid white;
  padding: 2%;
  font-weight: 600;
  text-transform: capitalize;
  width: calc(100% * 2);
  top: 102%;
  left: 50%;
  transform: translateX(-50%);
}
div.user-wrapper a {
  width: 100%;
  display: flex;
  flex-flow: row wrap;
  align-items: center;
  justify-content: space-between;
  text-align: center;
}
div.user-wrapper a,
div.user-wrapper i {
  font-size: 1vw;
  padding: 4%;
  color: var(--corBranco);
  text-align: center;
}
div.user-wrapper a:hover {
  background-color: var(--corPreto);
}
@media (max-width: 1500px) {
  nav {
    width: 100%;
    background-color: var(--corPreto);
    padding: 2%;
    position: relative;
    border-bottom: 2px solid white;
    box-shadow: 0 0 5px white;
  }
  a {
    font-size: 20px;
    padding: 2%;
  }
  i {
    font-size: 40px;
  }
  div.user-click-wrapper {
    background-color: var(--corAmarelo);
    padding: 2%;
    border: 2px solid var(--corBranco);
    box-shadow: 0 0 3px var(--corBranco);
  }
  div.user-wrapper a,
  div.user-wrapper i {
    font-size: 20px;
    padding: 4%;
    color: var(--corBranco);
    text-align: center;
  }
}
@media (max-width: 710px) {
  div.user-click-wrapper {
    position: unset;
  }
  div.user-wrapper {
    position: absolute;
    width: 80%;
    z-index: 2;
    padding: 0;
  }
  div.user-wrapper a {
    width: 100%;
  }
  div.user-wrapper a,
  div.user-wrapper i {
    font-size: 30px;
    padding: 2% 4%;
    color: var(--corBranco);
    text-align: center;
  }
}
.fade-out-top {
  -webkit-animation: fade-out-top 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
  animation: fade-out-top 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
}
.fade-in-top {
  -webkit-animation: fade-in-top 04s cubic-bezier(0.39, 0.575, 0.565, 1) both;
  animation: fade-in-top 0.4s cubic-bezier(0.39, 0.575, 0.565, 1) both;
}
@-webkit-keyframes fade-in-top {
  0% {
    -webkit-transform: translateY(-50px), translateX(-50%);
    transform: translateY(-50px), translateX(-50%);
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0), translateX(-50%);
    transform: translateY(0), translateX(-50%);
    opacity: 1;
  }
}
@keyframes fade-in-top {
  0% {
    -webkit-transform: translateY(-50px), translateX(-50%);
    transform: translateY(-50px), translateX(-50%);
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0), translateX(-50%);
    transform: translateY(0), translateX(-50%);
    opacity: 1;
  }
}
@-webkit-keyframes fade-out-top {
  0% {
    -webkit-transform: translateY(0), translateX(-50%);
    transform: translateY(0), translateX(-50%);
    opacity: 1;
  }
  100% {
    -webkit-transform: translateY(-50px), translateX(-50%);
    transform: translateY(-50px), translateX(-50%);
    opacity: 0;
  }
}
@keyframes fade-out-top {
  0% {
    -webkit-transform: translateY(0), translateX(-50%);
    transform: translateY(0), translateX(-50%);
    opacity: 1;
  }
  100% {
    -webkit-transform: translateY(-50px), translateX(-50%);
    transform: translateY(-50px), translateX(-50%);
    opacity: 0;
  }
}
</style>
