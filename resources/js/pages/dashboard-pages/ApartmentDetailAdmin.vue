<script>
import axios from "axios";
import { store } from '../../store/store';
import { ref } from 'vue';
import tt from '@tomtom-international/web-sdk-maps';
import AddGallery from "../../components/partials/cards/AddGallery.vue";
import Slider from '../../components/partials/Slider.vue';
export default {
name: 'ApartmentDetailAdmin',
components:{
  AddGallery,
  Slider
},
data(){
  return {
    store,
    gallery: [],
    apartmentServices: [],
    apartment: null,
    errors: null,
    map_link: null,
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
        image: '',
        visible: true,
        price: '',
        user_id: store.user.id,
        services: this.apartmentServices
      }),
      coordinate_x: null,
      coordinate_Y: null,
  }
},
methods: {
  redirectToPreviousPage() {
      this.$router.back();
    },

  fillForm(){
    this.apartmentForm = ref({
        title: this.apartment.title,
        num_rooms: this.apartment.num_rooms,
        num_beds: this.apartment.num_beds,
        num_bathrooms: this.apartment.num_bathrooms,
        square_meters: this.apartment.square_meters,
        address: this.apartment.address,
        description: this.apartment.description,
        image: this.apartment.img_path,
        visible: this.apartment.visible === 1 ? true : false,
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
            this.gallery = result.data.gallery;
            this.loading = false;
            this.fillForm();
            this.getMap();
            result.data.apartment[0].services.forEach(service =>{
              this.apartmentServices.push(service.id)
            })
            console.log(result);
          })
      })
  },

  getMap(){
    axios.get( this.apiUrl + 'geocode/'+this.apartment.address+'.json?view=Unified&key='+ this.apiKey )
    .then(result => {

      this._map.lat = result.data.results[0].position.lat;
      this._map.lon = result.data.results[0].position.lon;

      this.map_link = `https://www.google.it/maps/@${this._map.lat},${this._map.lon},18z/data=!5m1!1e1?entry=ttu`;

      tt.setProductInfo("maps", "1");

      var map = tt.map({
        key: "gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ",
        container: "map",
        center: [this._map.lon, this._map.lat],
        zoom: 18

      })
    })
  },

  deleteApartment(id){
    axios.get('sanctum/csrf-cookie')
      .then(() => {
        axios.delete(store.adminUrl + 'apartments/' + id)
          .then(result => {
            this.$router.push("/my-apartments/apartments");
          })
      })
  },

  updateApartment($id){

    console.log(this.apartmentForm);
    this.errors = null
      if(this.apartmentForm.visible == true){
        if(
          this.apartmentForm.title == ''         ||
          this.apartmentForm.num_rooms == ''     ||
          this.apartmentForm.num_beds == ''      ||
          this.apartmentForm.num_bathrooms == '' ||
          this.apartmentForm.square_meters == '' ||
          this.apartmentForm.description == ''   ||
          this.apartmentForm.price == '')
        {
          this.errors = 'Rendi l\'appartamento privato o completa tutti i campi';
        }else{
          axios.get('sanctum/csrf-cookie')
            .then(() => {
              axios.post(store.adminUrl + 'apartments/' + $id, {
                _method: 'PUT',
                title: this.apartmentForm.title,
                num_rooms: this.apartmentForm.num_rooms,
                num_beds: this.apartmentForm.num_beds,
                num_bathrooms: this.apartmentForm.num_bathrooms,
                square_meters: this.apartmentForm.square_meters,
                address: this.apartmentForm.address,
                description: this.apartmentForm.description,
                image: this.apartmentForm.image,
                visible: this.apartmentForm.visible,
                price: this.apartmentForm.price,
                services: JSON.stringify(this.apartmentServices),
                user_id: this.apartmentForm.user_id
              }, {
                headers:{
                  'content-type' : 'multipart/form-data'
                }
              })
        })
            .then(result => {
              this.apartmentServices=[]
              this.$router.push("/my-apartments/apartments");

              this.getApi();


            })
        }

    }else if(this.apartmentForm.address == ''){
      this.errors = 'Devi inserire sia il titolo che l\'indirizzo'

    }else{
      axios.get('sanctum/csrf-cookie')
        .then(() => {
          axios.post(store.adminUrl + 'apartments/' + $id, {
            _method: 'PUT',
            title: this.apartmentForm.title,
            num_rooms: this.apartmentForm.num_rooms,
            num_beds: this.apartmentForm.num_beds,
            num_bathrooms: this.apartmentForm.num_bathrooms,
            square_meters: this.apartmentForm.square_meters,
            address: this.apartmentForm.address,
            description: this.apartmentForm.description,
            image: this.apartmentForm.image,
            visible: this.apartmentForm.visible,
            price: this.apartmentForm.price,
            services: JSON.stringify(this.apartmentServices),
            user_id: this.apartmentForm.user_id
          }, {
            headers: {
            'Content-Type': 'multipart/form-data',
          }

              })
        })
        .then(result => {
          console.log(result);
          this.apartmentServices=[]

          this.apartmentForm = ref({
            title: '',
            num_rooms: '',
            num_beds: '',
            num_bathrooms: '',
            square_meters: '',
            address: '',
            description: '',
            image: '',
            visible: true,
            price: '',
            user_id: store.user.id
          })
          // console.log(result)

          this.getApi();
          this.$router.push("/my-apartments/apartments");



        })
     }
  },

  onChange(event){
      this.apartmentForm.image = event.target.files[0]
      console.log(this.apartmentForm.image);
    }
},

