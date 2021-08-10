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
                  <l-control-layers
                  position="topright"
                  ></l-control-layers>
                  <l-tile-layer
                  :url="url"
                  name="Mymap"
                  layer-type="base">
                  </l-tile-layer>
                  <l-layer-group 
                  v-for="provider in tileProviders"
                  :key="provider.name"
                  :visible="provider.visible"
                  layerType="overlay"
                  :name="provider.name">
                  <v-marker-cluster>
                  <l-marker
                  v-for="marker in provider.markers"
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
                  </l-layer-group>
                  </l-map>
   </div>
</template>
<script type="text/javascript">
import axios from 'axios';
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
            positions:[],
            users:'',
            userMarkers:[],
            markers:[],
            myip:'',
            tileProviders:[]
            
        }
    },
    created(){
      this.getUserPosition();
      //this.getIpInfo();
    },
    methods:{
     async getIpInfo (){
       // get current ip address
      fetch('https://api.ipify.org?format=json')
      .then(x => x.json())
      .then(({ ip }) => {
          this.myip = ip
          // get locatiob
          axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
         axios.get(
          `https://cors-anywhere.herokuapp.com/https://geo.ipify.org/api/v1?apiKey=at_yahGHonr8XT6LMlgMcLoUHZbzRTdn&ipAddress=${this.myip}`
        ,{
        headers: {
          // remove headers
        }
      }).then(res => {
        console.log(this.positions.location);
      }).catch(err => {
        console.log(err.response);
      });
      });
    },
    centerUpdated(center){
     this.center= center;
   },
      zoomUpdated(zoom){
        this.zoom= zoom;
      },
      getUserPosition(){
        axios.get('/api/customers/position')
        .then(({data}) => {
          this.positions = data.data.position;
          this.users = data.data.users;
          for(let i = 0; i < this.positions.name.length; i++){
              var iconUrl;
                if(this.positions.type[i] == 'New customer'){
                  iconUrl='images/vendor/leaflet/dist/marker-icon.png'
                }else if(this.positions.type[i] == 'Loyal customer'){
                  iconUrl='images/vendor/leaflet/dist/marker-icon-gold.png'
                }else{
                  iconUrl='images/vendor/leaflet/dist/marker-icon-red.png'
                }
                this.markers.push({
                  id:i,
                  user: this.positions.user_email[i],
                  name: this.positions.name[i], 
                  iconUrl:iconUrl, 
                  email:this.positions.email[i], 
                  coords:[parseFloat(this.positions.latitude[i]), 
                  parseFloat(this.positions.longitude[i])]
                })            
          }
        for(let i = 0; i < this.users.length; i++){
          this.userMarkers[i] = this.markers.filter(product => {
            return product.user.match(this.users[i].email)
               })
            
          }
          for(let i = 0; i < this.userMarkers.length; i++){
              this.tileProviders.push({
                markers:this.userMarkers[i],
                name:this.users[i].email,
                visible:true
              })            
          }
        })
        .catch()
      },
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
