<script>
import axios from 'axios';
import Jumbotron from '../components/partials/Jumbotron.vue';
import Footer from '../components/partials/Footer.vue';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import { store } from '../store/store';

export default {
  name: 'Home',

  components: {
    Jumbotron,
    ApartmentCard,
    Footer
  },

  data() {
    return {
      store,
    }
  },

  methods: {
    getApi() {
      axios.get(store.apiUrl + 'apartments')
        .then(res => {
          store.sponsorizedApartments = res.data.apartments;
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

        <h2 class="mb-4 mt-5 mb-4 fw-semibold">Appartamenti In Evidenza</h2>

        <div class="row row-cols-6">
          <ApartmentCard
          v-for="apartment in store.sponsorizedApartments"
            :key="apartment.id"
            :apartment="apartment"
            :link_name="'apartment-detail-guest'"/>
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
