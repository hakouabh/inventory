  

<template>
  
  <div>

 <div class="row">
  <router-link to="/supplier" class="btn btn-primary">{{ $t('router.all_supplier') }}</router-link>
   
 </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{ $t('form.name.update_supplier') }}</h1>
                  </div>

      <form class="user" @submit.prevent="supplierUpdate" enctype="multipart/form-data">

        <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.name') " v-model="form.name">
       <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
            </div>


     <div class="col-md-6">
         <input type="email" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.email') " v-model="form.email">
         <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
            </div>     
            
          </div>
        </div>
       
        
         <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.address') " v-model="form.address">
         <small class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </small>
            </div>


     <div class="col-md-6">
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.shop_name') " v-model="form.shopname">
         <small class="text-danger" v-if="errors.shopname"> {{ errors.shopname[0] }} </small>
            </div>     
            
          </div>
        </div>

       
 


        <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.phone') " v-model="form.phone">
         <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
            </div>


     <div class="col-md-6">
        
            </div>     
            
          </div>
        </div>


         <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
   <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">

  <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
       <label class="custom-file-label" for="customFile">{{ $t('form.label.choose_file') }}</label>
            </div>


     <div class="col-md-6">
        <img :src="form.photo" style="height: 40px; width: 40px;">
            </div>     
            
          </div>
        </div>

 


        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">{{ $t('button.update') }}</button>
        </div>
        
      </form>
                  <hr>
                  <div class="text-center">
  
  
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</template>



<script type="text/javascript">
  
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },

    data(){
    return {
      form:{
        name: '',
        email: '',
        phone: '',
        shopname: '',
        address: '',
        photo: '',
        newphoto: ''
        
      },
      errors:{}
    }
  },
  created(){
  	let id = this.$route.params.id
  	axios.get('/api/suppliers/show/'+id)
  	.then(({data}) => (this.form = data))
  	.catch(console.log('error'))
  },

  methods:{
    onFileSelected(event){
     let file = event.target.files[0];
     if (file.size > 1048770) {
      Notification.image_validation()
     }else{
      let reader = new FileReader();
      reader.onload = event =>{
        this.form.newphoto = event.target.result
       
      };
      reader.readAsDataURL(file);
     }

    },
  supplierUpdate(){
  	  let id = this.$route.params.id
       axios.put('/api/suppliers/update/'+id,this.form)
       .then(() => {
        this.$router.push({ name: 'supplier'})
        Notification.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
  } 


  }
   
</script>


<style type="text/css">
  
</style>