
<template>
  
  <div>
   <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $t('pos_dashboard') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">{{ $t('home') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $t('pos') }}</li>
            </ol>
          </div>

          <div class="row mb-3">
            

            <!-- Area Chart -->
            <div class="col-xl-6 col-lg-6">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
         <router-link class="btn btn-sm btn-info" to="/store-customer"><font color="#ffffff">{{ $t('router.add_customer') }}</font></router-link>         
                  
                </div>           
                <div class="table-responsive" style="font-size: 12px;">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{ $t('table.feild.name') }}</th>
                        <th>{{ $t('table.feild.quantity') }}</th>
                        <th>{{ $t('table.feild.discount') }}</th>
                        <th>{{ $t('table.feild.price') }}</th>
                        <th>{{ $t('table.feild.total') }}</th>
                        <th>{{ $t('table.feild.action') }}</th>
                      </tr>
                    </thead>
                    <tbody>

          <tr v-for="cart in carts" :key="cart.id">
            <td>{{ cart.pro_name }}</td>
            <td><input type="text" readonly="" style="width: 15px;" :value="cart.pro_quantity">
       <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success">+</button>
   <button  @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-if="cart.pro_quantity >= 2">-</button>
   <button class="btn btn-sm btn-danger" v-else="" disabled="">-</button>

            </td>
            <td>
              <button  @click.prevent="discount(cart)" class="btn btn-sm btn-danger">%</button>
            </td>
            <td>{{ cart.product_price  }}</td>
            <td>{{ cart.sub_total }}</td>
   <td><a @click="removeItem(cart.id)" class="btn btn-sm btn-primary"><font color="#ffffff">X</font></a></td>
          </tr>
                      
                       
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
            <ul class="list-group">
  <li class="list-group-item d-flex justify-content-between align-items-center">{{ $t('cart.total_qty') }}:
  <strong>{{ qty }}</strong>
   </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">{{ $t('cart.total_discount') }}:
  <strong>{{ total_discount }} $</strong>
   </li>
     <li class="list-group-item d-flex justify-content-between align-items-center">{{ $t('table.feild.total') }} :
  <strong>{{ subtotal }} $</strong>
   </li> 
              
            </ul>   
            <br> 

        <form @submit.prevent="orderdone">
          <label>{{ $t('form.label.customer_name') }}</label>
          <select class="form-control" v-model="customer_id">
         <option :value="customer.id" v-for="customer in customers">{{customer.name }} </option>
                 
           </select>

           <label>{{ $t('table.feild.pay') }}</label>
           <input type="text" class="form-control" required="" v-model="pay">

          <label>{{ $t('table.feild.payby') }}</label>
          <select class="form-control" v-model="payby">
                 <option value="HandCash">{{ $t('paybay.HandCash') }}</option>
                 <option value="Cheaque">{{ $t('paybay.Cheaque') }} </option>
                 <option value="GiftCard">{{ $t('paybay.GiftCard') }}</option>
           </select>

           <br>
           <button type="submit" class="btn btn-success">{{ $t('button.submit') }}</button>

        </form>    
                </div>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-6 col-lg-6">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{ $t('product') }}</h6>
                  </div>

   <!--  Category Wise Product -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ $t('router.all_product') }}</a>
  </li>
  <li class="nav-item" v-for="category in categories" :key="category.id">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" 
    role="tab" aria-controls="profile" 
    aria-selected="false" @click="subproduct(category.id)" >{{ category.category_name }}</a>
  </li>   
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" 
  aria-labelledby="home-tab">

<div class="card-body">
 <input type="text" v-model="searchTerm" class="form-control" v-bind:placeholder=" $t('form.placeholder.search') ">

     <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filtersearch" :key="product.id">
             <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
             <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
              <img :src="product.image" id="em_photo" class="card-img-top">
              <div class="card-body">
                <h6 class="card-title">{{ product.product_name }}</h6>
       <span class="badge badge-success" v-if="product.product_quantity  >= 1 ">{{ $t('available') }} {{ product.product_quantity }}  </span> 
    <span class="badge badge-danger" v-else=" ">{{ $t('stock_out') }}</span> 
                
              </div>
            </div></button>
          
        </div>        
      </div>

     </div>


  </div>  <!--  End TBAS HOME -->
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <br>
<input type="text" v-model="getsearchTerm" class="form-control" v-bind:placeholder=" $t('form.placeholder.search') ">
     <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getfiltersearch" :key="getproduct.id">
            <button class="btn btn-sm" @click.prevent="AddToCart(getproduct.id)">
             <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
              <img :src="getproduct.image" id="em_photo" class="card-img-top">
              <div class="card-body">
                <h6 class="card-title">{{ getproduct.product_name }}</h6>
       <span class="badge badge-success" v-if="getproduct.product_quantity  >= 1 ">{{ $t('available') }} {{ getproduct.product_quantity }}  </span> 
    <span class="badge badge-danger" v-else=" ">{{ $t('stock_out') }}</span> 
                
              </div>
            </div></button>
          
        </div>        
      </div>
  </div>
  
