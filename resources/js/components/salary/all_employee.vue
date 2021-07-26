

<template>
  
  <div>

 <div class="row">
  <router-link to="/store-employee" class="btn btn-primary">{{ $t('router.add_employee') }}</router-link>
   
 </div>
<br>
   <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" v-bind:placeholder=" $t('form.placeholder.search') ">


<br>

   <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{$t('table.name.employee')}}</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{ $t('table.feild.name') }}</th>
                        <th>{{ $t('table.feild.photo') }}</th>
                        <th>{{ $t('table.feild.phone') }}</th>
                        <th>{{ $t('table.feild.sallery') }}</th>
                        <th>{{ $t('table.feild.joininig_date') }}</th>
                        <th>{{ $t('table.feild.action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filtersearch" :key="employee.id">
                        <td> {{ employee.name }} </td>
                        <td><img :src="employee.photo" id="em_photo"></td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.sallery }}</td>
                        <td>{{ employee.joining_date }}</td>
            <td>
   <router-link :to="{name: 'pay-salary', params:{id:employee.id}}" class="btn btn-sm btn-primary">{{ $t('table.button.pay_salary') }}</router-link>

  
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
        employees:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.employees.filter(employee => {
         return employee.name.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allEmployee(){
      axios.get('/api/employee/')
      .then(({data}) => (this.employees = data))
      .catch()
    },
    
  },
  created(){
    this.allEmployee();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>