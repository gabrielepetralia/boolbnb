<script>
export default {
  name: "Header"
}
</script>

<template>
  <header>
    <div class="t4-container d-flex justify-content-between align-items-center h-100">

      <nav class="d-flex align-items-center">
        <a href="#" class="me-5">
          <img class="logo" src="/img/logo-big.svg" alt="Logo">
        </a>

        <ul class="d-flex align-items-center mb-0 h-100">
          <li class="header-menu-item me-4">
            <router-link :to="{ name: 'home' }" class="nav-link fw-semibold">Home</router-link>
          </li>
          <li class="header-menu-item">
            <router-link :to="{ name: 'dashboard' }" class="nav-link fw-semibold">Dashboard</router-link>
          </li>
        </ul>
      </nav>

      <div>
        <button class="btn btn-login d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#login-modal">
          <i class="fa-solid fa-circle-user me-2 fs-6"></i>
          <span class="me-1">Login</span>
        </button>
      </div>

    </div>
  </header>


  <!-- Modal Login -->
  <div class="modal fade" id="login-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="modal-title fs-3 fw-semibold text-center mt-2 mb-4">Accedi</h1>

          <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
            <input type="email" class="form-control" placeholder="Email">
            <label for="exampleFormControlInput1" class="form-label mb-0"><i class="fa-solid fa-envelope"></i></label>
          </div>

          <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
            <input type="password" class="form-control" placeholder="Password">
            <label for="exampleFormControlInput1" class="form-label mb-0"><i class="fa-solid fa-key"></i></label>
          </div>

          <button type="button" class="btn my-3 w-100 btn-modal">Sign In</button>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <p>Non hai ancora un account? <span class="fw-semibold redirect" data-bs-toggle="modal" data-bs-target="#register-modal">Registrati</span></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Register -->
  <div class="modal fade" id="register-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h1 class="modal-title fs-3 fw-semibold text-center mt-2 mb-4" id="registerModalLabel">Registrati</h1>

          <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
            <input type="text" class="form-control" placeholder="Nome e Cognome">
            <label for="exampleFormControlInput1" class="form-label mb-0"><i class="fa-solid fa-user"></i></label>
          </div>

          <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
            <input type="email" class="form-control" placeholder="Email">
            <label for="exampleFormControlInput1" class="form-label mb-0"><i class="fa-solid fa-envelope"></i></label>
          </div>

          <div class="mb-3 d-flex align-items-center flex-row-reverse input-box">
            <input type="password" class="form-control" placeholder="Password">
            <label for="exampleFormControlInput1" class="form-label mb-0"><i class="fa-solid fa-key"></i></label>
          </div>

          <button type="button" class="btn my-3 w-100 btn-modal">Sign Up</button>
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

header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  height: 70px;
  background-color: $dark_white;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);

  nav {
    .logo {
      width: 100px;
      margin-bottom: 8px;
    }

    .nav-link {
      color: $dark-gray;

      &:hover {
        cursor: pointer;
        color: $light_blue;
      }
    }
  }

  .btn-login {
    font-size: 0.9rem;
    color: white;
    background-color: $dark_gray;
    transition: all 0.3s;

    &:hover {
      background-color: $light_blue;
    }
  }
}

.modal {
  color: $dark-gray;

  .modal-header {
    .btn-close {
      &:focus {
        border: none;
        outline:none;
        box-shadow: none;
      }
    }
  }

  .modal-body {
    margin: 0 80px;

    .input-box {
      border-bottom: 1px solid $dark-gray;

      .form-control {
        border: none;
        outline:none;
        box-shadow: none;

        &:focus + label{
          color: $light_blue;
          border: none;
          outline:none;
          box-shadow: none;
        }
      }
    }

    .btn-modal {
      color: white;
      background-color: $dark_gray;
      transition: all 0.3s;

      &:hover {
        background-color: $light_blue;
      }
    }
  }

  .modal-footer {
    .redirect {
      color: $dark_gray;
      text-decoration: underline;

      &:hover {
        cursor: pointer;
        color: $light_blue
      }
    }
  }

}
</style>
