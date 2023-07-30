<script>
import { store } from '../../store/store';
export default {
  name: "MainSearchbar",

  data(){
    return {
      store,
    }
  },

  methods: {
    selectAddressToSearch(suggest) {
      store.search = suggest.address.freeformAddress;
      store.showSuggestions = false;
    }
  }
}
</script>

<template>
<div class="d-flex align-items-center position-relative">
  <input
  autocomplete="off"
    v-model="store.search"
    @input="store.getSuggestions(store.search)"
    @keyup.enter="store.getSearchedApartments(store.search), this.$router.push('/advanced-search'), store.showSuggestions = false"
    class="searchbar me-2"
    type="text"
    name="searchbar"
    placeholder="Inserisci una località">

  <div class="autocomplete-box" :class="{ 'box-shadow': store.showSuggestions }">
    <ul v-if="store.showSuggestions">
      <li
        v-for="(suggest, index) in store.suggestions"
        :key="index"
        @click="this.selectAddressToSearch(suggest)">
        {{ suggest.address.freeformAddress }}
      </li>
    </ul>
  </div>

  <router-link :to="{ name: 'advanced-search' }">
    <button @click="store.getSearchedApartments(store.search),$emit('getMap'), store.showSuggestions = false" class="btn t4-btn btn-search d-flex justify-content-center align-items-center" name="btn_search">
      <i class="fa-solid fa-magnifying-glass"></i>
    </button>
  </router-link>
</div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.searchbar {
  z-index: 3;
  color: $dark-gray;
  font-size: 0.95rem;
  height: 40px;
  width: 300px;
  padding: 0 20px;
  border-radius: 50px;
  border: 0;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);

  &:focus {
    border: none;
    outline: 1px solid $light_blue;
  }
}
.btn-search {
  border-radius: 50%;
  height: 50px;
  width: 50px;
  padding: 10px;
}

.autocomplete-box {
  z-index: 2 !important;
  position: absolute;
  top: 50%;
  left: 0;
  background-color: white;
  color: $dark-gray;
  width: 84.05%;
  border-radius: 0 0 12px 12px;
  overflow: hidden;

  ul {
    padding-top: 21px;
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

// media-query
@media screen and (max-width: 500px) {
  .searchbar {
    width: 204px;
  }
  .autocomplete-box {
    width: 78.05%;
  }
}
</style>
