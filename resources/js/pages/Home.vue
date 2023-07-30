<script>
import axios from 'axios';
import Jumbotron from '../components/partials/Jumbotron.vue';
import Footer from '../components/partials/Footer.vue';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import Loader from '../components/partials/Loader.vue';
import { store } from '../store/store';

export default {
  name: 'Home',

  components: {
    Jumbotron,
    ApartmentCard,
    Footer,
    Loader

  },

  data() {
    return {
      store,
      loading: true
    }
  },

  methods: {
    getApi() {
      this.loading = true;
      store.sponsorizedIds = []
      axios.get(store.apiUrl + 'apartments')
        .then(res => {
          store.sponsorizedApartments = res.data.apartments;

        }).then(res=> {
          store.sponsorizedApartments.forEach(element => {
            store.sponsorizedIds.push(element.id)
          });

          this.loading = false;
        })
      },
    getView(apartment_id) {
      axios.get('https://api.ipify.org/?format=json')
      .then(response => {
        let ip_address = response.data.ip;
        axios.post('/view', {
          apartment_id: apartment_id,
          ip_address: response.data.ip
        })


      })

    }
  },

  mounted() {
    this.getApi();
  }
}
</script>

<template>
  <div class="home">
    <Jumbotron/>

    <section class="sponsorized-apartments pb-4">
      <div class="t4-container">

        <h2 class="mt-5 mb-4 text-center text-md-start fw-semibold">Appartamenti In Evidenza</h2>

        <div v-if="this.loading" class="d-flex justify-content-center py-5 my-5">
          <Loader/>
        </div>

        <div v-else class="row">
          <div v-for="apartment in store.sponsorizedApartments" :key="apartment.id" class="col-12 col-md-4 col-lg-2 px-4 px-md-3">
            <ApartmentCard
              :apartment="apartment"
              :link_name="'apartment-detail-guest'"
              @click="getView(apartment.id)"
              />
          </div>
        </div>

      </div>
    </section>

  </div>
  <Footer />
</template>

<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

.home {
  color: $dark_gray;
  background-color: $dark_white;
}

</style>
