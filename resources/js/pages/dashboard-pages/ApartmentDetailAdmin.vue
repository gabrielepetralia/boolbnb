<script>
import axios from "axios";
import { store } from '../../store/store';
import tt from '@tomtom-international/web-sdk-maps';
export default {
name: 'ApartmentDetailAdmin',
data(){
  return {
    store,
    apartment: null,
    apiUrl: 'https://api.tomtom.com/search/2/',
    apiKey: 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ',
    _map: {
      lat: null,
      lon: null
    },
    loading: true,
  }
},
methods: {
  getApi() {
    this.loading = true,
    axios.get('sanctum/csrf-cookie')
      .then(() => {
        axios.get(store.adminUrl + 'apartment/' + this.$route.params.slug)
          .then(result => {
            this.apartment = result.data.apartment[0];
            this.loading = false;
            this.getMap()
          })
      })
  },

  getMap(){
    axios.get( this.apiUrl + 'geocode/rome.json?view=Unified&key='+ this.apiKey )
    .then(result => {

      this._map.lat = result.data.results[0].position.lat;
      this._map.lon = result.data.results[0].position.lon;

      tt.setProductInfo("maps", "1");

      var map = tt.map({
        key: "gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ",
        container: "map",
        center: [this._map.lon, this._map.lat],
        zoom: 16

      })
    })
  },
},

mounted(){
  this.getApi();
}
  }
</script>

<template>
<div v-if="!loading" class="t4-container py-5 px-5 apartment-detail">

  <div class="d-flex justify-content-between align-items-center my-4">
    <div class="d-flex align-items-center">
      <h2 class="fs-3 mb-0 title">{{ apartment.title }}</h2>
    </div>
    <div>
      <button title="Modifica Appartamento" class="btn t4-btn btn-add me-2" data-bs-toggle="modal" data-bs-target=""><i class="fa-solid fa-pencil"></i></button>
      <button title="Elimina Appartamento" class="btn t4-btn btn-add" data-bs-toggle="modal" data-bs-target=""><i class="fa-solid fa-trash"></i></button>
    </div>
  </div>

  <div class="row row-cols-2">
    <div class="col pe-4">
      <div class="img-wrapper">
        <img class="w-100 mb-3" :src="apartment.img_path ?? '/img/house-placeholder.png'" alt="">
        <div class="price">
          <p><span class="fw-semibold fs-4">{{ apartment.price }} &euro;</span> a notte</p>
        </div>
      </div>
    </div>
    <div class="col ps-4">

      <div>
        <h4>Descrizione :</h4>
        <p>{{ apartment.description  }}</p>
      </div>
      <hr>
      <div>
        <h4>Dettagli :</h4>
        <ul class="d-flex details">
          <li>
            <i class="fa-solid fa-door-open"></i>
            <span>{{ apartment.num_rooms }}</span>
          </li>
          <li>
            <i class="fa-solid fa-bed"></i>
            <span>{{ apartment.num_beds }}</span>
          </li>
          <li>
            <i class="fa-solid fa-bath"></i>
            <span>{{ apartment.num_bathrooms }}</span>
          </li>
          <li>
            <i class="fa-solid fa-expand"></i>
            <span>{{ apartment.square_meters }} mt<sup>2</sup> </span>
          </li>
        </ul>
      </div>
      <hr>
      <div>
        <h4>Servizi :</h4>
        <ul class="d-flex">
          <li>servizio</li>
          <li>servizio</li>
          <li>servizio</li>
          <li>servizio</li>
          <li>servizio</li>
        </ul>
      </div>

    </div>
  </div>

  <hr class="my-4">

  <h4>Mappa :</h4>
  <div class="map my-3">
    <div id="map"></div>
  </div>
  <div class="d-flex justify-content-between">
    <h5>{{ apartment.address }}</h5>
    <router-link :to="{ name: 'apartments' }" class="btn t4-btn btn-add me-2"><i class="fa-solid fa-left-long"></i></router-link>
  </div>

</div>
</template>


<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.apartment-detail {
  font-size: 0.95rem;
  color: $dark-gray;

  img {
    border-radius: 15px;
    box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  }

  li:not(:last-child) {
    &:after {
      content: '-';
      margin: 10px;
    }
  }

  .details {
    i {
      margin-right: 7px;
    }
  }

  #map {
    width: 100%;
    height: 300px;
    box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
    border-radius: 15px;
    overflow: hidden;
  }
}
</style>
