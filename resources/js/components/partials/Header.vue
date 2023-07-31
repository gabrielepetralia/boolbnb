<script>
import { store } from '../../store/store';
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
  name: "Header",
  data(){
    return{
      store,
      router : useRouter(),
      errors: store.errors,
      user : store.user,
    }
  },

  mounted(){
    this.store.getUser()
  },

  computed : {
    getUserData(){
      return this.store.user;
    },

  }

}
</script>
<!-- Fixare il redirect dello store quando si effettua un logout  -->
<template>
  <header>
    <!-- mobile-navbar ----------------------------------------------------------------------->
    <div class="mobile-navbar">
      <nav style="background-color: #ebebeb !important" class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <router-link  :to="{ name: 'home' }" class="me-5">
            <img class="logo" src="/img/logo-big.svg" alt="Logo">
          </router-link>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse vf-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item" @click="store.suggestions = null">
                <router-link  :to="{ name: 'home' }" class="nav-link fw-semibold">Home</router-link>
              </li>
              <li class="nav-item" @click="store.suggestions = null">
                <router-link  :to="{ name: 'advanced-search' }"  class="nav-link fw-semibold">Ricerca Avanzata</router-link>
              </li>
              <li v-if="store.user" class="nav-item" @click="store.showSuggestions = false">
                <router-link  :to="{ name: 'apartments' }"  class="nav-link fw-semibold">Gestione Appartamenti</router-link>
              </li>
              <li class="nav-item log-btn">
                <div>
                  <button v-if="!store.user" class="btn btn-login t4-btn d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#login-modal">
                    <i class="fa-solid fa-circle-user me-2 fs-6"></i>
                    <span class="me-1">Login</span>
                  </button>
                  <a v-else href="/" @click="store.handleLogout()" type="submit" class="btn btn-logout t4-btn d-flex align-items-center">
                    <i class="fa-solid fa-right-from-bracket me-2 fs-6"></i>
                    <span class="me-1">Logout</span>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <!-- /mobile-navbar ----------------------------------------------------------------------->
    <!-- display-navbar ----------------------------------------------------------------------->
    <div class="display-navbar">
      <div class="t4-container d-flex justify-content-between align-items-center h-100">

        <nav class="d-flex align-items-center">
          <router-link  :to="{ name: 'home' }" class="me-5">
            <img class="logo" src="/img/logo-big.svg" alt="Logo">
          </router-link>

          <ul class="d-flex align-items-center mb-0 h-100">
            <li class="header-menu-item me-4" @click="store.showSuggestions = false">
              <router-link :to="{ name: 'home' }" class="nav-link fw-semibold">Home</router-link>
            </li>
            <li class="header-menu-item me-4" @click="store.showSuggestions = false">
              <router-link :to="{ name: 'advanced-search' }" class="nav-link fw-semibold">Ricerca Avanzata</router-link>
            </li>
            <li v-if="store.user" class="header-menu-item" @click="store.showSuggestions = false">
              <router-link :to="{ name: 'apartments' }" class="nav-link fw-semibold">Gestione Appartamenti</router-link>
            </li>
          </ul>
        </nav>

        <div>

          <button v-if="!store.user" class="btn btn-login t4-btn d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#login-modal">
            <i class="fa-solid fa-circle-user me-2 fs-6"></i>
            <span class="me-1">Login</span>
          </button>

          <a v-else href="/" @click="store.handleLogout()" type="submit" class="btn btn-logout t4-btn d-flex align-items-center">
            <i class="fa-solid fa-right-from-bracket me-2 fs-6"></i>
            <span class="me-1">Logout</span>
          </a>

        </div>

      </div>
    </div>
    <!-- /display-navbar ----------------------------------------------------------------------->

  </header>


  <!-- Modal Login -->
  <div class="modal fade" id="login-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="modal-title fs-3 fw-semibold text-center mt-2 mb-4">Accedi</h1>

          <div v-if="store.credentialError" class="text-danger">
               <p>{{ store.credentialError }}</p>
          </div>

          <form @submit.prevent="store.handleLogin()">
            <div class="d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="this.store.formLogin.loginEmail"
                required
                type="loginEmail"
                name="loginEmail"
                id="loginEmail"
                class="form-control"
                placeholder="Email">

              <label for="loginEmail" class="form-label mb-0">
                <i class="fa-solid fa-envelope"></i>
              </label>
            </div>
            <div v-if="store.errorslogin.email" class="text-danger">
               <p>{{ store.errorslogin.email }}</p>
            </div>

            <div class="mt-2 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="this.store.formLogin.loginPassword"
                type="password"
                required
                name="loginPassword"
                id="loginPassword"
                class="form-control"
                placeholder="Password">

              <label for="loginPassword" class="form-label mb-0">
                <i class="fa-solid fa-key"></i>
              </label>
            </div>
            <div v-if="store.errorslogin.password" class="text-danger ">
               <p>{{ store.errorslogin.password }}</p>
            </div>

            <button   type="submit" class="btn t4-btn my-3 w-100 btn-modal">Sign In</button>
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <p>Non hai ancora un account? <span class="fw-semibold redirect" data-bs-toggle="modal" data-bs-target="#register-modal"  >Registrati</span></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Register -->
  <div class="modal fade" id="register-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="modal-title fs-3 fw-semibold text-center mt-2 mb-4" id="registerModalLabel">Registrati</h1>
          <form @submit.prevent="this.store.handleRegistration()">

            <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
              <input
                v-model="store.form.name"
                required
                type="text"
                id="name"
                name="name"
                class="form-control"
                placeholder="Nome e Cognome">
              <label  for="name" class="form-label mb-0"><i class="fa-solid fa-user"></i></label>
            </div>
            <div v-if="store.errors.name" class="error-message">
               <p>{{ store.errors.name }}</p>
            </div>

            <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
              <input
              v-model="store.form.email"
                required
                type="email"
                id="email"
                name="email"
                class="form-control"
                placeholder="Email">
              <label for="email" class="form-label mb-0"><i class="fa-solid fa-envelope"></i></label>
            </div>
            <div v-if="store.errors.email" class="error-message">
               <p>{{ store.errors.email }}</p>
            </div>

            <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
              <input
              v-model="store.form.password"
                required
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Password">
              <label for="password" class="form-label mb-0"><i class="fa-solid fa-key"></i></label>
            </div>
            <div v-if="store.errors.password" class="error-message">
               <p>{{ store.errors.password }}</p>
            </div>
            <button type="submit" class="btn t4-btn my-3 w-100 btn-modal">Sign Up</button>
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <p>Hai già un account? <span class="fw-semibold redirect" data-bs-toggle="modal" data-bs-target="#login-modal">Accedi</span></p>
        </div>
      </div>
    </div>
  </div>

</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
.mobile-navbar {
    display: none;
    box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  }

header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  height: 70px;
  background-color: $dark_white;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);

  .display-navbar {
    height: 100%;
  }
  nav {
    .logo {
      width: 100px;
      margin-bottom: 8px;
    }

    .nav-link {
      color: $dark-gray;
      transition: all 0.3s;

      &:hover,
      &.active {
        cursor: pointer;
        color: $light_blue;
      }
    }
  }

  .btn-login,
  .btn-logout {
    font-size: 0.9rem;
  }
}
// media-query
@media screen and (max-width: 1000px) {
  header {
    height: 0;
  }
  .display-navbar {
    display: none;
  }
  .mobile-navbar {
    display: block;
  }
  .log-btn {
    width: 100px;
    margin-top: 20px;
  }
}

</style>
