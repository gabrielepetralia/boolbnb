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
  },

}

</script>

<template>
  <div class="jumbotron">
    <img class="mobile-background" src="../../assets/img/home-carousel/slide-1.jpg" alt="">
    <div class="overlay"></div>
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
      <img class="logo" src="/img/logo-big-light.svg" alt="Logo">
      <p class="text-center mb-3">Cerca la destinazione della tua prossima vacanza e trova subito l'alloggio perfetto per te!</p>
      <div class="searchbar">
        <MainSearchbar/>
      </div>
    </div>

  </div>
</template>

<style lang="scss" scoped>
  .mobile-background {
    display: none;
  }
.jumbotron {
  position: relative;
  height: calc(100vh - 70px);
  overflow: hidden;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);

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
    font-size: 1.1rem;
    color: white;
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%);

    .logo {
      width: 300px;
    }
  }

  .searchbar {
    margin-left: 58px;
  }

}

// media query

@media screen and (max-width: 1400px) {
  .jumbotron {
    height: 100vh;
    .overlay {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background-color: rgba(0,0,0,0.5);
    }
  }
  #jumbotronCarousel {
    display: none;
  }
  .mobile-background {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
@media screen and (max-width: 400px) {
  .jumbotron
    .searchbar {
      margin-left: 0;
    }
}

</style>