mounted(){
  this.getApi();
  store.getServices();
}
  }
</script>

<template>
  <div v-if="!loading" class="apartment-detail">
    <div class="t4-container py-5 px-5">

      <div class="d-flex justify-content-between align-items-center my-4">
        <h2 v-if="apartment.title" class="fs-3 fw-semibold mb-0 title">{{ apartment?.title }}</h2>
        <div>
          <button @click="redirectToPreviousPage()" title="Torna Indietro" class="btn t4-btn btn-add me-2">
            <i class="fa-solid fa-left-long"></i>
          </button>
          <button title="Modifica Appartamento" class="btn t4-btn btn-add me-2" data-bs-toggle="modal" data-bs-target="#edit-apartment-modal">
            <i class="fa-solid fa-pencil"></i>
          </button>
          <button @click="deleteApartment(this.apartment.id)" title="Elimina Appartamento" class="btn t4-btn btn-add" data-bs-toggle="modal" data-bs-target="">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </div>

      <div class="row row-cols-2">
        <div class="col pe-4">
          <div class="img-wrapper">
            <div class="slider-container mb-3">
              <Slider :apartment="this.apartment" :gallery="this.gallery" />
            </div>
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
              <li v-for="service in this.apartment.services" :key="service.id">
                <img style="height: 20px;" :src="`/img/services-icons/${ service.slug }.png`" :alt="service.name">
                <span>{{ service.name }}</span>
              </li>
            </ul>
          </div>



          <AddGallery :apartment="this.apartment"/>


        </div>
      </div>

      <hr class="my-4">

      <h4 class="fw-semibold">Mappa :</h4>
      <div class="map my-3">
        <a :href="map_link" target="blank">
          <div id="map"></div>
        </a>
      </div>

      <h5 class="fw-semibold">{{ apartment.address }}</h5>

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
            <div v-if="this.errors !== null" class="d-flex justify-content-center align-items-center">
              <span style="font-size: 13px;" class="text-danger">
                {{ this.errors }}
              </span>
            </div>
            <form enctype="multipart/form-data">

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.title"
                  title="Titolo"
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
                  title="N. Stanze"
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
                  title="N. Letti"
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
                  title="N. Bagni"
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
                  title="Metri Quadri"
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
                  title="Indirizzo"
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
                  title="Descrizione"
                  name="description"
                  class="form-control"
                  placeholder="Descrizione"
                  rows="3"></textarea>
                <label for="description" class="form-label mb-0 mt-2"><i class="fa-solid fa-comment-dots"></i></label>
              </div>

              <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
                <input
                  v-model="apartmentForm.price"
                  title="Prezzo per Notte"
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
                @change="onChange"
                  type="file"
                  title="Copertina"
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
                <label for="visible" title="Visibile" class="form-label mb-0"><i class="fa-solid fa-eye"></i></label>
              </div>

              <div class="mb-3 d-flex justify-content-end align-items-center flex-row-reverse input-box border-0 pb-2">
                <div role="group"  class="row">
                    <div v-for="service in store.availableServices" :key="service.id" class="col">
                      <input type="checkbox"
                      v-model="apartmentServices"
                      :value="service.id"
                      :id="service.slug"
                      :title="service.slug"
                      >
                      <label :for="service.slug" class="form-label mb-0">{{ service?.name }}</label>
                    </div>


                </div>
              </div>

            </form>
          </div>

          <div class="modal-footer pe-4">
            <button @click="updateApartment(this.apartment.id)" class="btn t4-btn" data-bs-dismiss="modal" title="Salva">
              <i class="fa-solid fa-floppy-disk"></i>
            </button>
          </div>

        </div>
      </div>
    </div>
</template>


<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

.slider-container {
  width: 100%;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
}
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
