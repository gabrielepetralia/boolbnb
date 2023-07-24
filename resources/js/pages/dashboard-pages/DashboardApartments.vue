<script>
import { ref } from "vue";
import { store } from "../../store/store";
import axios from "axios";

import tt from "@tomtom-international/web-sdk-maps";
import ApartmentCard from "../../components/partials/cards/ApartmentCard.vue";

export default {
  name: "DashboardApartments",

  components: {
    ApartmentCard,
  },

  data() {
    return {
      tt,
      store,
      apartments: [],

      apartmentServices: [],
      coordinates: '',
      errors : null,

      apiUrl: "https://api.tomtom.com/",
      apartmentForm: ref({
        title: "",
        num_rooms: "",
        num_beds: "",
        num_bathrooms: "",
        square_meters: "",
        address: "",
        description: "",
        image: '',
        visible: true,
        price: "",
        user_id: store.user.id,
      }),
      errors: {},
      generalFormError: null,
    };
  },

  methods: {
    getMyApartments() {
      axios.get("sanctum/csrf-cookie").then(() => {
        axios.get(`/admin/${store.user.id}`).then((result) => {
          this.apartments = result.data.apartments;
        });
      });
    },

    addApartment(){

      this.errors = {}
      this.generalFormError = null

              const addressPattern = /^(?=.*[a-zA-Z])(?=.*\d).+$/;
              const validTitleRegex = /^[A-Za-z\s]+$/;
              const numRoomsValue = parseInt(this.apartmentForm.num_rooms);
              const numBedsValue = parseInt(this.apartmentForm.num_beds);
              const numBathroomsValue = parseInt(this.apartmentForm.num_bathrooms);
              const numPricesValue = parseInt(this.apartmentForm.price);
              const numSquareMetersValue = parseInt(
                this.apartmentForm.square_meters
              );
      if(this.apartmentForm.visible == true){

        if(this.apartmentForm.title !== "" ) {
          this.generalFormError = "Completa tutti i campi o rendi l'appartamento non visibile"
        }

        if (this.apartmentForm.title.trim() === "") {
          this.errors.title = "Il titolo non può essere vuoto.";
          return
        }

        if (!validTitleRegex.test(this.apartmentForm.title)) {
          this.errors.title = "Il titolo contiene caratteri non validi.";
          return
        }

        if (this.apartmentForm.title.length < 3) {
          this.errors.title = "Il titolo deve avere almeno 3 caratteri.";
          return
        }

        if (isNaN(numRoomsValue) || numRoomsValue <= 0) {
          this.errors.num_rooms = "Inserisci un numero valido di stanze.";
          return
        }
        if (isNaN(numBedsValue) || numBedsValue <= 0) {
          this.errors.num_beds = "Inserisci un numero valido di letti.";
          return
        }
        if (isNaN(numBathroomsValue) || numBathroomsValue <= 0) {
          this.errors.num_bathrooms = "Inserisci un numero valido di bagni.";
          return
        }
        if (isNaN(numSquareMetersValue) || numSquareMetersValue <= 0) {
          this.errors.square_meters = "Inserisci i m²";
          return
        }

        if (isNaN(numPricesValue) || numPricesValue <= 0) {
          this.errors.price = "Inserisci il prezzo.";
          return
        }

        if (!addressPattern.test(this.apartmentForm.address)) {
          this.errors.address =
            "L'indirizzo deve contenere almeno una lettera e almeno un numero.";
            return
        } else {
          this.errors.address = "";
        }

        if (this.apartmentForm.description.length < 10){
          this.errors.description = "Devi inserire minimo 10 caratteri";
          return
        }


        axios.get('sanctum/csrf-cookie')
        .then(() => {
          axios.post('/admin/apartments', {
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
            user_id: this.apartmentForm.user_id,
            services: JSON.stringify(this.apartmentServices),
          }, {
            headers:{
              'content-type' : 'multipart/form-data'
            }
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
            image: '',
            visible: true,
            price: '',
            user_id: store.user.id,

          })

          this.getMyApartments()

          // console.log(result)

        }).then(()=>{

          this.$router.push("/my-apartments/apartments");
        })
        .catch(error=>{
            console.log(error);
          })
      }else{

        if(this.apartmentForm.title !== "" && this.apartmentForm.address !== ""){

          console.log(this.apartmentForm)
          axios.get('sanctum/csrf-cookie')
          .then(() => {
            axios.post('/admin/apartments', {
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
              user_id: this.apartmentForm.user_id,
              services: JSON.stringify(this.apartmentServices),
            }, {
            headers:{
              'content-type' : 'multipart/form-data'
            }
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
              image: {},
              visible: true,
              price: '',
              user_id: store.user.id,

            })

            // console.log(result)
            this.getMyApartments()
          })
          .catch(error=>{
            console.log(error);
          })
        }else{
          this.generalFormError = "Per salvare una bozza completa titolo e indirizzo"
        }
      }
    },
    onChange(event){
      this.apartmentForm.image = event.target.files[0]
      console.log(this.apartmentForm.image);
    }

  },

  mounted(){
    this.getMyApartments()
    store.getServices();

  }
}
</script>

