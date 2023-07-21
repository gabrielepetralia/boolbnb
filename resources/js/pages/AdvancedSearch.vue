<script>
import { store } from '../store/store';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';
export default {
  name : "AdvancedSearch",

  data() {
    return {
      store,
    }
  },

  components: {
    ApartmentCard,
  },
}
</script>

<template>
  <div class="t4-container">
    <h2 class="mb-4 mt-5 mb-4 fw-semibold">Risultati della ricerca</h2>

    <div class="row row-cols-6">
        <ApartmentCard
        v-for="apartment in store.searchedApartments"
          :key="apartment.id"
          :apartment="apartment"
          :link_name="'advanced-search'"/>
      </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

h2 {
  color: $dark-gray;
}

</style>
