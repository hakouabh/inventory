   

<template>
  
  <div>

 <div class="row">
  <router-link to="/category" class="btn btn-primary">{{ $t("router.all_category") }} </router-link>
   
 </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{ $t("form.name.update_category") }}</h1>
                  </div>

      <form class="user" @submit.prevent="categoryUpdate">

        <div class="form-group">

          <div class="form-row">
            <div class="col-md-12">
         <input type="text" class="form-control" id="exampleInputFirstName" v-bind:placeholder="$t('form.placeholder.category_name')" v-model="form.category_name">
  <small class="text-danger" v-if="errors.category_name"> {{ errors.category_name[0] }} </small>
           

            </div> 
            
          </div>
        </div>
       
         
 


        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">{{ $t("button.update") }}</button>
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
        category_name: '',
       
        
      },
      errors:{}
    }
  },
  created(){
  	let id = this.$route.params.id
  	axios.get('/api/categories/show/'+id)
  	.then(({data}) => (this.form = data))
  	.catch(console.log('error'))
  },

  methods:{
    
  categoryUpdate(){
  	  let id = this.$route.params.id
       axios.post('/api/categories/update/'+id,this.form)
       .then(() => {
        this.$router.push({ name: 'category'})
        Notification.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
  } 


  }
   
</script>


<style type="text/css">
  
</style>