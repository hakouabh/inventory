<template>
   <div id="container">
     <div id="mapContainer">

     </div>
    <!-- Map 2
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
                  <l-layer-group 
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
                  </l-layer-group>
                  </l-map>-->
   </div>
</template>
<script type="text/javascript">
import axios from 'axios';
import L from "leaflet";
import "leaflet.featuregroup.subgroup";
import "leaflet/dist/leaflet.css";

  export default {
    name: "Map",
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
            group:[]
        }
    },
    mounted(){
      this.setupMap();
    },
    methods:{
      setupMap(){
        axios.get('/api/customers/position')
        .then(({data}) => {
          this.positions = data.data.position;
          this.users = data.data.users; 
      var tileProvider = L.tileLayer(
       "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWJkZWxoYWstbWVnaGVyYmkiLCJhIjoiY2tydzQ2ZjV0MGN1MzJxczczdnpkNjQ0YyJ9.PsRF0t-e6kjbL37sryRMlg",
       {
         attribution:
           'Map data (c) <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery (c) <a href="https://www.mapbox.com/">Mapbox</a>',
         id: "mapbox/streets-v11",
         accessToken:"pk.eyJ1IjoiYWJkZWxoYWstbWVnaGVyYmkiLCJhIjoiY2tydzQ2ZjV0MGN1MzJxczczdnpkNjQ0YyJ9.PsRF0t-e6kjbL37sryRMlg",
       }
     );

      var mapDiv =L.map("mapContainer",{
        center: this.center,
        zoom: this.zoom,
        layers: tileProvider
      });
      var mcgLayerSupportGroup = L.markerClusterGroup(),
          control = L.control.layers(null, null, { position: "topright" });
          mcgLayerSupportGroup.addTo(mapDiv);
      for(let i = 0; i < this.users.length; i++){
          this.group[i] = L.featureGroup.subGroup(mcgLayerSupportGroup)
          this.userMarkers[i] = this.positions.filter(marker => {
            return marker.user_email.match(this.users[i].email)
               })
               //create markers 
                this.markers[i] = this.userMarkers[i].map(position => 

                (
                  L.marker([parseFloat(position.latitude), 
                    parseFloat(position.longitude)],
                      {icon:
                            position.type == 'New customer' ?  L.icon({
                                iconUrl: 'images/vendor/leaflet/dist/marker-icon.png',
                      }):
                            position.type == 'Loyal customer'?
                                L.icon({
                                    iconUrl: 'images/vendor/leaflet/dist/marker-icon-gold.png',
                      }):
                                L.icon({
                                    iconUrl: 'images/vendor/leaflet/dist/marker-icon-red.png',
                      })
                      })
          .bindPopup(position.email)
          .addTo(this.group[i])
          ));
          control.addOverlay(this.group[i], this.users[i].email);
          this.group[i].addTo(mapDiv)
        }         
          control.addTo(mapDiv);

        })
        .catch()
      },
      //get user Position

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
      // getUserPosition(){
      //   axios.get('/api/customers/position')
      //   .then(({data}) => {
          
      //     this.positions = data.data.position;
      //     this.users = data.data.users;
      //     this.markers = this.positions.map(position => 
      //     (
      //       {
      //         user: position.user_email,
      //         name: position.name,
      //         iconUrl:position.type == 'New customer' ? 'images/vendor/leaflet/dist/marker-icon.png': position.type == 'Loyal customer'?'images/vendor/leaflet/dist/marker-icon-gold.png':'images/vendor/leaflet/dist/marker-icon-red.png',
      //         email:position.email,
      //         coords:[parseFloat(position.latitude), 
      //                       parseFloat(position.longitude)]
      //     }
      //     ));
      //   for(let i = 0; i < this.users.length; i++){
      //     this.userMarkers[i] = this.markers.filter(marker => {
      //       return marker.user.match(this.users[i].email)
      //          })
            
      //     }
      //     for(let i = 0; i < this.userMarkers.length; i++){
      //         this.tileProviders.push({
      //           markers:this.userMarkers[i],
      //           name:this.users[i].email,
      //           visible:true
      //         })            
      //     }
      //   })
      //   .catch()
      // },
    }
  }
</script>
<style type="text/css">
	  #mapContainer{
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
  }

</style>
