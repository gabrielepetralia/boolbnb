<script>
import { ref } from 'vue';
import { store } from '../../store/store';
import axios from 'axios';

import tt from '@tomtom-international/web-sdk-maps';
import ApartmentCard from '../../components/partials/cards/ApartmentCard.vue';

export default {
  name: "DashboardApartments",

  components: {
    ApartmentCard,
  },

  data(){
    return{
      tt,
      store,
      apartments: [],
      coordinates: '',

      apiUrl: 'https://api.tomtom.com/',
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
    getMyApartments(){
      axios.get('sanctum/csrf-cookie')
          .then(()=> {
            axios.get(`/admin/${store.user.id}`).then(result => {
              this.apartments = result.data.apartments;
            })
          })
    },

    addApartment(){
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
          img_path: this.apartmentForm.img_path,
          visible: this.apartmentForm.visible,
          price: this.apartmentForm.price,
          user_id: this.apartmentForm.user_id
        })
      })
      .then(result => {
        // if(result.response.status===500) {
        //   console.log("error")
        // } else {
        //   this.apartmentForm = ref({
        //     title: '',
        //     num_rooms: '',
        //     num_beds: '',
        //     num_bathrooms: '',
        //     square_meters: '',
        //     address: '',
        //     description: '',
        //     img_path: '',
        //     visible: true,
        //     price: '',
        //     user_id: store.user.id
        //   })
        // }
        // console.log(result)
      })
    },

  },

  mounted(){
    this.getMyApartments()
  }
}

</script>

<template>
  <div class="t4-container py-5 px-5">
    <div class="d-flex justify-content-between my-4">
      <h2 class="fs-3 fw-semibold mb-0 title">Appartamenti</h2>
      <div>
        <button title="Aggiungi Appartamento" class="btn t4-btn btn-add" data-bs-toggle="modal" data-bs-target="#add-apartment-modal"><i class="fa-solid fa-plus"></i></button>
      </div>
    </div>

    <div class="row row-cols-6">
      <ApartmentCard
      v-for="apartment in apartments"
        :key="apartment.id"
        :apartment="apartment"
        :link_name="'apartment-detail'"/>
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
            <button @click="addApartment()" class="btn t4-btn" data-bs-dismiss="modal"><i class="fa-solid fa-floppy-disk"></i></button>
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
