<script>
import MainSearchbar from './MainSearchbar.vue';

export default {
  name: "Jumbotron",

  components: {
    MainSearchbar
  },

  methods: {
    getImage(img) {
      return new URL(`../../assets/img/home-carousel/${img}`, import.meta.url).href
    }
  }
}

</script>

<template>
  <div class="jumbotron">
    <div id="jumbotronCarousel" class="carousel slide" data-bs-pause="false" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img :src="getImage('slide-1.jpg')" class="d-block w-100" alt="slide-1">
        </div>
        <div class="carousel-item">
          <img :src="getImage('slide-2.jpg')" class="d-block w-100" alt="slide-2">
        </div>
        <div class="carousel-item">
          <img :src="getImage('slide-3.jpg')" class="d-block w-100" alt="slide-2">
        </div>
      </div>
    </div>

    <div class="content d-flex flex-column align-items-center">
      <h1 class="mb-2">BoolBnB</h1>
      <p class="text-center mb-3">Cerca subito la destinazione della tua prossima vacanza e trova l'alloggio perfetto per te!</p>
      <MainSearchbar/>
    </div>

  </div>
</template>

<style lang="scss" scoped>
.jumbotron {
  position: relative;
  height: calc(100vh - 70px);
  overflow: hidden;

  .carousel-item{
    position: relative;

    &::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }
  }

   p {
    max-width: 400px;
  }

  .content {
    color: white;
    position: absolute;
    top: 38%;
    left: 50%;
    transform: translate(-50%);
  }

}
</style>
