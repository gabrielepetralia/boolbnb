<script>
import axios from "axios";
import { store } from "../../store/store";

import Loader from "../../components/partials/Loader.vue";

export default {
  name: "DashboardMessages",

  components: {
    Loader
  },

  data() {
    return {
      store,
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
          this.loading = false;
        });
      });
    },

    formatDate (date){
      return new Date(date).toLocaleDateString('it-IT', { weekday:"long", year:"numeric", month:"short", day:"numeric", hour:'2-digit', minute:'2-digit'}) ;

    }
  },

  mounted(){
    this.getMyApartments()

  }
}
</script>

<template>
  <div class="t4-container py-0 px-0 py-md-5 px-md-5">
    <h2 class="fs-3 fw-semibold my-4 title">Messaggi</h2>


    <div v-if="this.loading" class="d-flex justify-content-center py-5 my-5">
      <Loader/>
    </div>

    <div v-else class="container vf-container mt-4">
      <!-- top -->
      <router-link :to="{ name: 'apartment-detail-admin', params: { slug: this.apartments[counter].slug } }" class="top d-flex align-items-center p-4">
        <div class="apartment d-flex align-items-center">
          <div class="img me-3">
            <img :src="this.apartments[counter].img_path ?? '/img/house-placeholder.png'" alt="">
          </div>
          <h4 class="name m-0 fw-semibold">{{ this.apartments[counter].title }}</h4>
        </div>
      </router-link>
      <!-- /top -->

      <!-- bottom -->
      <div class="bottom d-flex">
        <!-- side -->
        <div class="side">
          <ul class="d-flex d-lg-block">
            <li @click="this.counter = index" v-for="(apartment, index) in this.apartments" :key="index">
              <div :class="{'active-msg' : this.counter == index}">
                {{apartment.title}}
              </div>
            </li>
          </ul>
        </div>
        <!-- /side -->

        <!-- main -->
        <div class="main">

          <h4 class="no-messages text-center pt-5" v-if="this.apartments[counter].messages.length === 0">Non hai ancora ricevuto nessun messaggio per questo appartamento</h4>

          <div v-else v-for="(message,index) in this.apartments[counter].messages" :key="index" class="msg-card m-3">
            <div class="sender d-flex align-items-start">
              <div class="img me-2">
                <img src="/img/user-placeholder.png" alt="">
              </div>
              <div class="text">
                <h5 class="name d-block m-0">{{ message.name }}</h5>
                <span class="mail">{{ message.email }}</span>
              </div>
            </div>
            <hr>
            <div class="text">
              <p>{{ message.msg_text }}</p>
              <span class="sent-time text-capitalize">{{ this.formatDate(message.sent_date) }}</span>
            </div>
          </div>

        </div>
        <!-- /main -->

      </div>
      <!-- /bottom -->
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/partials/variables" as *;
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
  margin-bottom: 10px;
  background: $dark-white;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  .apartment {
    .img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      overflow: hidden;
    }
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .name {
      color: $dark-gray;
    }

  }
}
.bottom {
  height: 83%;
  box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
  .side {
  width: 18%;
  height: 100%;
  overflow: auto;
  background: $dark-gray;
  color: white;
  li {
    div {
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
      padding: 25px;
      border-radius: 0 9px 9px 9px;
      background: $light-blue;
      color: $dark-gray;
      box-shadow: 0 0 20px 4px rgba(0, 0, 0, 0.15);
      .sender {
        .img {
          width: 40px;
          height: 40px;
          border-radius: 50%;
          overflow: hidden;
          object-fit: cover;

          img {
            width: 100%;
            object-fit: cover;
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
          font-size: 12px;
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
    max-height: 75px;
    ul {
      height: 100%;
    }
    li {
      div {
        border-left: 0;
        border-bottom: 5px solid transparent;
        padding-right: 20px;
        height: 100%;
        &:hover,
        &.active-msg {
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
