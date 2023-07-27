<script>
import { store } from '../store/store';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import axios from 'axios';
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
      min_price: store.currentFilters.min_price ? store.currentFilters.min_price : 0,
      max_price: store.currentFilters.max_price ? store.currentFilters.max_price : 0,
      min_square_meters: store.currentFilters.min_square_meters ? store.currentFilters.min_square_meters : 0,
      services: store.currentFilters.services ? store.currentFilters.services : [],
      min_rooms: store.currentFilters.min_rooms ? store.currentFilters.min_rooms : 1,
      min_bathrooms: store.currentFilters.min_bathrooms ? store.currentFilters.min_bathrooms : 1,
      min_beds: store.currentFilters.min_beds ? store.currentFilters.min_beds : 1,
      max_radius: store.currentFilters.max_radius ? store.currentFilters.max_radius : 20,

    }
  },

  methods: {

    clearFilter(){
      this.min_price=  0,
      this.max_price=  0,
      this.min_square_meters=  0,
      this.services=  [],
      this.min_rooms=  1,
      this.min_bathrooms= 1,
      this.min_beds=  1,
      this.max_radius=  20
    },

    filterApartments(){
      let default_max_price;
      if(this.max_price == 0 ){
        default_max_price = 100000
      }else{
        default_max_price = this.max_price
      }

      store.currentFilters = {}
      if(this.services.length > 0){
        axios.get("http://127.0.0.1:8000/api/apartments/" + this.min_price + '/' + default_max_price + '/' + this.min_square_meters + '/' + this.min_bathrooms + '/' + this.min_beds + '/' + this.min_rooms + '/' + this.services + '/' + store.search + '/' + this.max_radius / 100)
        .then(result => {
          store.searchedApartments = result.data.apartments

          store.currentFilters = {
        min_price: this.min_price,
        max_price: this.max_price,
        min_square_meters: this.min_square_meters,
        services: this.services,
        min_rooms: this.min_rooms,
        min_bathrooms: this.min_bathrooms,
        min_beds:this.min_beds ,
        max_radius: this.max_radius,
      }
        })
      }else{
        axios.get("http://127.0.0.1:8000/api/apartments/" + this.min_price + '/' + default_max_price + '/' + this.min_square_meters + '/' + this.min_bathrooms + '/' + this.min_beds + '/' + this.min_rooms + '/' + store.search + '/' + this.max_radius / 100)
        .then(result => {
          store.searchedApartments = result.data.apartments

          store.currentFilters = {
          min_price: this.min_price,
          max_price: this.max_price,
          min_square_meters: this.min_square_meters,
          services: this.services,
          min_rooms: this.min_rooms,
          min_bathrooms: this.min_bathrooms,
          min_beds:this.min_beds ,
          max_radius: this.max_radius,
      }
        })

      }
    }
  },

  mounted() {
    store.getServices();

  }
}
</script>

