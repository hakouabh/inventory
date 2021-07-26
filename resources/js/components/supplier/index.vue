 

<template>
  
  <div>

 <div class="row">
  <router-link to="/store-supplier" class="btn btn-primary">{{ $t('router.add_supplier') }}</router-link>
   
 </div>
<br>
   <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" v-bind:placeholder=" $t('form.placeholder.search') ">


<br>

   <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{ $t('table.name.supplier') }}</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{ $t('table.feild.name') }}</th>
                        <th>{{ $t('table.feild.photo') }}</th>
                        <th>{{ $t('table.feild.phone') }}</th>
                        <th>{{ $t('table.feild.shop_name') }}</th>
                        <th>{{ $t('table.feild.email') }}</th>
                        <th>{{ $t('table.feild.action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="supplier in filtersearch" :key="supplier.id">
                        <td> {{ supplier.name }} </td>
                        <td><img :src="supplier.photo" id="em_photo"></td>
                        <td>{{ supplier.phone }}</td>
                        <td>{{ supplier.shopname }}</td>
                        <td>{{ supplier.email }}</td>
            <td>
   <router-link :to="{name: 'edit-supplier', params:{id:supplier.id}}" class="btn btn-sm btn-primary">{{ $t('table.button.edit') }}</router-link>

 <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger"><font color="#ffffff">{{ $t('table.button.delete') }}</font></a>
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
        suppliers:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.suppliers.filter(supplier => {
         return supplier.name.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allSupplier(){
      axios.get('/api/supplier/')
      .then(({data}) => (this.suppliers = data))
      .catch()
    },
  deleteSupplier(id){
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
                axios.delete('/api/supplier/'+id)
               .then(() => {
                this.suppliers = this.suppliers.filter(supplier => {
                  return supplier.id != id
                })
               })
               .catch(() => {
                this.$router.push({name: 'supplier'})
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
    this.allSupplier();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>