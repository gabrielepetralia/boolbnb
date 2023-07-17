<script>
export default {
  name: "ApartmentCard",

  props: {
    apartment: Object
  }
}
</script>

<template>
  <div class="col">
    <a href="#">
      <div class="apartment-card">

        <div class="apartment-img">

        </div>
        <div class="apartment-text">
          <h1>card</h1>
        </div>

      </div>
    </a>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../../scss/partials/variables" as *;

.apartment-card {

}
</style>
