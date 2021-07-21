 

<template>
  
  <div>
   <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Alerts</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Quantity</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in alerts" :key="product.id">
                        <td> {{ product.product_name }} </td>
                        <td> {{ product.product_code }} </td>
                        <td><img :src="product.image" id="em_photo"></td>
                         <td>{{ product.product_quantity }}</td>
            <td>
   <router-link :to="{name: 'edit-stock', params:{id:product.product_id}}" class="btn btn-sm btn-primary">Edit</router-link>
 
            </td>
                      </tr>
                    
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
          <!--Row-->


   
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
      return{
        alerts:[]
      }
    }, 
  methods:{
    allAlert(){
      axios.get('/api/alert/product')
      .then(({data}) => (this.alerts = data))
      .catch()
    }   

  },
  created(){
    this.allAlert();
  } 
  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>