<template>
   <div>
     <l-map
                  :center="center"
                  :zoom="zoom"
                  class="map"
                  ref="map"
                  >
                  <l-control-layers
                  position="topright"
                  ></l-control-layers>
                  <l-tile-layer
                  :url="url"
                  name="Mymap"
                  layer-type="base">
                  </l-tile-layer>
                  <!--<l-layer-group 
                  v-for="provider in tileProviders"
                  :key="provider.name"
                  :visible="provider.visible"
                  layerType="overlay"
                  :name="provider.name">
                  <v-marker-cluster>
                  <l-marker
                  v-for="marker in provider.markers"
                  :key="marker.name" 
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
                  </l-layer-group>-->
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
      getUserPosition(){
        axios.get('/api/customers/position')
        .then(({data}) => {
          
          this.positions = data.data.position;
          this.users = data.data.users;
          this.markers = this.positions.map(position => 
          (
            {
              user: position.user_email,
              name: position.name,
              iconUrl:position.type == 'New customer' ? 'images/vendor/leaflet/dist/marker-icon.png': position.type == 'Loyal customer'?'images/vendor/leaflet/dist/marker-icon-gold.png':'images/vendor/leaflet/dist/marker-icon-red.png',
              email:position.email,
              coords:[parseFloat(position.latitude), 
                            parseFloat(position.longitude)]
          }
          ));
        for(let i = 0; i < this.users.length; i++){
          this.userMarkers[i] = this.markers.filter(marker => {
            return marker.user.match(this.users[i].email)
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
