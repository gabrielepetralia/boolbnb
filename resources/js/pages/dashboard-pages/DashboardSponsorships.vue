<script>
import { store } from "../../store/store";
import axios from "axios";

import SponsorshipCard from '../../components/partials/cards/SponsorshipCard.vue';

export default {
  name: "DashboardSponsorships",

  components: {
    SponsorshipCard,
  },

  data() {
    return {
      store,
      apartments: [],
      sponsorships: [],
    }
  },

  methods: {

    sponsorizeApartment(apartment_id){
      store.apartmentId = apartment_id;
      axios.post("http://127.0.0.1:8000/admin/sponsorize/" + store.apartmentId + "/" + store.sponsorshipId)
        .then(res => {

        });
    },

    getSponsorships() {
      axios.get("sanctum/csrf-cookie")
        .then(() => {
        axios.get("http://127.0.0.1:8000/admin/sponsorships").then(res => {
          this.sponsorships = res.data;

        });
      });
    },

    getMyApartments() {
      axios.get("sanctum/csrf-cookie")
        .then(() => {
        axios.get(`/admin/${store.user.id}`).then((result) => {
          this.apartments = result.data.apartments;
        });
      });
    },

  },

  mounted() {
    this.getSponsorships();
    this.getMyApartments()
  }
}
</script>

<template>
  <div class="t4-container py-0 px-0 py-md-5 px-md-5">
    <h2 class="fs-3 fw-semibold my-4 title">Sponsorizzazioni</h2>

    <div class="row row-cols-12 row-cols-lg-2 row-cols-xxl-3 mt-5">
      <div v-for="sponsorship in sponsorships" :key="sponsorship.id">
        <SponsorshipCard :sponsorship="sponsorship"/>
      </div>

    </div>

  </div>

  <!-- Modal Selezione Appartamento -->
  <div class="modal fade" id="apartments-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header ">
          <h5 class="fw-semibold mb-0">Seleziona l'appartamento da sponsorizzare</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="t4-modal-body">
          <ul>
            <li @click="sponsorizeApartment(apartment.id)" data-bs-dismiss="modal" v-for="apartment in apartments" :key="apartment.id">
              <a href="#" class="p-3">{{ apartment.title }}</a>
              <hr class="m-0">
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.title {
  color: $dark-gray;

}
.t4-modal-body {
  background-color: $dark-white;
  height: 500px;
  overflow: auto;
  border-radius: 0 0 15px 15px;

  a {
    display: inline-block;
    height: 100%;
    width: 100%;
    color: $dark-gray;

    &:hover {
      background-color: white
    }
  }
}

</style>
