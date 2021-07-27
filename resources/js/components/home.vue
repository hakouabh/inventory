
<template>
	<div>
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $t('dashboard') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">{{ $t('home') }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $t('dashboard') }}</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
        <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $t('shared.today_sell') }}</div>
 <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ todaysell }}</div>
                      <!--<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span>
                      </div>-->
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $t('shared.income') }}</div>
        <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ income }} </div>
                     <!-- <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span>
                      </div>-->
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
   <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $t('shared.today_due') }}</div>
      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">$ 0 </div>
                    <!--  <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Since last month</span>
                      </div>-->
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
  <div class="text-xs font-weight-bold text-uppercase mb-1">{{ $t('shared.today_expense') }}</div>
    <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ expense }} </div>
                      <!--<div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span>
                      </div>-->
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row mb-3">
            <!-- Area Chart -->
            <div class="col-xl-9 col-lg-8">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{ $t('shared.repport') }}</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(17px, 19px, 0px);">
                      <div class="dropdown-header"></div>
                      <a class="dropdown-item">{{ $t('shared.current') }}</a>
                      <a class="dropdown-item">{{ $t('shared.last') }}</a>
                      <div class="dropdown-divider"></div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart-area"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="myAreaChart" 
                    style="display: block; width: 1051px; height: 320px;" 
                    width="1051" height="320" class="chartjs-render-monitor"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-3 col-lg-4">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">{{ $t('shared.product') }}</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Month <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Select Periode</div>
                      <a class="dropdown-item" href="#">Today</a>
                      <a class="dropdown-item" href="#">Week</a>
                      <a class="dropdown-item active" href="#">Month</a>
                      <a class="dropdown-item" href="#">This Year</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <div class="small text-gray-500">Oblong T-Shirt
                      <div class="small float-right"><b>600 of 800 Items</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="small text-gray-500">Gundam 90'Editions
                      <div class="small float-right"><b>500 of 800 Items</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="small text-gray-500">Rounded Hat
                      <div class="small float-right"><b>455 of 800 Items</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="small text-gray-500">Indomie Goreng
                      <div class="small float-right"><b>400 of 800 Items</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="small text-gray-500">Remote Control Car Racing
                      <div class="small float-right"><b>200 of 800 Items</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-center">
                  <a class="m-0 small text-primary card-link" href="#">View More <i class="fas fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
          
          </div>
<div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
       <h6 class="m-0 font-weight-bold text-primary">{{ $t('shared.out_stock') }}</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>{{ $t('table.feild.name') }}</th>
                        <th>{{ $t('table.feild.sku') }}</th>
                        <th>{{ $t('table.feild.photo') }}</th>                       
                        <th>{{ $t('table.feild.buying_price') }}</th>
                        <th>{{ $t('table.feild.status') }}</th>
                        <th>{{ $t('table.feild.quantity') }}</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in products" :key="product.id">
                        <td> {{ product.product_name }} </td>
                        <td> {{ product.product_code }} </td>
                        <td><img :src="product.image" id="em_photo"></td>
                        
                        <td>{{ product.buying_price }}</td>
  <td v-if="product.product_quantity  >= 1 "><span class="badge badge-success"> {{ $t('available') }} </span></td>
   <td v-else=" "><span class="badge badge-danger"> {{ $t('stock_out') }} </span></td>
                         <td>{{ product.product_quantity }}</td>
             
                      </tr>
                    
                    </tbody>
                  </table>
                </div>
                
              </div>
            </div>
          </div>
	</div>

</template>



<script type="text/javascript">
      function number_format(number, decimals, dec_point, thousands_sep) {
      // *     example: number_format(1234.56, 2, ',', ' ');
      // *     return: '1 234,56'
      number = (number + '').replace(',', '').replace(' ', '');
      var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
      // Fix for IE parseFloat(0.55).toFixed(0) = 0;
      s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }
      return s.join(dec);
    }
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },

 data(){
  return{
    todaysell:'',
    income:'',
    expense:'',
    products:'',
    stats:{}
  }

 },
 mounted(){
 this.TodaySell();
 this.TodayIncome();
 this.TodayExpense();
 this.StockOut();
 this.GetStats();
 },
  methods:{
    TodaySell(){
      axios.get('/api/today/sell')
        .then(({data}) => (this.todaysell = data))
        .catch()
     },
     TodayIncome(){
      axios.get('/api/today/income')
        .then(({data}) => (this.income = data))
        .catch()
     },
     TodayExpense(){
      axios.get('/api/today/expense')
        .then(({data}) => (this.expense = data))
        .catch()
     },

     StockOut(){
      axios.get('/api/today/stockout')
        .then(({data}) => (this.products = data))
        .catch()
     },
     GetStats(){
    axios.get('/api/order/satat')
    .then(({data}) => {
      this.stats = data
      this.CreateChart();
      })
    .catch(console.log('error'))
     },
     CreateChart(){        
      var currentWeekOrdersformat = this.stats.currentWeekOrders.toString().split(',');
      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
          datasets: [{
            label: "Earnings",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.5)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [currentWeekOrdersformat[0], currentWeekOrdersformat[1], currentWeekOrdersformat[2]
            , currentWeekOrdersformat[3], currentWeekOrdersformat[4], 
            currentWeekOrdersformat[5], currentWeekOrdersformat[6]],
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return 'DA ' + number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': DA' + number_format(tooltipItem.yLabel);
              }
            }
          }
        }
      });
     }
   },
   
  } 
</script>


<style type="text/css">
	
</style>