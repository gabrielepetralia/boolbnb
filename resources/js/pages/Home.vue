<script>
import Jumbotron from '../components/partials/Jumbotron.vue';
import ApartmentCard from '../components/partials/cards/ApartmentCard.vue';

export default {
  name: 'Home',

  components: {
    Jumbotron,
    ApartmentCard
  }
}
</script>

<template>
  <div class="home">
    <Jumbotron/>

    <section class="sponsorized-apartments">
      <div class="t4-container">

        <h2 class="mb-4">Appartamenti in evidenza</h2>

        <div class="row row-cols-5">
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
