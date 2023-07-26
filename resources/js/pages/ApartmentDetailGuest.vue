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
      errorMessageForm: {},
      sendMessageErrors: null,
      messageForm: {
        name: '',
        email: '',
        msg_text: ''
      }
    }
  },
  methods: {

    // Send message to owner
    sendMessage(){
      if(this.messageForm.name.length < 3){
        this.errorMessageForm.name = 'Il nome deve contenere almeno 3 caratteri'

      }else if( this.messageForm.email.length < 3){
        this.errorMessageForm.name = null
        this.errorMessageForm.email = 'La mail deve contenere almeno 5 caratteri'

      }else if( this.messageForm.msg_text.length < 5){
        this.errorMessageForm.email = null
        this.errorMessageForm.msg_text = 'Il messaggio deve contenere almeno 5 caratteri'

      }else {
        this.errorMessageForm = {}

        axios.post('http://127.0.0.1:8000/' + "message", {
          email: this.messageForm.email,
          name: this.messageForm.name,
          msg_text: this.messageForm.msg_text,
          apartment_id: this.apartment.id,
        })
              .then(result => {
                console.log(result);
                this.messageForm= {
                  name: '',
                  email: '',
                  msg_text: ''
                }

                this.sendMessageErrors = "Messaggio inviato con successo!"
              })
      }




    },

    // Redirect Back

    redirectToPreviousPage() {
      this.$router.back();
    },

    // Get apartment details
    getApi() {
      this.loading = true,
        axios.get('sanctum/csrf-cookie')
          .then(() => {
            axios.get(store.apiUrl + 'apartments/apartment-detail/' + this.$route.params.slug)
              .then(result => {
                this.apartment = result.data.apartment[0];
                this.gallery = result.data.gallery;
                console.log(this.apartment, this.gallery);
                this.loading = false;
                this.getMap();
              })
          })
    },

    // Get map
    getMap(){
    axios.get( 'https://api.tomtom.com/search/2/' + 'geocode/'+this.apartment.address+'.json?view=Unified&key='+ 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ' )
    .then(result => {

      this._map.lat = result.data.results[0].position.lat;
      this._map.lon = result.data.results[0].position.lon;
      this.coordinates = [this._map.lon,this._map.lat];
      this.map_link = `https://www.google.it/maps/@${this._map.lat},${this._map.lon},18z/data=!5m1!1e1?entry=ttu`;

      tt.setProductInfo("maps", "1");

      var map = tt.map({
        key: 'gdZGu9e4M0xCvL3gtsUxcBcG8KtOb1fQ',
        container: "map",
        center: this.coordinates,
        zoom: 18
      })
      map.on('load', () =>{
        new tt.Marker().setLngLat(this.coordinates).addTo(map)
      })
    })
  },

  // Delete this apartment
    deleteApartment(id) {
      axios.get('sanctum/csrf-cookie')
        .then(() => {
          axios.delete(store.adminUrl + 'apartments/' + id)
            .then(result => {
              this.$router.push("/my-apartments/apartments");
            })
        })
    },

    // Update this apartment
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
  <div v-if="!loading" class="apartment-detail position-relative">
    <div class="t4-container py-lg-5 px-lg-5">

      <div class="detail-header d-flex justify-content-between align-items-center py-4">
        <h2 class="fs-3 fw-semibold mb-0 title">{{ apartment.title }}</h2>
        <div>
          <button @click="redirectToPreviousPage()" title="Torna Indietro" class="btn t4-btn btn-add me-2">
            <i class="fa-solid fa-left-long"></i>
          </button>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-xl-6 pe-lg-4">
          <div class="img-wrapper">
            <div class="slider-container mb-3">
              <Slider :apartment="this.apartment" :gallery="this.gallery" />
            </div>
            <div class="price">
              <p><span class="fw-semibold fs-4">{{ apartment.price }} &euro;</span> a notte</p>
            </div>
          </div>
        </div>


        <div class="col-12 col-xl-6">

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
            <ul class="d-flex flex-wrap">
              <li v-for="service in this.apartment.services" :key="service.id" class="service d-flex mb-2 me-4">
                <img style="height: 20px;" :src="`/img/services-icons/${service.slug}.png`" :alt="service.name" class="me-2">
                <span>{{ service.name }}</span>
              </li>
            </ul>
          </div>

            <!-- Button trigger modal -->
            <button type="button" class="contact-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" title="Contatta il proprietario">
              <i class="fa-brands fa-whatsapp"></i>
            </button>

              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-white">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Contatta il proprietario</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="p-3 ">
                      <div  class="d-flex justify-content-end">
                        <div class="message-form me-4 py-4">
                          <div class="text-center pb-4" v-if="this.sendMessageErrors !== null">
                            <span class="text-success d-block">
                              {{sendMessageErrors }}
                            </span>
                            <span class="text-success d-block">
                              Verrai ricontattato tramite mail
                            </span>
                          </div>
                          <div class="d-flex">
                            <div class="input-box me-3 ">

                              <label for="description" class="form-label "><strong> Nome </strong> </label>
                              <input class="name-input form-control "  v-model="messageForm.name" type="text" placeholder="Inserisci il tuo nome"> <br>
                              <div v-if="this.errorMessageForm.name">
                                {{ this.errorMessageForm.name }}
                              </div>

                            </div>
                            <div class="  input-box ">

                              <label for="description" class="form-label  "> <strong>Email</strong></label>
                              <input class="email-input form-control "  v-model="messageForm.email" type="email" placeholder="Inserisci la tua mail"> <br>
                              <div v-if="this.errorMessageForm.email">
                                {{ this.errorMessageForm.email }}
                              </div>

                            </div>
                          </div>

                          <div class="  input-box ">
                            <label for="description" class="form-label "> <strong>Inserisci un messaggio</strong></label>
                            <textarea placeholder="Scrivi al proprietario..." class="msg_text-input form-control "   v-model="messageForm.msg_text" cols="30" rows="5" >
                            </textarea>

                            <div v-if="this.errorMessageForm.msg_text">
                              {{ this.errorMessageForm.msg_text }}
                            </div>
                          </div>


                          <button @click="sendMessage" class="btn  mt-3">Invia</button>

                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <!-- endmodal -->
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
@use "../../scss/partials/_modal" as *;

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

  li:not(:last-child):not(.service) {
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

.contact-modal{
  position: fixed;
  display: block;
  right: 10px;
  bottom: 20vh;
  border: 0;
  background: transparent;
  background-color: rgb(49, 68, 49);
  color: white;
  height: 60px;
  width: 60px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  font-size: 35px;
  box-shadow: 0 0 5px black;
}

.message-form{

  .name-input,
  .email-input,
  .msg_text-input{
    padding-bottom: 10px;

    max-width: 400px;
    &:focus {
      border: 1px solid grey;
      outline: none;
      box-shadow: none;
    }
  }

.btn {
  background-color: $dark-gray;
  color: white;
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
//media-query
@media screen and (max-width: 1200px) {
.img-wrapper {
  margin-bottom: 50px;
}
.detail-header {
  flex-direction: column;
  h2 {
    padding-bottom: 15px;
  }
}
}
</style>
