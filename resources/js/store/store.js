import { reactive } from "vue";
import { ref } from 'vue';
import axios from 'axios';


export const store = reactive ({
// TomTom Api Datas
  apiUrl: 'http://127.0.0.1:8000/api/',
  apiKey: 'BJn2pmnX1Y20KpKZAZYCLf4m1Gzqu2bG',
  adminUrl: 'http://127.0.0.1:8000/admin/',

// user logged in and form errors
  user : null,
  errors: null,

// Autocomplete fields
  suggestions: null,
  showSuggestions: false,

// Login and register forms fields
  form : ref({
    name: "",
    email: "",
    password: ""
  }),

  formLogin : ref({
    loginEmail: "",
    loginPassword: ""
  }),

// Handling authorizations
  handleRegistration(){
    axios.post('/register', {
      name: this.form.name,
      email: this.form.email,
      password: this.form.password,
    }).then(() => {

      axios.post('/login', {
        email: this.form.email,
        password: this.form.password
      })
    }).then(response => {
      this.getUser()

    })

  },

  handleLogin(){

    if(this.formLogin.loginPassword.length > 7){

      axios.get('sanctum/csrf-cookie')
      .then(result =>{
        axios.post('/login', {
          email: this.formLogin.loginEmail,
          password: this.formLogin.loginPassword
        })
        .then(response => {
          this.getUser()

          this.formLogin = ref({
            loginEmail: "",
            loginPassword: ""
          })
        })
      })
    }else {
      this.errors = "La password deve avere almeno 8 caratteri"
    }

  },

  handleLogout(){
    axios.post('/logout').then(response => {
      this.user = null;
    })
  },

  getUser() {
    axios.get('sanctum/csrf-cookie')
        .then(() => {
          axios.get('admin/user-auth')
                      .then(response => {
                        this.user = response.data
                      })
        })
  },

// Getting suggestions for adressed autocomplete w/ TomTom Api
  getSuggestions(address){
    if(address.length >= 3){

      axios
      .get('https://api.tomtom.com/search/2/search/' + address + '.json', {
        params: {
          key: this.apiKey,
          language: 'it-IT',
          limit: 5,
        }})
        .then((response) => {
          this.suggestions = response.data.results;
          this.showSuggestions = true;
        })
        .catch(error => {
          this.errors = error
        });

      }else {
        this.showSuggestions = false;
      }
  },

  selectAddress(formField, suggest) {
    formField.address = suggest.address.freeformAddress;
    this.showSuggestions = false;
  },

});
