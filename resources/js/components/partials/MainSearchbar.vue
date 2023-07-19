<script>
import { store } from '../../store/store';
export default {
  name: "MainSearchbar",

  data(){
    return {
      store,
      search: '',
    }
  },

  methods: {
  selectAddressToSearch(suggest) {
    this.search = suggest.address.freeformAddress;
    store.showSuggestions = false;
  }

  }
}
</script>

<template>
  <p></p>
  <div class="d-flex align-items-center position-relative">
    <input
      v-model="search"
      @input="store.getSuggestions(this.search)"
      class="searchbar me-2"
      type="text"
      name="searchbar"
      placeholder="Inserisci una località">

      <!-- MODIFICARE LO STILE IN SCSS  -->
      <div style="top: 100%; left: 0; width: 100%; background-color: white;" class="position-absolute text-black">
        <ul v-if="store.showSuggestions">
          <li
            v-for="(suggest, index) in store.suggestions"
            :key="index"
            @click="this.selectAddressToSearch(suggest)">
            {{ suggest.address.freeformAddress }}
          </li>
        </ul>
      </div>


    <button class="btn t4-btn btn-search d-flex justify-content-center align-items-center" name="btn_search">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.searchbar {
  height: 40px;
  width: 300px;
  padding: 0 20px;
  border-radius: 50px;
  border: 0;
  margin-left: 58px;
}
.btn-search {
  border-radius: 50%;
  height: 50px;
  width: 50px;
  padding: 10px;
}
</style>
