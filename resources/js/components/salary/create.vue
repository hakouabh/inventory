  

<template>
  
  <div>

 <div class="row">
  <router-link to="/employee" class="btn btn-primary">{{ $t('router.all_employee') }}</router-link>
   
 </div>
    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{ $t('table.button.pay_salary') }}</h1>
                  </div>

      <form class="user" @submit.prevent="SalaryPaid">

        <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
            	<label for="exampleFormControlSelect1"><b>{{ $t('form.label.employee') }}</b></label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-model="form.name">
       <small class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </small>
            </div>


     <div class="col-md-6">
     	<label for="exampleFormControlSelect1"><b>{{ $t('form.label.employee_email') }}</b></label>
         <input type="email" class="form-control" id="exampleInputFirstName" v-model="form.email">
         <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>
            </div>     
            
          </div>
        </div>
       
        
         <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
      <label for="exampleFormControlSelect1"><b>{{ $t('form.label.month') }}</b></label>
  
  <select class="form-control" id="exampleFormControlSelect1" v-model="form.salary_month">
     <option value="January"> {{  $t('months.January') }} </option>
     <option value="February"> {{  $t('months.February') }} </option>
     <option value="March"> {{  $t('months.March') }} </option>
     <option value="April"> {{  $t('months.April') }} </option>
     <option value="May"> {{  $t('months.May') }} </option>
     <option value="Jun"> {{  $t('months.Jun') }} </option>
     <option value="July"> {{  $t('months.July') }} </option>
     <option value="August"> {{  $t('months.August') }} </option>
     <option value="September"> {{  $t('months.September') }} </option>
     <option value="October"> {{  $t('months.October') }} </option>
     <option value="November"> {{  $t('months.November') }} </option>
     <option value="December"> {{  $t('months.December') }} </option> 
                      </select>   
   <small class="text-danger" v-if="errors.salary_month"> {{ errors.salary_month[0] }} </small>   
            </div>


     <div class="col-md-6">
     	<label for="exampleFormControlSelect1"><b>{{ $t('form.label.salary') }}</b></label>
         <input type="text" class="form-control" id="exampleInputFirstName" v-model="form.sallery">
         <small class="text-danger" v-if="errors.sallery"> {{ errors.sallery[0] }} </small>
            </div>     
            
          </div>
        </div>

       
 

 


        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">{{ $t('button.paynow') }}</button>
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
        salary_month: '',
        sallery: ''
       
      },
      errors:{}
    }
  },
  created(){
  	let id = this.$route.params.id
  	axios.get('/api/employees/show/'+id)
  	.then(({data}) => (this.form = data))
  	.catch(console.log('error'))
  },

  methods:{
   
  SalaryPaid(){
  	  let id = this.$route.params.id
       axios.post('/api/salary/paid/'+id,this.form)
       .then(() => {
        this.$router.push({ name: 'given-salary'})
        Notification.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
  } 


  }
   
</script>


<style type="text/css">
  
</style>