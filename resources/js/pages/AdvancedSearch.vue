<script>
import { store } from '../store/store';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import axios from 'axios';
import Footer from '../components/partials/Footer.vue';
import MainSearchbar from '../components/partials/MainSearchbar.vue';
import Loader from "../components/partials/Loader.vue";
import tt from '@tomtom-international/web-sdk-maps';


export default {
  name : "AdvancedSearch",
  components: {
    ApartmentCard,
    Footer,
    MainSearchbar,
    Loader
  },
  data() {
    return {
      store,
      mapIsBlock: false,
      map_link: null,
      apiUrl: 'https://api.tomtom.com/search/2/',
      apiKey: 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ',
      _map: {
      lat: null,
      lon: null
      },
      mapVisible: false,
      markers: [],
      min_price: store.currentFilters.min_price ? store.currentFilters.min_price : 0,
      max_price: store.currentFilters.max_price ? store.currentFilters.max_price : 0,
      min_square_meters: store.currentFilters.min_square_meters ? store.currentFilters.min_square_meters : 0,
      services: store.currentFilters.services ? store.currentFilters.services : [],
      min_rooms: store.currentFilters.min_rooms ? store.currentFilters.min_rooms : 1,
      min_bathrooms: store.currentFilters.min_bathrooms ? store.currentFilters.min_bathrooms : 1,
      min_beds: store.currentFilters.min_beds ? store.currentFilters.min_beds : 1,
      max_radius: store.currentFilters.max_radius ? store.currentFilters.max_radius : 20,
      coordinate_x: null,
      coordinate_Y: null,
    }
  },

  watch: {
    'store.apartmentCoordinates': {
      immediate: true,
      handler(newValue) {
        // Chiamata a getMap() solo quando store.apartmentCoordinates è valido
        if (newValue && newValue.length > 0) {
          this.getMap();
          this.filterApartments()
        }
      }
    }
  },

  methods: {
    getView(apartment_id) {
      axios.get('https://api.ipify.org/?format=json')
      .then(response => {
        console.log(response);
        let ip_address = response.data.ip;
        axios.post('/view', {
          apartment_id: apartment_id,
          ip_address: response.data.ip
        })
      })
    },

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

        store.searchedApartments = result.data.apartments;
        store.apartmentCoordinates

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
          store.apartmentCoordinates

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
    },


    getMap(){
      if(store.searchedApartments.length > 0) this.mapIsBlock = true;

      axios.get( 'https://api.tomtom.com/search/2/' + 'geocode/'+this.store.search+'.json?view=Unified&key='+ 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ' )
      .then(result => {

        this._map.lat = result.data.results[0].position.lat;
        this._map.lon = result.data.results[0].position.lon;
        this.coordinates = [this._map.lon,this._map.lat];

        store.searchedApartments = result.data.apartments
        store.apartmentCoordinates


        tt.setProductInfo("maps", "1");

        var map = tt.map({
          key: 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ',
          container: "map",
          center: this.coordinates,
          zoom: 13
        })
        if (this.mapMarker) {
          this.mapMarker.remove();
        }

        for (const markerData of this.store.apartmentCoordinates) {

          this.createCustomMarker(map, [markerData.lon, markerData.lat], markerData);
        }
        this.mapVisible = true;

      })
    },

    createCustomMarker(map, position, markerData) {
      const svgLogo = store.mapMarker;

        const markerElement = document.createElement('div');
        markerElement.className = 'marker';
        markerElement.style.width = '52px';
        markerElement.style.height = '52px';

        const markerContentElement = document.createElement('div');
        markerElement.appendChild(markerContentElement);

        const iconElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        iconElement.setAttribute('class', 'marker-icon');
        iconElement.setAttribute('width', '100%');
        iconElement.setAttribute('height', '100%');

        iconElement.innerHTML = svgLogo;

        markerContentElement.appendChild(iconElement);

        const marker = new tt.Marker({ element: markerElement})
        .setLngLat(position)
        .addTo(map);

        let size = 35;
        let div = document.createElement('div')
        let a = document.createElement('a')
        let containerImg = document.createElement('div')
        a.href = "/apartment-detail/" + markerData.id
        a.innerHTML = "<strong class='text-dark'>" + markerData.title + "</strong>"
        let img = document.createElement('img');
        img.src =  markerData.path ? markerData.path : '/img/house-placeholder.png'
        img.setAttribute("height", "50%");
        img.setAttribute("width", "100%");
        containerImg.appendChild(img)
        containerImg.style.borderRadius = '10px'
        containerImg.style.overflow = 'hidden'
        a.appendChild(containerImg)
        div.appendChild(a)
        let popup = new tt.Popup({
          closeButton: false,
          offset: size/2,
        }).setDOMContent(div);

        marker.setPopup(popup);
      }


},

mounted() {
  store.getServices();
}
}
</script>

