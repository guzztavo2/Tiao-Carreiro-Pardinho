<template>
  <HeaderApp></HeaderApp>
  <HomeView></HomeView>
</template>
<script lang="ts">
import HeaderApp from "./components/header.vue";
import HomeView from "./views/HomeView.vue";
import { Vue, Options } from "vue-class-component";
@Options({
  components: { HeaderApp, HomeView },
  mounted() {
    console.log(process.env);
  },
})
export default class App extends Vue {}
</script>
<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: "Raleway", sans-serif;
  --corPreto: #000000;
  --corAzul: #14213d;
  --corAmarelo: #fca311;
  --corCinza: #e5e5e5;
  --corBranco: #ffffff;
}
html,
body {
  height: 100%;
}
#app {
  height: 100%;
}
.flexRow {
  display: flex;
  flex-flow: row nowrap;
}
.flexColumn {
  display: flex;
  flex-flow: column nowrap;
}
.align-items-center {
  align-items: center;
}
.justify-content-center {
  justify-content: center;
}
.justify-content-around {
  justify-content: space-around;
}
.justify-content-between {
  justify-content: space-between;
}
.justify-content-evenly {
  justify-content: space-evenly;
}
.d-none {
  display: none;
}
.w-100 {
  width: 100%;
}
.w-50 {
  width: calc(100% / 2 - 2%);
  margin: 0 1%;
}
.w-25 {
  width: calc(100% / 3 - 2%);
  margin: 0 1%;
}
</style>
