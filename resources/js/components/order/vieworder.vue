  

<template>
  
  <div>

 <div class="row">
  <router-link to="/order" class="btn btn-primary">{{$t('router.back')}}</router-link>
   
 </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">{{$t('table.name.orders_details')}}</h1>
                  </div>

       

<div class="row">
            <div class="col-lg-6 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{$t('table.name.orders_details')}}</h6>
                </div>
                <div class="table-responsive">
                   
        <ul class="list-group">
          <li class="list-group-item"><b>{{$t('table.feild.name')}} :</b> {{ orders.name }} </li>
          <li class="list-group-item"><b>{{$t('table.feild.phone')}} :</b> {{ orders.phone }}</li>
          <li class="list-group-item"><b>{{$t('table.feild.address')}} :</b> {{ orders.address }}</li>
          <li class="list-group-item"><b>{{$t('table.feild.date')}} :</b> {{ orders.order_date }}</li>
          <li class="list-group-item"><b>{{$t('table.feild.through')}} :</b> {{ orders.payby }}</li>
        </ul>

                  
                </div>
                <div class="card-footer"></div>
              </div>
            </div>




<div class="col-lg-6 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{$t('table.name.orders_details')}}</h6>
                </div>
                <div class="table-responsive">


          <ul class="list-group">
          <li class="list-group-item"><b>{{$t('table.feild.sub_total')}} :</b> {{ orders.sub_total }} $ </li>
          <li class="list-group-item"><b>{{$t('table.feild.total')}} :</b> {{ orders.total }} $</li>
          <li class="list-group-item"><b>{{$t('table.feild.pay_amount')}} :</b> {{ orders.pay }} $</li>
        </ul>



                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
<div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{$t('table.name.orders_details')}}</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{$t('table.feild.product')}}</th>
                        <th>{{$t('table.feild.sku')}}</th>
                        <th>{{$t('table.feild.image')}}</th>
                        <th>{{$t('table.feild.quantity')}}</th>
                        <th>{{$t('table.feild.price')}}</th>
                        <th>{{$t('table.feild.total')}} </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="detail in details">
                        <td>{{ detail.product_name }}</td>
                        <td>{{ detail.product_code }}</td>
                        <td><img :src="'/'+detail.image" id="em_photo"></td>
                        <td>{{ detail.pro_quantity }}</td>
                       <td>{{ detail.product_price }} $</td>
                       <td>{{ detail.sub_total }} $</td>
                      </tr>
                       
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
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
       
      errors:{},
      orders:{},
      details:{}
    }
  },
  created(){
  	let id = this.$route.params.id
  	axios.get('/api/order/details/'+id)
  	.then(({data}) => (this.orders = data))
  	.catch(console.log('error'))

    axios.get('/api/order/orderdetails/'+id)
    .then(({data}) => (this.details = data))
    .catch(console.log('error'))  
 

  },

  methods:{
    
   
  } 


  }
   
</script>


<style type="text/css">
   #em_photo{
    height: 40px;
    width: 40px;
  }
</style>