</div>
<!-- End Category Wise Product -->
                </div>
                 
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

    created(){
    this.allProduct();
    this.allCategory();
    this.allCustomer();
    this.cartProduct();
    Reload.$on('AfterAdd',() =>{
      this.cartProduct();
    })

   }, 
 data(){
      return{
       customer_id:'',
       pay:'',
       payby:'',
        products:[],
        categories:'',
        getproducts:[],
        searchTerm:'',
        getsearchTerm:'',
        customers:'',
        errors:'',
        carts:[],

      }
    },
    computed:{
      filtersearch(){
      return this.products.filter(product => {
         return product.product_name.match(this.searchTerm)
      }) 
      },
       getfiltersearch(){
      return this.getproducts.filter(getproduct => {
         return getproduct.product_name.match(this.getsearchTerm)
       }) 
      },
   qty(){
    let sum = 0;
    for(let i = 0; i < this.carts.length; i++){
          sum += (parseFloat(this.carts[i].pro_quantity));      
        }
        return sum;
   },
   total_discount(){
    let sum = 0;
    for(let i = 0; i < this.carts.length; i++){
          sum += (parseFloat(this.carts[i].product_discount)*parseFloat(this.carts[i].pro_quantity));      
        }
        return sum;
   },
   subtotal(){
    let sum = 0;
    for(let i = 0; i < this.carts.length; i++){
    sum += (parseFloat(this.carts[i].pro_quantity) * (parseFloat(this.carts[i].product_price)-parseFloat(this.carts[i].product_discount)));      
        }
       return sum;

      },

    },
 
  methods:{
    // Cart Methods Here
  AddToCart(id){
   axios.get('/api/addToCart/'+id)
      .then(({data}) => {
        if(data){
          Notification.cart_faild() 
        }else{
        Reload.$emit('AfterAdd');
        Notification.cart_success()
        }
        
      })
      .catch()
  },
  cartProduct(){
      axios.get('/api/cart/product/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.carts = data))
      .catch()
  },
  removeItem(id){
   axios.get('/api/remove/cart/'+id)
      .then(() => {
        Reload.$emit('AfterAdd');
        Notification.cart_delete()
      })
      .catch()
  },
  increment(id){
  axios.get('/api/increment/'+id)
      .then(({data}) => {
         if(data){
          Reload.$emit('AfterAdd');
        Notification.success()
        }else{
        Notification.cart_faild()
        }
        
      })
      .catch()
  },
   decrement(id){
    axios.get('/api/decrement/'+id)
      .then(() => {
        Reload.$emit('AfterAdd');
        Notification.success()
      })
      .catch() 
  },
  async discount(cart){
	
const { value: text } = await Swal.fire({
  title: 'Discount',
  input: 'number',
  inputLabel: 'Value'
  })

if (text) {
  var data ={
    id:cart.id,
    discount:text
  }
  Swal.fire(`Disount : ${text}`)
  axios.post('/api/discount/',data)
      .then(() => {
        Reload.$emit('AfterAdd');
      })
      .catch() 

}
  }, 
  orderdone(){
    let total = this.subtotal;
    var data = {user_id:localStorage.getItem('user_id'),qty:this.qty, subtotal:this.subtotal, customer_id:this.customer_id, payby:this.payby,total_discount:this.total_discount ,pay:this.pay, total:total }

    axios.post('/api/orderdone',data)
       .then(() => {
          Notification.success()
          this.checkAlert();
         this.$router.push({name: 'home'})
       }) 

  },
  checkAlert(){
    for(let i=0;i < this.carts.length;i++){
      let data ={
        product_id:this.carts[i].pro_id,
        user_id:localStorage.getItem('user_id')
      }
      axios.post('/api/AddAlert',data)
      .then()
      .catch()
    }
  },
   
    // End Cart Methods 
    allProduct(){
      axios.get('/api/products/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.products = data))
      .catch()
    },
     allCategory(){
      axios.get('/api/categories/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.categories = data))
      .catch()
    },

    allCustomer(){
      axios.get('/api/customers/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.customers = data))
      .catch(console.log('error'))
    },
    subproduct(id){
      axios.get('/api/getting/product/'+id)
      .then(({data}) => (this.getproducts = data))
      .catch()
    } 
    }  
  } 

</script>


<style type="text/css" scoped>
  #em_photo{
    height: 100px;
    width: 135px;
  }
</style>