<template>
  <div class="t4-container py-5 px-5">
    <div class="d-flex justify-content-between my-4">
      <h2 class="fs-3 fw-semibold mb-0 title">Appartamenti</h2>
      <div>
        <button
          title="Aggiungi Appartamento"
          class="btn t4-btn btn-add"
          data-bs-toggle="modal"
          data-bs-target="#add-apartment-modal"
        >
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>

    <div class="row row-cols-6">
      <ApartmentCard
        v-for="apartment in apartments"
        :key="apartment.id"
        :apartment="apartment"
        :link_name="'apartment-detail-admin'"/>
    </div>
  </div>

  <!-- Modal Add Apartment -->
  <div class="modal fade" id="add-apartment-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="modal-title fs-3 fw-semibold text-center mt-2 mb-4" id="addApartmentModalLabel">Aggiungi Appartamento</h1>

          <div v-if="generalFormError" class="text-danger general-error">
              {{ generalFormError }}
          </div>

          <form enctype="multipart/form-data">
            <div class="d-flex align-items-center flex-row-reverse input-box">

              <input
                v-model="apartmentForm.title"
                type="text"
                id="title"
                name="title"
                class="form-control"
                title="Titolo"
                placeholder="Titolo"/>

              <label for="title" class="form-label mb-0"><i class="fa-solid fa-heading"></i></label>

            </div>
            <div v-if="errors.title" class="text-danger">
              <p>{{ errors.title }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="apartmentForm.num_rooms"
                type="number"
                min="1"
                max="255"
                id="num_rooms"
                name="num_rooms"
                class="form-control"
                placeholder="N. Stanze"
                title="N. Stanze"/>

              <label for="num_rooms" class="form-label mb-0"><i class="fa-solid fa-door-open"></i></label>
            </div>
            <div v-if="errors.num_rooms" class="text-danger">
              <p>{{ errors.num_rooms }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="apartmentForm.num_beds"
                type="number"
                min="1"
                max="255"
                id="num_beds"
                name="num_beds"
                class="form-control"
                placeholder="N. Letti"
                title="N. Letti"/>

              <label for="num_beds" class="form-label mb-0"><i class="fa-solid fa-bed"></i></label>
            </div>
            <div v-if="errors.num_beds" class="text-danger">
              <p>{{ errors.num_beds }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="apartmentForm.num_bathrooms"
                type="number"
                min="1"
                max="255"
                id="num_bathrooms"
                name="num_bathrooms"
                class="form-control"
                placeholder="N. Bagni"
                title="N. Bagni"/>
              <label for="num_bathrooms" class="form-label mb-0"><i class="fa-solid fa-bath"></i></label>
            </div>
            <div v-if="errors.num_bathrooms" class="text-danger">
              <p>{{ errors.num_bathrooms }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="apartmentForm.square_meters"
                type="number"
                min="1"
                id="square_meters"
                name="square_meters"
                class="form-control"
                placeholder="m²"
                title="Metri Quadri"/>
              <label for="square_meters" class="form-label mb-0"><i class="fa-solid fa-expand"></i></label>
            </div>
            <div v-if="errors.square_meters" class="text-danger">
              <p>{{ errors.square_meters }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box position-relative">
              <input
                v-model="apartmentForm.address"
                @input="store.getSuggestions(this.apartmentForm.address)"
                type="text"
                id="address"
                name="address"
                class="form-control"
                autocomplete="off"
                placeholder="Indirizzo"
                title="Indirizzo"/>
              <label for="address" class="form-label mb-0"><i class="fa-solid fa-location-dot"></i></label>

              <div class="autocomplete-box">
                <ul v-if="store.showSuggestions">
                  <li
                    v-for="(suggest, index) in store.suggestions"
                    :key="index"
                    @click="store.selectAddress(this.apartmentForm, suggest)"
                  >
                    {{ suggest.address.freeformAddress }}
                  </li>
                </ul>
              </div>
            </div>
            <div v-if="errors.address" class="text-danger">
              <p>{{ errors.address }}</p>
            </div>

            <div class="mt-3 d-flex flex-row-reverse input-box pb-2">
              <textarea
                v-model="apartmentForm.description"
                name="description"
                class="form-control"
                placeholder="Descrizione"
                rows="3"
                title="Descrizione"></textarea>

              <label for="description" class="form-label mb-0 mt-2"><i class="fa-solid fa-comment-dots"></i></label>
            </div>
            <div v-if="errors.description" class="text-danger">
              <p>{{ errors.description }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="apartmentForm.price"
                type="number"
                min="1"
                id="price"
                name="price"
                class="form-control"
                placeholder="Prezzo Per Notte"
                title="Prezzo Per Notte"/>
              <label for="price" class="form-label mb-0"><i class="fa-solid fa-euro-sign"></i></label>
            </div>
            <div v-if="errors.price" class="text-danger">
              <p>{{ errors.price }}</p>
            </div>

            <div class="mt-3 d-flex align-items-center flex-row-reverse input-box pb-2">
              <input
                @change="onChange"
                type="file"
                id="img_path"
                name="img_path"
                class="form-control ms-2"
                placeholder="Immagine"
                title="Copertina"/>
              <label for="img_path" class="form-label mb-0"><i class="fa-solid fa-image"></i></label>
            </div>
            <div v-if="errors.num_rooms" class="text-danger">
              <p>{{ errors.num_rooms }}</p>
            </div>

            <div class="mt-3 d-flex justify-content-end align-items-center flex-row-reverse input-box border-0 pb-2">
              <label class="switch" >
                <input type="checkbox"
                  v-model="apartmentForm.visible"
                  id="visible"
                  name="visible"
                  class="form-control ms-1">
                <span class="slider round"></span>
              </label>
              <label for="visible" title="Visibile"  class="form-label mb-0"><i  class="fa-solid fa-eye"></i></label>
            </div>

            <div class="mt-3 d-flex justify-content-end align-items-center flex-row-reverse input-box border-0 pb-2">
              <div role="group"  class="row">
                  <div v-for="service in store.availableServices" :key="service.id" class="col">
                    <input type="checkbox"
                    v-model="apartmentServices"
                    :value="service.id"
                    :id="service.slug"
                    :title="service.slug">
                    <label :for="service.slug" class="form-label mb-0">{{ service?.name }}</label>
                  </div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer pe-4">
          <button @click="addApartment()" class="btn t4-btn"  title="Salva"><i class="fa-solid fa-floppy-disk"></i></button>
        </div>

      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

.title {
  color: $dark_gray;
}
.general-error{
  font-size: 13px;
}

.autocomplete-box {
  position: absolute;
  top: 102%;
  left: 0;
  background-color: white;
  color: $dark-gray;
  width: 100%;
  border-radius: 0 0 12px 12px;
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


.box-shadow {
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
}

</style>
