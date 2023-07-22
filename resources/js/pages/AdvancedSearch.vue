<script>
import { store } from '../store/store';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
import Footer from '../components/partials/Footer.vue';
export default {
  name : "AdvancedSearch",

  data() {
    return {
      store,
    }
  },

  components: {
    ApartmentCard,
    Footer
  },
}
</script>

<template>
  <div class="advanced-search">
    <div v-if="store.searchedApartments" class="t4-container">
      <h2 class="mb-4 pt-5 mb-4 fw-semibold">Risultati della ricerca</h2>

      <div class="row row-cols-6">
        <ApartmentCard
        v-for="apartment in store.searchedApartments"
          :key="apartment.id"
          :apartment="apartment"
          :link_name="'apartment-detail-guest'"/>
      </div>
    </div>
    <div v-else>
      <h2 class="mb-4 pt-5 mb-4 fw-semibold d-flex justify-content-center h-100 py-5 mb-0">Cerca un appartamento !</h2>
    </div>
  </div>
  <Footer />
</template>

<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

.advanced-search {
  min-height: calc(100vh - 431px);
  color: $dark_gray;
  background-color: $dark_white;
}

</style>
