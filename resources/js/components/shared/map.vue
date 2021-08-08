<template>
   <div>
     <l-map
                  :center="center"
                  :zoom="zoom"
                  class="map"
                  ref="map"
                  @update:center="centerUpdated"
                  @update:zoom="zoomUpdated"
                  >
                  <l-tile-layer
                  :url="url">
                  </l-tile-layer>
                  <v-marker-cluster>
                  <l-marker
                  v-for="marker in markers"
                  :key="marker.id" 
                  :lat-lng="marker.coords"
                  >
                  <l-icon>
                    <img :src="marker.iconUrl" alt="marker-icon">
                  </l-icon>
                  <l-popup> 
                    <ul class="list-group">
                      <li class="list-group-item"><b>{{ marker.name }}</b></li>
                      <li class="list-group-item"><b>{{ marker.email }}</b></li>
                    </ul>
                  </l-popup>
                  </l-marker>
                  </v-marker-cluster>
                  </l-map>
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
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            center: [35.6983, -0.6424],
            zoom:12,
            markers:[]
        }
    },
    created(){
      this.getUserPosition();
    },
    methods:{
       centerUpdated(center){
     this.center= center;
   },
      zoomUpdated(zoom){
        this.zoom= zoom;
      },
      getUserPosition(){
        axios.get('/api/customers/position')
        .then(res=>{
          for(let i = 0; i < res.data.latitude.length; i++){
            var iconUrl;
            if(res.data.type[i] == 'New customer'){
              iconUrl='images/vendor/leaflet/dist/marker-icon.png'
            }else if(res.data.type[i] == 'Loyal customer'){
              iconUrl='images/vendor/leaflet/dist/marker-icon-gold.png'
            }else{
              iconUrl='images/vendor/leaflet/dist/marker-icon-red.png'
            }

            this.markers.push({ id:i, name: res.data.name[i], iconUrl:iconUrl, email:res.data.email[i], coords:[parseFloat(res.data.latitude[i]), parseFloat(res.data.longitude[i])] });
        }
          })
        .catch()
      }
    }
  }


</script>


<style type="text/css">
	.map{
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
  }
</style>
