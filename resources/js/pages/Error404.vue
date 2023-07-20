<script>
export default {
  name: "Error404"
}
</script>

<template>
  <div class="error-404 d-flex align-items-center justify-content-center">
    <h1 class="p-5 fw-semibold">Error 404</h1>
  </div>
</template>

<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

.error-404 {
  background-color: $dark_gray;
  color: white;
  height: calc(100vh - 70px);
}
</style>
