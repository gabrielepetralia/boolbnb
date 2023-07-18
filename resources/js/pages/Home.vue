<script>
import Jumbotron from '../components/partials/Jumbotron.vue';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import { store } from '../store/store';

export default {
  name: 'Home',

  components: {
    Jumbotron,
    ApartmentCard
  },

  data() {
    return {
      store,
      apartments: []
    }
  },

  methods: {
    getApi() {
      axios.get(store.apiUrl + 'apartments')
        .then(res => {
          this.apartments = res.data;
          console.log(this.apartments)
        })
    },

    mounted() {
      this.getApi();
    }
  }
}
</script>

<template>
  <div class="home">
    <Jumbotron/>

    <section class="sponsorized-apartments">
      <div class="t4-container">

        <h2 class="mb-4 mt-5 mb-4">Appartamenti In Evidenza</h2>

        <div class="row row-cols-6">
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
          <ApartmentCard/>
        </div>

      </div>
    </section>

  </div>
</template>

<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

.home {
  color: $dark_gray;
  background-color: $dark_white;

  .sponsorized-apartments {

  }
}

</style>
