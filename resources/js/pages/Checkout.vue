
<script type="text/javascript">
import Loader from "../components/partials/Loader.vue";
import axios from 'axios'
import { store } from '../store/store'
export default {
  name: "Checkout",

  components: {
    Loader
  },

  data(){
    return{
      store,
      token: null,
      message: null,
      loading: true,
      transactionMessage: null
    }
  },

  methods: {
    getToken(){
      this.transactionMessage = null
      axios.get('/generate-token')
      .then(result => {
        const form = document.getElementById('payment-form');
        this.token = result.data.token;


        braintree.dropin.create({
          authorization: result.data.token,
          container: '#dropin-container',
          locale: "it_IT"
        }, (error, dropinInstance) => {
          if (error) console.error(error);
          this.loading = false;
          form.addEventListener('submit', event => {
            event.preventDefault();

            dropinInstance.requestPaymentMethod((error, payload) => {
              if (error) {
                console.log(error)
                this.transactionMessage = "Ops, qualcosa è andato storto."

              }else {
                this.makePayment()
                dropinInstance.teardown(function(err) {
                  if (err) { console.error('An error occurred during teardown:', err); }
                });
                this.transactionMessage = "Transazione avvenuta con successo."
              }

              document.getElementById('nonce').value = payload.nonce;

            });
          });
        });
      })

    },
    makePayment(){
      const invia = document.getElementById('invia')
      invia.style.display = 'none'
      const form = document.getElementById('payment-form');

      axios.post('/make-payment', {
        payment_method_nonce: this.token,
        sponsorshipId: this.$route.params.id
      }, {
        headers: {
          "accept" : "application/json"
        }
      })
      .then(response => {
        console.log(response);
        this.message = response.data.message;
        store.sponsorizeApartment(this.$route.params.apartmentId)
        const invia = document.getElementById('invia')
      invia.style.display = 'block'
        this.$router.push('/my-apartments/sponsorships')
      })
    }
  },

  mounted(){
    this.getToken()
  }
}
</script>


<template>

<div class="checkout">
  <div v-show="!loading" class="t4-container w-50 mx-auto mt-5">
    <div v-if="transactionMessage !== null" class="alert alert-success " :class="{'alert-danger' : this.transactionMessage.includes('Ops')}" role="alert">
      {{ this.transactionMessage }}
    </div>


    <div v-if="this.message">
      {{ this.message }}
    </div>

    <form id="payment-form">
      <div id="dropin-container" class="w-50 mx-auto"></div>

      <div class="w-50 mx-auto">

        <input id="invia" type="submit" class="btn t4-btn w-100" />
        <input type="hidden" id="nonce" name="payment_method_nonce" />
      </div>
    </form>
  </div>

  <div v-if="this.loading" class="d-flex justify-content-center py-5 my-5">
    <Loader/>
  </div>
</div>
</template>




<style lang="scss" scoped>
@use "../../scss/partials/variables" as *;
  .checkout {
    min-height: calc(100vh - 70px);
    padding-top: 70px;
    background-color: $dark-white;
  }
</style>
