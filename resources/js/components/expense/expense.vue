   

<template>
  
  <div>

 <div class="row">
  <router-link to="/store-expense" class="btn btn-primary">{{$t('router.add_expense')}}</router-link>
   
 </div>
<br>
   <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" v-bind:placeholder="$t('form.placeholder.search')">


<br>

   <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{$t('table.feild.details')}}</th>
                        <th>{{$t('table.feild.amount')}}</th>
                        <th>{{$t('table.feild.date')}}</th>
                          <th>{{$t('table.feild.action')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="expense in filtersearch" :key="expense.id">
                        <td> {{ expense.details }} </td>
                        <td> {{ expense.amount }} </td>
                        <td> {{ expense.expense_date }} </td>
                       
            <td>
   <router-link :to="{name: 'edit-expense', params:{id:expense.id}}" class="btn btn-sm btn-primary">{{$t('table.button.edit')}}</router-link>

 <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger"><font color="#ffffff">{{$t('table.button.delete')}}</font></a>
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
        expenses:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.expenses.filter(expense => {
         return expense.expense_date.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allExpense(){
      axios.get('/api/expenses/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.expenses = data))
      .catch()
    },
  deleteExpense(id){
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
                axios.get('/api/expenses/destroy/'+id)
               .then(() => {
                this.expenses = this.expenses.filter(expense => {
                  return expense.id != id
                })
               })
               .catch(() => {
                this.$router.push({name: 'expense'})
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
    this.allExpense();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>