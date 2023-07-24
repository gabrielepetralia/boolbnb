<script>
import axios from "axios";
import { store } from '../store/store';
import { ref } from 'vue';
import tt from '@tomtom-international/web-sdk-maps';
import Slider from '../components/partials/Slider.vue';
export default {
  name: 'ApartmentDetailAdmin',
  components: {
    Slider
  },
  data() {
    return {
      store,
      apartment: null,
      errors: null,
      map_link: null,
      gallery: [],
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

    redirectToPreviousPage() {
      this.$router.back();
    },

    getApi() {
      this.loading = true,
        axios.get('sanctum/csrf-cookie')
          .then(() => {
            axios.get(store.apiUrl + 'apartments/apartment-detail/' + this.$route.params.slug)
              .then(result => {
                this.apartment = result.data.apartment[0];
                this.gallery = result.data.gallery;
                this.loading = false;
                this.getMap();
              })
          })
    },

    getMap() {
      axios.get(this.apiUrl + 'geocode/' + this.apartment.address + '.json?view=Unified&key=' + this.apiKey)
        .then(result => {

          this._map.lat = result.data.results[0].position.lat;
          this._map.lon = result.data.results[0].position.lon;

          this.map_link = `https://www.google.it/maps/@${this._map.lat},${this._map.lon},18z/data=!5m1!1e1?entry=ttu`;

          tt.setProductInfo("maps", "1");

          var map = tt.map({
            key: this.apiKey,
            container: "map",
            center: [this._map.lon, this._map.lat],
            zoom: 18

          })
        })
    },

    deleteApartment(id) {
      axios.get('sanctum/csrf-cookie')
        .then(() => {
          axios.delete(store.adminUrl + 'apartments/' + id)
            .then(result => {
              this.$router.push("/my-apartments/apartments");
            })
        })
    },

    updateApartment($id) {
      this.errors = null
      if (this.apartmentForm.visible == true) {
        if (
          this.apartmentForm.title == '' ||
          this.apartmentForm.num_rooms == '' ||
          this.apartmentForm.num_beds == '' ||
          this.apartmentForm.num_bathrooms == '' ||
          this.apartmentForm.square_meters == '' ||
          this.apartmentForm.description == '' ||
          this.apartmentForm.price == '') {
          this.errors = 'Rendi l\'appartamento privato o completa tutti i campi';
        } else {
          axios.get('sanctum/csrf-cookie')
            .then(() => {
              axios.put(store.adminUrl + 'apartments/' + $id, {
                title: this.apartmentForm.title,
                num_rooms: this.apartmentForm.num_rooms,
                num_beds: this.apartmentForm.num_beds,
                num_bathrooms: this.apartmentForm.num_bathrooms,
                square_meters: this.apartmentForm.square_meters,
                address: this.apartmentForm.address,
                description: this.apartmentForm.description,
                img_path: this.apartmentForm.img_path,
                visible: this.apartmentForm.visible,
                price: this.apartmentForm.price,
                user_id: this.apartmentForm.user_id
              })
                .then(result => {
                  // this.$router.push("/my-apartments/apartments");
                })
            })
        }

      } else if (this.apartmentForm.address == '') {
        this.errors = 'Devi inserire sia il titolo che l\'indirizzo'

      } else {
        axios.get('sanctum/csrf-cookie')
          .then(() => {
            axios.put(store.adminUrl + 'apartments/' + $id, {
              title: this.apartmentForm.title,
              num_rooms: this.apartmentForm.num_rooms,
              num_beds: this.apartmentForm.num_beds,
              num_bathrooms: this.apartmentForm.num_bathrooms,
              square_meters: this.apartmentForm.square_meters,
              address: this.apartmentForm.address,
              description: this.apartmentForm.description,
              img_path: this.apartmentForm.img_path,
              visible: this.apartmentForm.visible,
              price: this.apartmentForm.price,
              user_id: this.apartmentForm.user_id
            })
          })
          .then(result => {
            this.apartmentForm = ref({
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
            // console.log(result)

            this.getApi();
            this.$router.push("/my-apartments/apartments");


          })
      }
    }
  },

  mounted() {
    this.getApi();
  }
}
</script>

<template>
  <div v-if="!loading" class="apartment-detail">
    <div class="t4-container py-5 px-5">

      <div class="d-flex justify-content-between align-items-center my-4">
        <h2 class="fs-3 fw-semibold mb-0 title">{{ apartment.title }}</h2>
        <div>
          <button @click="redirectToPreviousPage()" title="Torna Indietro" class="btn t4-btn btn-add me-2">
            <i class="fa-solid fa-left-long"></i>
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
            <p>{{ apartment.description }}</p>
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
                <img style="height: 20px;" :src="`/img/services-icons/${service.slug}.png`" :alt="service.name">
                <span>{{ service.name }}</span>
              </li>
            </ul>
          </div>

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
</template>


<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

.slider-container {
  width: 100%;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
}
.apartment-detail {
  font-size: 0.95rem;
  background-color: $dark-white;
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
