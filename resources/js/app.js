

require('./bootstrap');


import Vue from 'vue'
import VueRouter from 'vue-router'
import i18n from './src/i18n'

Vue.use(VueRouter)

 // Router Imported
 import {routes} from './routes';

 //MAP leaflet

 import { LMap, LTileLayer, LMarker,LPopup, LIcon } from 'vue2-leaflet';
 import Vue2LeafletMarkerCluster from 'vue2-leaflet-markercluster'
 import 'leaflet/dist/leaflet.css';
 import 'leaflet.markercluster/dist/MarkerCluster.css';
 import 'leaflet.markercluster/dist/MarkerCluster.Default.css';

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('l-popup', LPopup);
Vue.component('l-icon', LIcon);
Vue.component('v-marker-cluster', Vue2LeafletMarkerCluster)

 // Import User Class
 import User from './Helpers/User';
 window.User = User

 // Import Notification Class
 import Notification from './Helpers/Notification';
 window.Notification = Notification



 // Sweet Alert start 
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});
window.Toast = Toast;
 
// Sweet Alert End 

window.Reload = new Vue();


const router = new VueRouter({
  routes,
  mode: 'history' 
})
import topbar from './components/shared/topBar.vue'
import mapVue from './components/shared/map.vue'

const app = new Vue({
    el: '#app',
    router,
    i18n,
    components:{
      'topbar' : topbar,
      'mapVue': mapVue
    }
});
