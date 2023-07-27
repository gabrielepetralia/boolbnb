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
  <div class="t4-container py-0 px-0 py-sm-5 py-sm-5">
    <h2 class="fs-3 fw-semibold my-4 title">Messaggi</h2>

    <div v-if="!this.loading" class="container vf-container mt-5">
      <!-- top -->
      <div class="top d-flex align-items-center">
        <div class="apartment d-flex align-items-center">
          <div class="img">
            <img :src="this.apartments[counter].img_path ?? '/img/house-placeholder.png'" alt="">
          </div>
          <h4 class="name m-0 fw-semibold">{{ this.apartments[counter].title }}</h4>
        </div>
      </div>
      <!-- /top -->
      <!-- bottom -->
      <div class="bottom d-flex">
        <!-- side -->
        <div class="side">
          <ul class="d-flex d-lg-block">
            <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">
              <a :class="{'active-msg' : this.counter == index}">
                {{apartment.title}}
              </a>
            </li>
          </ul>
        </div>
        <!-- /side -->
        <!-- main -->
        <div class="main">

          <h4 class="no-messages text-center pt-5" v-if="this.apartments[counter].messages.length === 0">Non hai ancora ricevuto nessun messaggio per questo appartamento</h4>

          <div v-else v-for="(message,index) in this.apartments[counter].messages" :key="index" class="msg-card">
            <div class="sender d-flex align-items-start">
              <div class="img">
                <img src="../../assets/img/home-carousel/user-placeholder.png" alt="">
              </div>
              <div class="text">
                <h5 class="name d-block m-0">{{ message.name }}</h5>
                <span class="mail">{{ message.email }}</span>
              </div>
            </div>
            <hr>
            <div class="text">
              <p>{{ message.msg_text }}</p>
              <span class="sent-time">{{ message.sent_date }}</span>
            </div>
          </div>

          <!-- msg-fake--------------------------------------------------------------- -->
          <!-- <div class="msg-card">
            <div class="sender d-flex align-items-start">
              <div class="img">
                <img src="../../assets/img/home-carousel/user-placeholder.png" alt="">
              </div>
              <div class="text">
                <h5 class="name d-block m-0">Utente 1</h5>
                <span class="mail">utente@gmail.com</span>
              </div>
            </div>
            <hr>
            <div class="text">
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed vero harum doloribus perspiciatis ea aliquid earum debitis laborum. Fuga, libero! Unde non, assumenda maxime qui accusantium nemo, eos dignissimos rem sunt quibusdam nostrum ducimus ea quo deserunt beatae harum reprehenderit sapiente, repudiandae id molestiae exercitationem soluta quasi est impedit? Magnam?</p>
              <span class="sent-time">30/07/2023 10.00.00</span>
            </div>
          </div>
          <div class="msg-card">
            <div class="sender d-flex align-items-start">
              <div class="img">
                <img src="../../assets/img/home-carousel/user-placeholder.png" alt="">
              </div>
              <div class="text">
                <h5 class="name d-block m-0">Utente 1</h5>
                <span class="mail">utente@gmail.com</span>
              </div>
            </div>
            <hr>
            <div class="text">
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed vero harum doloribus perspiciatis ea aliquid earum debitis laborum. Fuga, libero! Unde non, assumenda maxime qui accusantium nemo, eos dignissimos rem sunt quibusdam nostrum ducimus ea quo deserunt beatae harum reprehenderit sapiente, repudiandae id molestiae exercitationem soluta quasi est impedit? Magnam?</p>
              <span class="sent-time">30/07/2023 10.00.00</span>
            </div>
          </div> -->
          <!-- msg-fake--------------------------------------------------------------- -->
        </div>
        <!-- /main -->
      </div>
      <!-- /bottom -->
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
// .active-msg {
//   border-left: 5px solid $light_blue;
//   background-color: $gray;
// }

.title {
  color: $dark-gray;
}
.vf-container {
  height: 700px;
  padding: 0;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  border-radius: 15px;
  overflow: hidden;
}
.top {
  width: 100%;
  height: 15%;
  padding: 20px;
  margin-bottom: 10px;
  background: $dark-white;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  .apartment {
    .img {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      overflow: hidden;
    }
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .name {
      padding-left: 15px;
      color: $dark-gray;
    }

  }
}
.bottom {
  height: 85%;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  .side {
  width: 18%;
  height: 100%;
  overflow: auto;
  background: $dark-gray;
  color: white;
  li {
    a {
      display: inline-block;
      height: 100%;
      width: 100%;
      color: white;
      font-size: 1rem;
      border-left: 5px solid transparent;
      padding: 15px;
      transition: all 0.3s;
      cursor: pointer;

      &:hover,
      &.active-msg {
        border-left: 5px solid $light_blue;
        background-color: $gray;
      }
    }
  }
}
  .main {
    width: 82%;
    padding: 15px;
    height: 100%;
    background: $dark-white;
    overflow: auto;
    .no-messages {
      color: $dark-gray;
    }

    .msg-card {
      width: 80%;
      margin: 9px;
      padding: 25px;
      border-radius: 0 9px 9px 9px;
      background: $light-blue;
      color: $dark-gray;
      box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
      .sender {
        .img {
          width: 38px;
          border-radius: 50%;
          overflow: hidden;
          margin-right: 8px;
          img {
            width: 100%;
          }
        }
        .text {
          .name {
            font-size: 18px;
          }
          .mail {
            font-size: 14px;
            font-weight: 100;
          }
        }
      }
      .text {
        position: relative;
        p {
          margin-bottom: 15px;
        }
        .sent-time {
          position: absolute;
          right: 0;
          font-size: 11px;
          font-weight: 100;
        }
      }

    }
  }
}
//media-query
@media screen and (max-width: 992px) {
  .t4-container {
  padding: 0;
}
.title {
  margin-bottom: 20px;
}
.top {
  .apartment {
    .name {
    font-size: 19px;
  }
  }
}
.bottom {
  flex-direction: column;
  .side {
    width: 100%;
    max-height: 97px;
    ul {
      height: 100%;
    }
    li {
      div {
        border-left: 0;
        border-bottom: 5px solid transparent;
        padding-right: 20px;
        &:hover {
          border-left: 0;
          border-bottom: 5px solid $light-blue;
        }
      }
    }
  }
  .main {
    width: 100%;
    .msg-card{
      width: 90%;
    }
  }
}
}
</style>
