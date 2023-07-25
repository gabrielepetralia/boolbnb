<script>
import axios from "axios";
import { store } from "../../store/store";
export default {
  name: "DashboardMessages",
  data() {
    return {
      apartments: [],
      counter: 0,
      loading: true
    }
  },
  methods: {
    getMyApartments() {
      this.loading = true;
      axios.get("sanctum/csrf-cookie").then(() => {
        axios.get(`/admin/${store.user.id}`).then((result) => {
          this.apartments = result.data.apartments;
          console.log(this.apartments[0]);
          this.loading = false;
        });
      });
    },
  },
  mounted(){
    this.getMyApartments()

  }
}
</script>

<template>
  <div class="t4-container py-5 px-5">
    <h2 class="fs-3 fw-semibold mb-3 title">Messaggi</h2>
    <div v-if="!this.loading" class="container vf-container debug">
      <div class="side debug">
        <ul>
          <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">{{apartment.title}}</li>
          <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">{{apartment.title}}</li>
        </ul>
      </div>
      <div class="main debug">
        <h1>{{ this.apartments[counter].title }}</h1>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;

.title {
  color: $dark-gray;
}
.vf-container {
  height: 500px;
  padding: 0;
}
.side {
  width: 150px;
  height: 100%;
  float: left;
  overflow: auto;
}
.main {
  width: 100%;
  height: 100%;
}
.debug {
  background: rgba($color: #b319195a, $alpha: .5);
}
</style>
