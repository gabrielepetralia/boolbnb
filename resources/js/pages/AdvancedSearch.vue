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
      min_price: 0,
      max_price: 0,
      min_square_meters: 0,
      services: [],
      min_rooms: 1,
      min_bathrooms: 1,
      min_beds: 1,
      max_radius: 0,

    }
  },

  methods: {
    filterApartments(){
      let default_max_price;
      if(this.max_price == 0 ){
        default_max_price = 100000
      }else{
        default_max_price = this.max_price
      }

      let default_max_radius;
      if(this.max_radius == 0){
        default_max_radius = 0.01
      }else {
        default_max_radius = this.max_radius / 100
      }
      if(this.services.lenth >= 0){

        axios.get("http://127.0.0.1:8000/api/apartments/" + this.min_price + '/' + default_max_price + '/' + this.min_square_meters + '/' + this.min_bathrooms + '/' + this.min_beds + '/' + this.min_rooms + '/' + this.services + '/' + store.search + '/' + default_max_radius)
        .then(result => {
          store.searchedApartments = result.data.apartments
        })
      }else{
        axios.get("http://127.0.0.1:8000/api/apartments/" + this.min_price + '/' + default_max_price + '/' + this.min_square_meters + '/' + this.min_bathrooms + '/' + this.min_beds + '/' + this.min_rooms + '/' + store.search + '/' + default_max_radius)
        .then(result => {
          store.searchedApartments = result.data.apartments
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
    <div class="t4-container d-flex justify-content-between pt-4 ">
      <div></div>
      <div class="searchbar">
        <MainSearchbar />
      <div>
    </div>
      </div>
      <div>
        <a class="btn btn-filters t4-btn d-flex align-items-center" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
          <i class="fa-solid fa-gears me-2 fs-6"></i>
          <span class="me-1">Filtri</span>
        </a>
      </div>
    </div>
    <!-- /button+searchbar -->

    <div v-if="store.searchedApartments" class="t4-container">
      <h2 class="mb-4 pt-3 mb-4 fw-semibold">Risultati della ricerca</h2>
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
              placeholder="Inserire un prezzo minimo"
              name="min_price"
              id="min_price"
              type="number"
              min="0">
            </div>
            <div class="d-flex align-items-center">
              <label for="max_price"><i class="fa-solid fa-euro-sign"></i></label>
              <input
              v-model="max_price"
              placeholder="Inserire un prezzo massimo"
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
              placeholder="Inserire una metratura minima"
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
          <label for="customRange1" class="form-label"><h5 class="fw-semibold">Raggio :</h5></label>
          <div class="d-flex">
            <input type="range" v-model="max_radius" class="form-range custom-range" min="0" max="5" step="1" value="0" id="customRange1">
          </div>
          <div class="d-flex justify-content-between">
            <div class="km fw-semibold">20km</div>
            <div class="km fw-semibold">30km</div>
            <div class="km fw-semibold">40km</div>
            <div class="km fw-semibold">50km</div>
            <div class="km fw-semibold">60km</div>
            <div class="km fw-semibold">70km</div>
          </div>
        </div>
        <!-- /range -->
        
      </div>
      <div class="btn" @click="filterApartments">Invia</div>
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

  .km {
    font-size: 0.8rem;
  }

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
      font-size: 1rem;

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
    .range,
    .services,
    .details,
    .range {
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

  }

}

</style>
