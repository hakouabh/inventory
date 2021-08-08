<template>
  <div>
      <div class="col-xl-12 col-lg-12">
              <div class="card mb-4">
                  <div class="card-header align-items-center justify-content-between">

                    <div class="form-row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" autofocus id="exampleFormsku" @keyup.enter="searchProduct($event.target.value)" :placeholder=" $t('form.placeholder.sku') ">
                            </div>
                            <!--<div class="col-md-4">
                                <select type="text" @change="switchSelect($event)" class="form-control" id="exampleFormsku" :placeholder=" $t('form.placeholder.product') ">
                                  <option :value="product.id" v-for="product in products">{{product.product_name}} </option>
                                </select>-->
                                <div class="col-md-4">
                                  <div class="input-group mb-3">
                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      {{ $t('table.feild.category') }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                      <a class="dropdown-item" @click=" allProduct() ">{{ $t('router.all_product') }}</a>                                     
                                      <hr class="dropdown-divider">
                                      <a class="dropdown-item" v-for="category in categories" :key="category.id" @click="subproduct(category.id)">{{ category.category_name }}</a>
                                    </div>
                                    <select type="text" @change="switchSelect($event)" class="form-control" id="exampleFormsku" :placeholder=" $t('form.placeholder.product') ">
                                    <option></option>
                                    <option :value="product.id" v-for="product in products">{{product.product_name}} </option>
                                   </select>                                  
                                </div>
                              </div>
                            <div class="col-md-4">
                                <router-link class="btn btn-sm btn-info" to="/store-customer"><font color="#ffffff">{{ $t('router.add_customer') }}</font></router-link>
                            </div>
                    </div>           
                  </div>
                <div class="table-responsive" style="font-size: 16px;">
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
                            <td><input type="number" @change="checkquantity($event,cart.id)" style="width: 35px;" :value="cart.pro_quantity">
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
    this.allCustomer();
    //this.allProduct();
    this.cartProduct();
    this.allCategory();
    Reload.$on('AfterAdd',() =>{
      this.cartProduct();
    })
   }, 
 data(){
      return{
        customer_id:'',
        pay:'',
        payby:'',
        searchTerm:'',
        getsearchTerm:'',
        customers:'',
        products:[],
        categories:'',
        errors:'',
        carts:[],
        

      }
    },
    computed:{
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
  checkquantity(e,id){
    axios.post('/api/checkquantity/',{quantity:e.target.value, id:id})
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
     allCategory(){
      axios.get('/api/categories/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.categories = data))
      .catch()
    },
    subproduct(id){
      axios.get('/api/getting/product/'+id)
      .then(({data}) => (this.products = data))
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
    allCustomer(){
      axios.get('/api/customers/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.customers = data))
      .catch(console.log('error'))
    },
    allProduct(){
      axios.get('/api/products/index/'+localStorage.getItem('user_id'))
      .then(({data}) => (this.products = data))
      .catch()
    },
    switchSelect(e){
      this.AddToCart(e.target.value)
    },
    searchProduct(sku){
        let data ={
        product_code:sku,
        user_id:localStorage.getItem('user_id')
        }
        axios.post('/api/search/product/',data)
            .then(({data}) => {
              if(data.length){
                  this.AddToCart(data[0].id);
                }else{
                  Notification.notFound()
                }
            })
            .catch()
    }, 
    }  
  } 

</script>


<style type="text/css" scoped>
  #em_photo{
    height: 100px;
    width: 135px;
  }
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
</style>