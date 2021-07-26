 

<template>
  
  <div>

 <div class="row">
  <router-link to="/store-customer" class="btn btn-primary">{{$t('router.add_customer')}}</router-link>
   
 </div>
<br>
   <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" v-bind:placeholder="$t('form.placeholder.search')">


<br>

   <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{$t('table.name.customer')}}</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{$t('table.feild.name')}}</th>
                        <th>{{$t('table.feild.photo')}}</th>
                        <th>{{$t('table.feild.phone')}}</th>
                        <th>{{$t('table.feild.email')}}</th>
                        <th>{{$t('table.feild.address')}}</th>
                        <th>{{$t('table.feild.action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="customer in filtersearch" :key="customer.id">
                        <td> {{ customer.name }} </td>
                        <td><img :src="customer.photo" id="em_photo"></td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.address }}</td>
            <td>
   <router-link :to="{name: 'edit-customer', params:{id:customer.id}}" class="btn btn-sm btn-primary">{{$t('table.button.edit')}}</router-link>

 <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger"><font color="#ffffff">{{$t('table.button.delete')}}</font></a>
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
        customers:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.customers.filter(customer => {
         return customer.name.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allCustomer(){
      axios.get('/api/customer/')
      .then(({data}) => (this.customers = data))
      .catch()
    },
  deleteCustomer(id){
             Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                axios.delete('/api/customer/'+id)
               .then(() => {
                this.customers = this.customers.filter(customer => {
                  return customer.id != id
                })
               })
               .catch(() => {
                this.$router.push({name: 'customer'})
               })
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
              }
            })

  } 

  },
  created(){
    this.allCustomer();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>