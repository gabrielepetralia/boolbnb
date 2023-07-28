
<script type="text/javascript">


import axios from 'axios'
import { store } from '../store/store'
export default {
  name: "Checkout",

  data(){
    return{
      store,
      token: null,
      message: null,
      loading: true
    }
  },

  methods: {
    getToken(){

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

              }else {
                this.makePayment()

              }

              document.getElementById('nonce').value = payload.nonce;

            });
          });
        });
      })

    },
    makePayment(){
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
  <div v-show="!loading" class="t4-container w-50 mx-auto">


    <div v-if="this.message">
      {{ this.message }}
    </div>

    <form id="payment-form">
      <div id="dropin-container" class="w-50 mx-auto"></div>

      <div class="w-50 mx-auto">

        <input type="submit" class="btn btn-secondary w-100" />
        <input type="hidden" id="nonce" name="payment_method_nonce" />
      </div>
    </form>
  </div>

  <div v-if="loading" >
    <h3 class="text-center mt-5">Loading...</h3>
  </div>
</template>




<style >

</style>
