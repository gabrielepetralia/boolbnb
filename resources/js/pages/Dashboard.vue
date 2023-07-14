<script>
import Aside from '../components/partials/Aside.vue';

export default {
  name: 'Dashboard',

  components: {
    Aside
  }
}
</script>

<template>
  <div class="dashboard-wrapper d-flex">
    <Aside/>
    <div class="main-view w-100 overflow-auto">
      <router-view></router-view>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;

.dashboard-wrapper {
  height: calc(100vh - 70px);
  background-color: $dark_white;
}

</style>
