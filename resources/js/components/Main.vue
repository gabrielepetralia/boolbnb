<script>
import Jumbotron from './partials/Jumbotron.vue'

export default {
  name: "Main",

  components: {
    Jumbotron
  }
}
</script>

<template>
  <main>
    <Jumbotron/>
  </main>
</template>

<style lang="scss" scoped>
main {
  padding-top: 70px;
}
</style>
