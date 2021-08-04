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
                  <l-marker
                  v-for="marker in markers"
                  :key="marker.id" 
                  :lat-lng="marker.coords">
                  <l-icon>
                    <i class="fas fa-map-marker-alt fa-3x text-info"></i>
                  </l-icon>
                  <l-popup> {{marker.mail}} </l-popup>
                  </l-marker>

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
            url:'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
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
        axios.get('api/auth/users/position')
        .then(res=>{
          for(let i = 0; i < res.data.latitude.length; i++){
            this.markers.push({id:i, mail:res.data.email[i], coords:[parseFloat(res.data.latitude[i]), parseFloat(res.data.longitude[i])]});
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