import { reactive } from "vue";
import { ref } from 'vue';
import axios from 'axios';


export const store = reactive ({

  apiUrl: 'http://127.0.0.1:8000/api/',

  user : null,
  errors: {},
  errorslogin: {},

  form : ref({
    name: "",
    email: "",
    password: ""
  }),

  formLogin : ref({
    loginEmail: "",
    loginPassword: ""
  }),


  handleRegistration(){
    this.errors = {}

    if (this.form.name.length < 3) {
      this.errors.name = "Inserisci un nome valido";
    }

    if (!this.form.email.includes(".")) {
      this.errors.email = "Inserisci un indirizzo email valido";
    }

    if (this.form.password.length > 7) {
    axios.post('/register', {
      name: this.form.name,
      email: this.form.email,
      password: this.form.password,
    })
    .catch(error => {
      this.errors = error.response.data.errors;
    })
    .then(response => {
      console.log(response)

      axios.post('/login', {
        email: this.form.email,
        password: this.form.password
      })

    }).then(response => {
      this.getUser()
    })
  }else{
    this.errors.password = "La password deve essere di almeno 8 caratteri"
  }


  },

  handleLogin(){
    this.errorslogin = {}

    if (!this.formLogin.loginEmail.includes("@")) {
      this.errorslogin.email = "Inserisci un indirizzo email valido";
      console.log(this.errorslogin)
    }
    //  if (this.formLogin.loginPassword.length > 7) {
    //   this.errorslogin.push("La password deve essere di almeno 8 caratteri")
    //   console.log(this.errorslogin)}


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

        .catch(error => {
          this.errorslogin = error.response.data.errors;
          console.log('errore',error.response)
        });
      })

      }else{
        this.errorslogin.password = "La password deve essere di almeno 8 caratteri"
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
});
