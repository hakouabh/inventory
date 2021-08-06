

<template>
  
  <div>

 <div class="row">
  <router-link to="/product" class="btn btn-primary">{{ $t('router.all_product') }}</router-link>
   
 </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{ $t('router.add_product') }}</h1>
                  </div>

      <form class="user" @submit.prevent="ProductInsert" enctype="multipart/form-data">

        <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
              <label for="exampleFormControlSelect1">{{ $t('form.label.product') }}</label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.product') " v-model="form.product_name">
       <small class="text-danger" v-if="errors.product_name"> {{ errors.product_name[0] }} </small>
            </div>


     <div class="col-md-6">
      <label for="exampleFormControlSelect1">{{ $t('form.label.product_code') }}</label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder=" $t('form.placeholder.product_code') " v-model="form.product_code">
         <small class="text-danger" v-if="errors.product_code"> {{ errors.product_code[0] }} </small>
            </div>     
            
          </div>
        </div>
       
        
         <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
      <label for="exampleFormControlSelect1">{{ $t('form.label.product_category') }}</label>
  <select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id">
     <option :value="category.id" v-for="category in categories">{{ category.category_name }}</option>
                       
                      </select>   
        
            </div>


     <div class="col-md-6">
          <label for="exampleFormControlSelect1">{{ $t('form.label.product_supplier') }}</label>
 <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
   
    <option :value="supplier.id" v-for="supplier in suppliers">{{ supplier.name }}</option>
                        
                      </select>    
            </div>     
            
          </div>
        </div>

       


 <div class="form-group">

          <div class="form-row">
            <div class="col-md-4">
              <label for="exampleFormControlSelect1">{{ $t('form.label.buying_date') }}</label>
         <input type="date" class="form-control" id="exampleInputFirstName" v-model="form.buying_date">
  <small class="text-danger" v-if="errors.buying_date"> {{ errors.buying_date[0] }} </small>
            </div>


 <div class="col-md-4">
              <label for="exampleFormControlSelect1">{{ $t('form.label.buying_price') }}</label>
         <input type="text" class="form-control" id="exampleInputFirstName"  v-model="form.buying_price">
       <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small>
            </div>



     <div class="col-md-4">
      <label for="exampleFormControlSelect1">{{ $t('form.label.selling_price') }}</label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-model="form.selling_price">
         <small class="text-danger" v-if="errors.selling_price"> {{ errors.selling_price[0] }} </small>
            </div>     
            
          </div>
        </div>
        <div class="form-group">

          <div class="form-row">
     <div class="col-md-6">
      <label for="exampleFormControlSelect1">{{ $t('form.label.product_quantity') }}</label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-model="form.product_quantity">
         <small class="text-danger" v-if="errors.product_quantity"> {{ errors.product_quantity[0] }} </small>
            </div>
      <div class="col-md-6">
      <label for="exampleFormControlSelect1">{{ $t('form.label.min_quantity') }}</label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-model="form.min_quantity">
         <small class="text-danger" v-if="errors.min_quantity"> {{ errors.min_quantity[0] }} </small>
            </div>     
            
          </div>
        </div>
         <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
   <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">

  <small class="text-danger" v-if="errors.image"> {{ errors.image[0] }} </small>
       <label class="custom-file-label" for="customFile">{{ $t('form.label.choose_file') }}</label>
            </div>
     <div class="col-md-6">
        <img :src="form.image" style="height: 40px; width: 40px;">
            </div>       
          </div>
        </div>

 


        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">{{ $t('button.submit') }}</button>
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
        product_name: null,
        product_code: null,
        category_id: null,
        supplier_id: null,
        buying_price: null,
        selling_price: null,
        buying_date: null,
        image: null,
        product_quantity: null,
        min_quantity: null,
        user_id:''

      },
      errors:{},
      categories:{},
      suppliers:{},
    }
  },

  methods:{
    onFileSelected(event){
     let file = event.target.files[0];
     if (file.size > 1048770) {
      Notification.image_validation()
     }else{
      let reader = new FileReader();
      reader.onload = event =>{
        this.form.image = event.target.result
      };
      reader.readAsDataURL(file);
     }

    },
  ProductInsert(){
      this.form.user_id = localStorage.getItem('user_id');
       axios.post('/api/products/store',this.form)
       .then(() => {
        this.$router.push({ name: 'product'})
        Notification.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
  },
  created(){
      axios.get('/api/categories/index/'+localStorage.getItem('user_id'))
    .then(({data}) => (this.categories = data))

      axios.get('/api/suppliers/index/'+localStorage.getItem('user_id'))
    .then(({data}) => (this.suppliers = data))

  } 


  }
   
</script>


<style type="text/css">
  
</style>