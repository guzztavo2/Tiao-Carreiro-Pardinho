<template>
  <!-- <MainSection></MainSection> -->
  <!-- <SectionAbout></SectionAbout> -->
  <!-- <SectionAbout2></SectionAbout2> -->
  <SectionMusicas></SectionMusicas>
</template>
<script lang="ts">
import { Options, Vue } from "vue-class-component";
import MainSection from "./HomePage/SectionMainView.vue";
import SectionAbout from "./HomePage/SectionAboutView.vue";
import SectionAbout2 from "./HomePage/SectionAbout2View.vue";
import SectionMusicas from "./HomePage/SectionMusicasView.vue";
@Options({
  components: {
    MainSection,
    SectionAbout,
    SectionAbout2,
    SectionMusicas,
  },
})
export default class HomeView extends Vue {}
</script>
