<script>
import { store } from '../store/store';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import Footer from '../components/partials/Footer.vue';
import MainSearchbar from '../components/partials/MainSearchbar.vue';
export default {
  name : "AdvancedSearch",
  components: {
    ApartmentCard,
    Footer,
    MainSearchbar
  },
  data() {
    return {
      store,
      services_icons: [
      "animali-ammessi",
      "aria-condizionata",
      "colazione",
      "piscina",
      "posto-macchina",
      "riscaldamento",
      "vista-mare",
      "wifi",
      ]
    }
  },
  methods: {
    getImage(img) {
      return new URL(`../assets/img/services-icons/${img}.png`, import.meta.url).href
    }
  }
}
</script>

<template>

  <div class="advanced-search">
    <!-- offcanvas---------------------------------------------------------------------- -->
    <!-- button+searchbar -->
    <div class="inputs d-flex justify-content-between px-5 py-2">
      <div class="button d-flex align-items-center">
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
          <i class="fa-solid fa-filter"></i>
          <span class="px-2">Filtri</span>
        </a>
      </div>
      <div class="searchbar">
        <MainSearchbar />
      </div>
    </div>
    <!-- /button+searchbar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Ordina per:</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <!-- price -->
        <div class="price">
          <h5>Fascia di prezzo:</h5>
          <div class="min d-flex filter-input">
            <label for="min_price"><i class="fa-solid fa-euro-sign"></i></label>
            <input placeholder="Inserire un prezzo minimo" name="min_price" id="min_price" type="number">
          </div>
          <div class="max d-flex filter-input">
            <label for="max_price"><i class="fa-solid fa-euro-sign"></i></label>
            <input placeholder="Inserire un prezzo massimo" name="max_price" id="max_price" type="number">
          </div>
        </div>
        <!-- /price -->
        <!-- sqrmeters -->
        <div class="sqr-meters">
          <h5>Metri quadri:</h5>
          <div class="d-flex filter-input">
            <label for="min_price"><i class="fa-solid fa-expand"></i></label>
            <input placeholder="Inserire una metratura minima" name="min_price" id="min_price" type="number">
          </div>
        </div>
        <!-- /sqrmeters -->
        <!-- services -->
        <div class="services">
          <h5>Servizi:</h5>
          <div class="services-boxes">
            <div v-for="(icon, index) in this.services_icons" :key="index" class="service">
              <div class="icon">
                <img :src="getImage(icon)" alt="">
              </div>
              <div class="input">
                <input type="checkbox">
              </div>
            </div>
          </div>
        </div>
        <!-- /services -->
        <!-- rooms and beds -->
        <div class="rooms-beds">
          <h5>Stanze e bagni:</h5>
          <div class="rooms">
            <h6>Stanze</h6>
              <input type="radio" class="btn-check btn-outline-secondary" name="rooms" id="rooms_1" autocomplete="off" checked>
              <label class="btn btn-outline-secondary me-4" for="rooms_1">1</label>
              <input type="radio" class="btn-check" name="rooms" id="rooms_2" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="rooms_2">2</label>
              <input type="radio" class="btn-check" name="rooms" id="rooms_3" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="rooms_3">3</label>
              <input type="radio" class="btn-check" name="rooms" id="rooms_4" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="rooms_4">4</label>
              <input type="radio" class="btn-check" name="rooms" id="rooms_5" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="rooms_5">5</label>
              <input type="radio" class="btn-check" name="rooms" id="rooms_6" autocomplete="off">
              <label class="btn btn-outline-secondary" for="rooms_6">6+</label>
          </div>
          <div class="bathrooms">
            <h6>Bagni</h6>
            <input type="radio" class="btn-check btn-outline-secondary" name="bathrooms" id="bathrooms_1" autocomplete="off" checked>
              <label class="btn btn-outline-secondary me-4" for="bathrooms_1">1</label>
              <input type="radio" class="btn-check" name="bathrooms" id="bathrooms_2" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="bathrooms_2">2</label>
              <input type="radio" class="btn-check" name="bathrooms" id="bathrooms_3" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="bathrooms_3">3</label>
              <input type="radio" class="btn-check" name="bathrooms" id="bathrooms_4" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="bathrooms_4">4</label>
              <input type="radio" class="btn-check" name="bathrooms" id="bathrooms_5" autocomplete="off">
              <label class="btn btn-outline-secondary me-4" for="bathrooms_5">5</label>
              <input type="radio" class="btn-check" name="bathrooms" id="bathrooms_6" autocomplete="off">
              <label class="btn btn-outline-secondary" for="bathrooms_6">6+</label>
          </div>
          <div class="beds">
            <h6>Letti</h6>
            <input type="radio" class="btn-check btn-outline-secondary" name="beds" id="beds_1" autocomplete="off" checked>
            <label class="btn btn-outline-secondary me-4" for="beds_1">1</label>
            <input type="radio" class="btn-check" name="beds" id="beds_2" autocomplete="off">
            <label class="btn btn-outline-secondary me-4" for="beds_2">2</label>
            <input type="radio" class="btn-check" name="beds" id="beds_3" autocomplete="off">
            <label class="btn btn-outline-secondary me-4" for="beds_3">3</label>
            <input type="radio" class="btn-check" name="beds" id="beds_4" autocomplete="off">
            <label class="btn btn-outline-secondary me-4" for="beds_4">4</label>
            <input type="radio" class="btn-check" name="beds" id="beds_5" autocomplete="off">
            <label class="btn btn-outline-secondary me-4" for="beds_5">5</label>
            <input type="radio" class="btn-check" name="beds" id="beds_6" autocomplete="off">
            <label class="btn btn-outline-secondary" for="beds_6">6+</label>
          </div>
        </div>
        <!-- /rooms and beds -->
        <!-- range -->
        <div class="range">
          <label for="customRange1" class="form-label"><h5>Raggio:</h5></label>
          <div class="d-flex">
            <input type="range" class="form-range" id="customRange1">
          </div>
        </div>
        <!-- /range -->
      </div>
    </div>
    <!-- /offcanvas---------------------------------------------------------------------- -->
    <div class="search">
    </div>
    <div v-if="store.searchedApartments" class="t4-container">
      <h2 class="mb-4 pt-5 mb-4 fw-semibold">Risultati della ricerca</h2>
      <div class="row row-cols-6">
        <ApartmentCard
        v-for="apartment in store.searchedApartments"
          :key="apartment.id"
          :apartment="apartment"
          :link_name="'apartment-detail-guest'"/>
      </div>
    </div>
    <div v-else>
      <h2 class="mb-4 pt-5 mb-4 fw-semibold d-flex justify-content-center h-100 py-5 mb-0">Cerca un appartamento !</h2>
    </div>
  </div>
  <Footer />