<template>

  <div class="advanced-search">
    <!-- button+searchbar -->
    <div class="t4-container d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 ">
      <div class="d-none d-lg-block"></div>
      <div class="searchbar">
        <MainSearchbar />
      </div>
      <div>
        <a class="btn btn-filters t4-btn d-flex align-items-center m-3 m-md-0" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
          <i class="fa-solid fa-gears me-2 fs-6"></i>
          <span class="me-1">Filtri</span>
        </a>
      </div>
    </div>
    <!-- /button+searchbar -->

    <div v-if="store.searchedApartments" class="t4-container">
      <h2 class="text-center text-md-start mb-4 pt-3 fw-semibold">Risultati della ricerca</h2>
      <div class="row">
        <div v-for="apartment in store.searchedApartments" :key="apartment.id" class="px-4 px-lg-3 col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <ApartmentCard
            :apartment="apartment"
            :link_name="'apartment-detail-guest'"/>
        </div>
      </div>
    </div>
    <div v-else>
      <h2 class="mb-4 pt-5 mb-4 fw-semibold d-flex justify-content-center h-100 py-5 mb-0">Cerca un appartamento !</h2>
    </div>

    <!-- ------ offcanvas ------ -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h2 class="offcanvas-title fs-3 fw-semibold" id="offcanvasExampleLabel">Filtri</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <!-- price -->
        <div class="price py-2">
          <h5 class="fw-semibold">Fascia di prezzo :</h5>
          <div class="d-flex">
            <div class="d-flex align-items-center">
              <label for="min_price"><i class="fa-solid fa-euro-sign"></i></label>
              <input
              v-model="min_price"
              class="form-control"
              placeholder="Min."
              name="min_price"
              id="min_price"
              type="number"
              min="0">
            </div>
            <div class="d-flex align-items-center">
              <label for="max_price"><i class="fa-solid fa-euro-sign"></i></label>
              <input
              v-model="max_price"
              class="form-control"
              placeholder="Max."
              name="max_price"
              id="max_price"
              type="number"
              min="0">
            </div>
          </div>
        </div>
        <!-- /price -->

        <!-- sqrmeters -->
        <div class="sqr-meters pb-2">
          <h5 class="fw-semibold">Mt <sup>2</sup> :</h5>
          <div class="d-flex align-items-center">
            <label for="sqr_meters"><i class="fa-solid fa-expand"></i></label>
            <input
              v-model="min_square_meters"
              class="form-control"
              placeholder="Metratura minima"
              name="sqr_meters"
              id="sqr_meters"
              type="number"
              min="0">
          </div>
        </div>
        <!-- /sqrmeters -->

        <!-- services -->
        <div class="services pb-2">
          <h5 class="fw-semibold mb-3">Servizi :</h5>
          <div class="row row-cols-4 justify-content-between">
            <div v-for="(service, index) in store.availableServices" :key="service.id" class="col d-flex justify-content-center mb-3">
              <div class="icon btn-group" role="group">
                <input
                  v-model="services"
                  type="checkbox"
                  class="btn-check"
                  :id="'btncheck' + (index+1)"
                  :value="service.id"
                  autocomplete="off">
                <label class="btn btn-check-label p-2" :for="'btncheck' + (index + 1)">
                  <img :src="`/img/services-icons/${service.slug}.png`" :alt="service.name">
                </label>
              </div>
            </div>
          </div>
        </div>
        <!-- /services -->

        <!-- details -->
        <div class="details pb-2">
          <div class="rooms mb-3">
            <h5 class="fw-semibold mb-3">Stanze :</h5>
              <input
                v-model="min_rooms"
                type="radio"
                class="btn-check btn-outline-secondary"
                name="rooms"
                id="rooms_1"
                value= "1"
                checked
                autocomplete="off">
              <label class="btn btn-check-label me-4" for="rooms_1">1</label>
              <input
                v-model="min_rooms"
                type="radio"
                class="btn-check"
                name="rooms"
                value= "2"
                id="rooms_2">
              <label class="btn btn-check-label me-4" for="rooms_2">2</label>
              <input
                v-model="min_rooms"
                type="radio"
                class="btn-check"
                name="rooms"
                id="rooms_3"
                value= "3"
                autocomplete="off">
              <label class="btn btn-check-label me-4" for="rooms_3">3</label>
              <input
                v-model="min_rooms"
                type="radio"
                class="btn-check"
                name="rooms"
                id="rooms_4"
                value= "4"
                autocomplete="off">
              <label class="btn btn-check-label me-4" for="rooms_4">4</label>
              <input
                v-model="min_rooms"
                type="radio"
                class="btn-check"
                name="rooms"
                id="rooms_5"
                value= "5"
                autocomplete="off">
              <label class="btn btn-check-label me-4" for="rooms_5">5</label>
              <input
                v-model="min_rooms"
                type="radio"
                class="btn-check"
                name="rooms"
                id="rooms_6"
                value= "6"
                autocomplete="off">
              <label class="btn btn-check-label" for="rooms_6">6+</label>
          </div>
          <div class="beds mb-3">
            <h5 class="fw-semibold mb-3">Letti :</h5>
            <input
              v-model="min_beds"
              type="radio"
              class="btn-check"
              name="beds"
              id="beds_1"
              value= "1"
              autocomplete="off">
            <label class="btn btn-check-label me-4" for="beds_1">1</label>
            <input
              v-model="min_beds"
              type="radio"
              class="btn-check"
              name="beds"
              id="beds_2"
              value= "2"
              autocomplete="off">
            <label class="btn btn-check-label me-4" for="beds_2">2</label>
            <input
              v-model="min_beds"
              type="radio"
              class="btn-check"
              name="beds"
              id="beds_3"
              value= "3"
              autocomplete="off">
            <label class="btn btn-check-label me-4" for="beds_3">3</label>
             <input
              v-model="min_beds"
              type="radio"
              class="btn-check"
              name="beds"
              id="beds_4"
              value= "4"
              autocomplete="off">
            <label class="btn btn-check-label me-4" for="beds_4">4</label>
            <input
              v-model="min_beds"
              type="radio"
              class="btn-check"
              name="beds"
              id="beds_5"
              value= "5"
              autocomplete="off">
            <label class="btn btn-check-label me-4" for="beds_5">5</label>
            <input
              v-model="min_beds"
              type="radio"
              class="btn-check"
              name="beds"
              id="beds_6"
              value= "6"
              autocomplete="off">
            <label class="btn btn-check-label" for="beds_6">6+</label>
          </div>
          <div class="bathrooms mb-3">
            <h5 class="fw-semibold mb-3">Bagni :</h5>
              <input
                v-model="min_bathrooms"
                type="radio"
                class="btn-check btn-outline-secondary"
                name="bathrooms"
                id="bathrooms_1"
                autocomplete="off"
                value= "1">
              <label class="btn btn-check-label me-4" for="bathrooms_1">1</label>
              <input
                v-model="min_bathrooms"
                type="radio"
                class="btn-check"
                name="bathrooms"
                id="bathrooms_2"
                autocomplete="off"
                value= "2">
              <label class="btn btn-check-label me-4" for="bathrooms_2">2</label>
              <input
                v-model="min_bathrooms"
                type="radio"
                class="btn-check"
                name="bathrooms"
                id="bathrooms_3"
                autocomplete="off"
                value= "3">
              <label class="btn btn-check-label me-4" for="bathrooms_3">3</label>
               <input
                v-model="min_bathrooms"
                type="radio"
                class="btn-check"
                name="bathrooms"
                id="bathrooms_4"
                autocomplete="off"
                value= "4">
              <label class="btn btn-check-label me-4" for="bathrooms_4">4</label>
              <input
                v-model="min_bathrooms"
                type="radio"
                class="btn-check"
                name="bathrooms"
                id="bathrooms_5"
                autocomplete="off"
                value= "5">
              <label class="btn btn-check-label me-4" for="bathrooms_5">5</label>
              <input
                v-model="min_bathrooms"
                type="radio"
                class="btn-check"
                name="bathrooms"
                id="bathrooms_6"
                autocomplete="off"
                value= "6">
              <label class="btn btn-check-label" for="bathrooms_6">6+</label>
          </div>
        </div>
        <!-- /rooms and beds -->

        <!-- range -->
        <div class="range pb-3">
          <label for="customRange" class="form-label"><h5 class="fw-semibold mb-1">Raggio :</h5></label>
          <div class="d-flex">
            <input type="range" class="form-range custom-range" v-model="max_radius" min="20" max="60" step="10" id="customRange">
          </div>
          <div class="d-flex justify-content-between">
            <div class="km fw-semibold">20km</div>
            <div class="km fw-semibold ">30km</div>
            <div class="km fw-semibold ">40km</div>
            <div class="km fw-semibold">50km</div>
            <div class="km fw-semibold">60km</div>
          </div>
        </div>
        <!-- /range -->


      </div>

      <div class="d-flex justify-content-end offcanvas-footer py-3 pe-4">
        <button @click="filterApartments" class="btn btn-filters t4-btn d-flex align-items-center">
          <i class="fa-solid fa-gears me-2 fs-6"></i>
          <span class="me-1">Filtra</span>
        </button>
        <button @click="clearFilter" class="btn btn-filters t4-btn d-flex align-items-center ms-4">
          <span class="me-1">Pulisci il filtro</span>
        </button>
      </div>

    </div>
    <!-- ------ /offcanvas ------ -->
  </div>
  <Footer />
