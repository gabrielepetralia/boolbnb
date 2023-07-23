
<script>
import axios from 'axios';
import { store } from '../../../store/store';
export default {
  name: 'AddGallery',

  data(){
    return{
      images: [],
    }


  },

  props:{
    apartment_id : Number
  },

  methods:{
    addGallery(){
      if(this.images.length > 0){
        axios.get('sanctum/csrf-cookie')
        .then(()=>{
          axios.post(store.adminUrl + 'images', {
            images: this.images,
            apartment_id : this.apartment_id,
          },{
            headers:{
              'content-type' : 'multipart/form-data'
            }
          })
          .then(result=>{
            console.log((result));
          })
        })
      }

    },


  onChangeMultiple(event){
      this.images= event.target.files
      console.log(this.images);
    }
  }
}
</script>
<template>


<div class="mt-5 d-flex align-items-center flex-row-reverse input-box pb-2">
  <input
  @change="onChangeMultiple"
    type="file"
    title="Galleria"
    id="img_path_gallery"
    name="img_path_gallery"
    class="form-control ms-2"
    placeholder="Immagine"
    multiple
    max="">
  <label for="img_path_gallery" class="form-label mb-0"><i class="fa-solid fa-image"></i></label>
</div>

<div class="btn btn-dark" @click="addGallery">Add</div>
</template>

<style>

</style>