</template>

<style lang="scss" scoped>

@use "../../scss/partials/variables" as *;

.advanced-search {
  min-height: calc(100vh - 431px);
  color: $dark_gray;
  background-color: $dark_white;
  input {
      border: 0;
      width: 100%;
      &:focus {
        border: none;
        outline: none;
      }
    }
    .filter-input {
      border-bottom: 1px solid $dark-gray;
      width: 100%;
      margin-bottom: 8px;
      padding: .5rem;
      i {
        margin-right: 5px;
      }
    }
  .inputs {
    .button {
      a {
        background: $dark-gray;
        border: 0;
      &:hover {
        background: $light-blue;
      }
      }
    }
  }
  .price {
    .min, .max {
      border-bottom: 1px solid $dark-gray;
    }
  }
  .range {
    border-bottom: 1px solid $dark-gray;
  }
  .services {
    border-bottom: 1px solid $dark-gray;
    .services-boxes {
      display: flex;
      flex-wrap: wrap;
      padding: 5px 0;
      .service {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 14%;
        margin: 10px 15px;
        .icon {
          margin-right: 5px;
          img {
            width: 30px;
          }
        }
      }
    }
  }
  .rooms-beds {
    border-bottom: 1px solid $dark-gray;
    h5 {
      margin-bottom: 15px;
    }
    div {
      margin-bottom: 20px;
    }
  }
}
.price, .sqr-meters, .services, .rooms-beds {
  margin-bottom: 40px;
}
</style>