<template>

    <div class="advanced-search pb-4">
    <!-- button+searchbar -->
    <div class="t4-container d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 ">
      <div class="d-none d-lg-block"></div>
      <div class="searchbar">
        <MainSearchbar  @getMap = 'this.getMap()'/>
      </div>
      <div>
        <a class="btn btn-filters t4-btn d-flex align-items-center m-3 m-md-0" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
          <i class="fa-solid fa-gears me-2 fs-6"></i>
          <span class="me-1">Filtri</span>
        </a>
      </div>
    </div>
      <!-- /button+searchbar -->

      <div v-if="store.advancedLoading" class="d-flex justify-content-center py-5 my-5">
        <Loader/>
      </div>

      <div v-else>
        <div v-if="store.apartmentCoordinates" class="t4-container">
          <div v-if="store.searchedApartments.length > 0">
            <h2 class="mb-4 pt-3 mb-4 fw-semibold w-100">Risultati della ricerca</h2>

            <div class="row row-cols-12 row-cols-md-4 row-cols-lg-6 px-4 px-md-2">
              <ApartmentCard
              v-for="apartment in store.searchedApartments"
              :key="apartment.id"
              :class="store.sponsorizedIds.includes(apartment.id) ? 'order-0' : 'order-1' "
              :apartment="apartment"
              @click="getView(apartment.id)"
              :link_name="'apartment-detail-guest'"/>
            </div>

            <div class="mb-4 mt-2 none rounded rounded-4" :class="[{ 'block': this.mapIsBlock }, { 'box-shadow': this.mapIsBlock }] ">
              <div style="width: 100%; height:400px" id="map"></div>
            </div>

          </div>
          <div v-else>
            <h2 class="py-5 my-5 fw-semibold d-flex justify-content-center h-100">Nessun risultato per questa ricerca</h2>
          </div>
        </div>
        <div v-else>
          <h2 class="py-5 my-5 fw-semibold d-flex justify-content-center h-100">Cerca un appartamento !</h2>
        </div>

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
            <div class="range pb-4">
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

        <div class="d-flex justify-content-between py-2">
          <button @click="clearFilter" class="btn btn-filters t4-btn-light d-flex align-items-center">
            <i class="fa-solid fa-rotate-left me-2 fs-6"></i>
            <span class="me-1">Resetta Filtro</span>
          </button>
          <button @click="filterApartments" class="btn btn-filters t4-btn-light d-flex align-items-center">
            <i class="fa-solid fa-magnifying-glass me-2 fs-6"></i>
            <span class="me-1">Filtra</span>
          </button>
        </div>

      </div>


    </div>
    <!-- ------ /offcanvas ------ -->
  </div>
  <Footer />
</template>

<style lang="scss" scoped>

@use "../../scss/partials/variables" as *;

.none {
  display: none;
}
.box-shadow {
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
}
.block {
  display: block;
}
#map {
    width: 100%;
    height: 400px;
    border-radius: 15px;
    overflow: hidden;
  }
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