</template>

<style lang="scss" scoped>

@use "../../scss/partials/variables" as *;

.advanced-search {
  min-height: calc(100vh - 431px);
  color: $dark_gray;
  background-color: $dark_white;

  .searchbar {
    margin-left: 148px;
  }

  .btn-filters {
    font-size: 0.9rem;
  }

  .offcanvas {
    background-color: $dark-gray;
    color: white;

    .offcanvas-header {
      background-color: $dark-white;
      color: $dark-gray;
      border-bottom: 1px solid gray;
      padding: 10px 16px;
    }

    .btn-close {
      &:focus {
        border: none;
        outline: none;
        box-shadow: none;
      }
    }

    .km {
      font-size: 0.8rem;
    }

    .btn-check-label {
      background-color: $dark-white;
      color: $dark-gray;
    }

    .btn-check:checked+label {
      background-color: $light-blue;
      color: white;
      border: 0;

      img {
        filter: brightness(0) invert(1);
      }
    }

    .custom-range::-webkit-slider-thumb {
      background: $light-blue;
      box-shadow: none;

    }

    .custom-range::-moz-range-thumb {
      background: $light-blue;
      box-shadow: none;
    }

    .custom-range::-ms-thumb {
      background: $light-blue;
      box-shadow: none;
    }

    input {
      background-color: $dark-gray;
      border: 0;
      color: white;
      font-size: 0.95rem;

      &::placeholder {
        color: $dark-white;
      }

      &:focus {
        border: none;
        outline: none;
        box-shadow: none;
      }
    }

    .price,
    .sqr-meters,
    .services,
    .details {
      border-bottom: 1px solid gray;
      margin-bottom: 20px;
    }

    .services {
      .icon {
        width: 55%;

        img {
          width: 100%;
        }
      }
    }

    .offcanvas-footer {
      background-color: $dark_white;
    }

  }

}

//media-query
@media screen and (max-width: 1000px) {
  .advanced-search {
    .searchbar {
      margin-left: 0;
    }
    .btn-filters {
    width: 90px;
  }
  }
}

</style>
