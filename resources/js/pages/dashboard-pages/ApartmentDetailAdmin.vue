<script>
import axios from "axios";
import { store } from '../../store/store';
import { ref } from 'vue';
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
    apartmentForm : ref({
        title: '',
        num_rooms: '',
        num_beds: '',
        num_bathrooms: '',
        square_meters: '',
        address: '',
        description: '',
        img_path: '',
        visible: true,
        price: '',
        user_id: store.user.id
      })
  }
},
methods: {
  fillForm(){
    this.apartmentForm = ref({
        title: this.apartment.title,
        num_rooms: this.apartment.num_rooms,
        num_beds: this.apartment.num_beds,
        num_bathrooms: this.apartment.num_bathrooms,
        square_meters: this.apartment.square_meters,
        address: this.apartment.address,
        description: this.apartment.description,
        img_path: this.apartment.img_path,
        visible: this.apartment.visible,
        price: this.apartment.price,
        user_id: store.user.id
      })
  },
  getApi() {
    this.loading = true,
    axios.get('sanctum/csrf-cookie')
      .then(() => {
        axios.get(store.adminUrl + 'apartment/' + this.$route.params.slug)
          .then(result => {
            this.apartment = result.data.apartment[0];
            this.loading = false;
            this.fillForm();
            this.getMap()
          })
      })
  },

  getMap(){
    axios.get( this.apiUrl + 'geocode/'+this.apartment.address+'.json?view=Unified&key='+ this.apiKey )
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
      <h2 class="fs-3 fw-semibold mb-0 title">{{ apartment.title }}</h2>
    </div>
    <div>
      <button title="Modifica Appartamento" class="btn t4-btn btn-add me-2" data-bs-toggle="modal" data-bs-target="#edit-apartment-modal"><i class="fa-solid fa-pencil"></i></button>
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
        <h4 class="fw-semibold">Descrizione :</h4>
        <p>{{ apartment.description  }}</p>
      </div>
      <hr>
      <div>
        <h4 class="fw-semibold">Dettagli :</h4>
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
        <h4 class="fw-semibold">Servizi :</h4>
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

  <h4 class="fw-semibold">Mappa :</h4>
  <div class="map my-3">
    <div id="map"></div>
  </div>
  <div class="d-flex justify-content-between">
    <h5 class="fw-semibold">{{ apartment.address }}</h5>
    <router-link :to="{ name: 'apartments' }" class="btn t4-btn btn-add me-2"><i class="fa-solid fa-left-long"></i></router-link>
  </div>

</div>
<!-- modal -->
<div class="modal fade" id="edit-apartment-modal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h1 class="modal-title fs-3 fw-semibold text-center mt-2 mb-4" id="addApartmentModalLabel">Modifica Appartamento</h1>
            <form enctype="multipart/form-data">

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.title"

                  type="text"
                  id="title"
                  name="title"
                  class="form-control"
                  placeholder="Titolo">
                <label  for="title" class="form-label mb-0"><i class="fa-solid fa-heading"></i></label>

              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.num_rooms"
                  type="number"
                  min="1" max="255"
                  id="num_rooms"
                  name="num_rooms"
                  class="form-control"
                  placeholder="N. Stanze">
                <label for="num_rooms" class="form-label mb-0"><i class="fa-solid fa-door-open"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.num_beds"
                  type="number"
                  min="1" max="255"
                  id="num_beds"
                  name="num_beds"
                  class="form-control"
                  placeholder="N. Letti">
                <label for="num_beds" class="form-label mb-0"><i class="fa-solid fa-bed"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.num_bathrooms"
                  type="number"
                  min="1" max="255"
                  id="num_bathrooms"
                  name="num_bathrooms"
                  class="form-control"
                  placeholder="N. Bagni">
                <label for="num_bathrooms" class="form-label mb-0"><i class="fa-solid fa-bath"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.square_meters"
                  type="number"
                  min="1"
                  id="square_meters"
                  name="square_meters"
                  class="form-control"
                  placeholder="m²">
                <label for="square_meters" class="form-label mb-0"><i class="fa-solid fa-expand"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box position-relative">
                <input
                  v-model="apartmentForm.address"
                  @input="store.getSuggestions(this.apartmentForm.address)"
                  type="text"
                  id="address"
                  name="address"
                  class="form-control"
                  autocomplete="off"
                  placeholder="Indirizzo">
                  <label for="address" class="form-label mb-0"><i class="fa-solid fa-location-dot"></i></label>

                  <div class="autocomplete-box">
                    <ul v-if="store.showSuggestions">
                      <li v-for="(suggest, index) in store.suggestions" :key="index" @click="store.selectAddress(this.apartmentForm, suggest)">{{ suggest.address.freeformAddress }}</li>
                    </ul>
                  </div>
              </div>

              <div class="mb-3 d-flex flex-row-reverse input-box pb-2">
                <textarea
                  v-model="apartmentForm.description"
                  name="description"
                  class="form-control"
                  placeholder="Descrizione"
                  rows="3"></textarea>
                <label for="description" class="form-label mb-0 mt-2"><i class="fa-solid fa-comment-dots"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.price"
                  type="number"
                  min="1"
                  id="price"
                  name="price"
                  class="form-control"
                  placeholder="Prezzo Per Notte">
                <label for="price" class="form-label mb-0"><i class="fa-solid fa-euro-sign"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box pb-2">
                <input
                  type="file"
                  id="img_path"
                  name="img_path"
                  class="form-control ms-2"
                  placeholder="Immagine">
                <label for="img_path" class="form-label mb-0"><i class="fa-solid fa-image"></i></label>
              </div>

              <div class="mb-3 d-flex justify-content-end align-items-center flex-row-reverse input-box border-0 pb-2">
                <label class="switch">
                  <input type="checkbox"
                    v-model="apartmentForm.visible"
                    id="visible"
                    name="visible"
                    class="form-control ms-1"
                    title="Visibile"
                    >
                  <span class="slider round"></span>
                </label>
                <label for="visible" class="form-label mb-0"><i class="fa-solid fa-eye"></i></label>
              </div>

            </form>
          </div>

          <div class="modal-footer pe-4">
            <button class="btn t4-btn" data-bs-dismiss="modal"><i class="fa-solid fa-floppy-disk"></i></button>
          </div>

        </div>
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

.autocomplete-box {
  position: absolute;
  top: 102%;
  left: 0;
  background-color: white;
  color: $dark-gray;
  width: 100%;
  border-radius: 0 0 12px 12px;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  overflow: hidden;

  ul {
    li {
      display: block;
      width: 100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: 0.9rem;
      padding: 12px 18px;
      border-bottom: 1px solid $dark_white;
      transition: all 0.3s;

      &:hover {
        background-color: $dark_white;
        cursor: pointer;
      }

    }
  }
}
</style>
