<template>
   <div id="container">
     <div id="mapContainer">
     </div>
   </div>
</template>
<script type="text/javascript">
import axios from 'axios';
import L from "leaflet";
import "leaflet-draw";
import "leaflet-draw/dist/leaflet.draw-src.css";
import "leaflet.featuregroup.subgroup";
import "leaflet/dist/leaflet.css";

import { statesData } from './streets/states'
var pointInPolygon = require('point-in-polygon');

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
            group:[],
            sector:[],
            geojson:'',
            info:'',
            deleteButton:'',
            mapDiv:'',
            selectedFeature:null
        }
    },
    mounted(){
      this.setupMap();
    },
    created(){
      this.getSector();
      Reload.$on('AfterAdd',() =>{
      this.cartProduct();
    })
    },
    methods:{
    getSector(){
      axios.get('/api/sector/index/'+localStorage.getItem('user_id'))
        .then(({data}) => {
          this.sector = data
          })
        .catch()
    }, 
    getColor(density) {
    return density > 25 ? '#800026' :
           density > 20  ? '#BD0026' :
           density > 17  ? '#E31A1C' :
           density > 15  ? '#FC4E2A' :
           density > 10   ? '#FD8D3C' :
           density > 5   ? '#FEB24C' :
           density > 1   ? '#FED976' :
                      '#FFEDA0';
      },
    highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
        weight: 5,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layer.bringToFront();
    }
    this.info.update(layer.feature.properties);
},
 resetHighlight(e) {
    this.geojson.resetStyle(e.target);
    this.info.update();
},
 zoomToFeature(e) {
    this.mapDiv.fitBounds(e.target.getBounds());
    if(this.selectedFeature){
      this.selectedFeature.editing.disable();
      //store to db
      this.updatesector(this.selectedFeature)
      }else{
      this.deleteButton.remove(this.mapDiv) 
      }
    this.selectedFeature = e.target;
    e.target.editing.enable();
    this.deleteButton.addTo(this.mapDiv)
},
updatesector(layer){
    const json = layer.toGeoJSON();
    json.properties.density = this.countdensity(layer);
    if (layer instanceof L.Circle) {
      json.properties.radius = layer.getRadius();
      }
    var shape_for_db = JSON.stringify(json);
    axios.post('/api/sector/edit/',{
    user_id:localStorage.getItem('user_id'),
    leaflet_id:layer.feature.properties.leaflet_id,
    data:shape_for_db
    })
    .then()
    .catch()
},
insertSector(layer,type){
    const json = layer.toGeoJSON();
    json.properties.density = this.countdensity(layer);
    json.properties.leaflet_id = layer._leaflet_id;
    if (layer instanceof L.Circle) {
      json.properties.radius = layer.getRadius();
    }
    var shape_for_db = JSON.stringify(json);
    axios.post('/api/sector/store/',{
    user_id:localStorage.getItem('user_id'),
    type:type,
    leaflet_id:layer._leaflet_id,
    data:shape_for_db
      })
      .then(() => {
        //Reload.$emit('AfterAdd');
      })
      .catch() 
},
deletesector(leaflet_id){
axios.post('/api/sector/delete/',{
    user_id:localStorage.getItem('user_id'),
    leaflet_id:leaflet_id
    })
    .then(()=>{
    // Reload.$emit('AfterAdd');
    })
    .catch()
},
countdensity(layer){
  var density=0;
  const json = layer.toGeoJSON();
   if (layer instanceof L.Circle) {
  var theCenterPt = layer.getLatLng();
  var theRadius = layer.getRadius();
   }
  this.positions.map(position =>{
 if (layer instanceof L.Circle) {
    //calcule in circle 
    let point = L.point(parseFloat(position.latitude),parseFloat(position.longitude)); // x=0,y=0
    let latlng = this.mapDiv.layerPointToLatLng(point);
    if (latlng.distanceTo(theCenterPt) <= theRadius) {
      density++;
    }
    }else{
      //calcule 
      if (pointInPolygon([ parseFloat(position.longitude) ,parseFloat(position.latitude)], 
          json.geometry.coordinates[0]))
          density ++;
    }
  })
return density
},
 onEachFeature(feature, layer) {
    layer.on({
        mouseover: this.highlightFeature,
        mouseout: this.resetHighlight,
        click: this.zoomToFeature
    });
},
  style(feature) {
        return {
            fillColor: this.getColor(feature.properties.density),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
  },
    setupMap(){
        axios.get('/api/customers/position')
        .then(({data}) => {
          this.positions = data.data.position;
          this.users = data.data.users;
          let _global = this; 
      var tileProvider = L.tileLayer(
       "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWJkZWxoYWstbWVnaGVyYmkiLCJhIjoiY2tydzQ2ZjV0MGN1MzJxczczdnpkNjQ0YyJ9.PsRF0t-e6kjbL37sryRMlg",
       {
         attribution:
           'Map data (c) <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery (c) <a href="https://www.mapbox.com/">Mapbox</a>',
         id: "mapbox/streets-v11",
         accessToken:"pk.eyJ1IjoiYWJkZWxoYWstbWVnaGVyYmkiLCJhIjoiY2tydzQ2ZjV0MGN1MzJxczczdnpkNjQ0YyJ9.PsRF0t-e6kjbL37sryRMlg",
       }
     );
      this.mapDiv =L.map("mapContainer",{
        center: this.center,
        zoom: this.zoom,
        layers: tileProvider
      });
      var mcgLayerSupportGroup = L.markerClusterGroup(),
          control = L.control.layers(null, null, { position: "topright" });
          mcgLayerSupportGroup.addTo(this.mapDiv);
      for(let i = 0; i < this.users.length; i++){
          this.group[i] = L.featureGroup.subGroup(mcgLayerSupportGroup)
          this.userMarkers[i] = this.positions.filter(marker => {
            return marker.user_email.match(this.users[i].email)
               })
               //create markers 
                this.markers[i] = this.userMarkers[i].map(position => 

                {
                  return(
                  L.marker([parseFloat(position.latitude), 
                    parseFloat(position.longitude)],
                     //set Icon
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
          )
          });
          control.addOverlay(this.group[i], this.users[i].email);
          this.group[i].addTo(this.mapDiv)
        }   
        control.addTo(this.mapDiv);
        for(let i = 0; i < this.sector.length; i++){
          statesData.features.push(JSON.parse(this.sector[i].data))
        }
        this.geojson = L.geoJson(statesData.features,{
          pointToLayer: (feature, latlng) => {
                if (feature.properties.radius) {
                  return new L.Circle(latlng, feature.properties.radius);
                } else {
                  //insert new marker
                  return new L.Marker(latlng,{icon:
                  L.icon({
                                    iconUrl: 'images/vendor/leaflet/dist/marker-icon.png',
                      })
                  });
                }
              },
          style: this.style,
          onEachFeature: this.onEachFeature}).addTo(this.mapDiv)
          //info part
      this.deleteButton = L.control();
      this.info = L.control();
          
      this.info.onAdd = function () {
          this._div = L.DomUtil.create('div', 'info');
           this.update();
          return this._div;
      };

      this.deleteButton.onAdd = function(){
        this._container = L.DomUtil.create('div','info');
        this._container.innerHTML = "<a class='far fa-trash-alt'></a>";
          this._container.onclick = function(){
            _global.deletesector(_global.selectedFeature.feature.properties.leaflet_id)

        };
        return this._container;
      };

// method that we will use to update the control based on feature properties passed
      this.info.update = function (props) {
          this._div.innerHTML = '<h5>Client Density</h5>' +  (props ?
              '<b>'+ props.density + 'client'
              : 'Hover !!');
      };
      this.info.addTo(this.mapDiv);
        //Start of L Draw
          // Initialise the FeatureGroup to store editable layers
          var drawnItems = new L.FeatureGroup();
          this.mapDiv.addLayer(drawnItems);

        // Initialise the draw control and pass it the FeatureGroup of editable layers
        var drawControl = new L.Control.Draw({
          edit: {
            featureGroup: drawnItems
          }
        });

        this.mapDiv.addControl(drawControl);

        this.mapDiv.on(L.Draw.Event.CREATED, function (e) {
          var type = e.layerType
          var sector = e.layer;
          drawnItems.addLayer(sector);
          //store To db
            _global.insertSector(sector,type) 
        });
        this.mapDiv.on(L.Draw.Event.EDITED, function (e) {
          // Edit  DB .
          var editeddsector = e.layers;
          editeddsector.eachLayer(function (layer) {
              _global.updatesector(layer)
            }); 
        });
        this.mapDiv.on(L.Draw.Event.DELETED, function (e) {
          // Delete from DB .
          var deletedsector = e.layers;
          deletedsector.eachLayer(function (layer) {
            _global.deletesector(layer._leaflet_id)
            });          
        });
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
.info {
    padding: 6px 8px;
    font: 14px/16px Arial, Helvetica, sans-serif;
    background: white;
    background: rgba(255,255,255,0.8);
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    border-radius: 5px;
}
.info h4 {
    margin: 0 0 5px;
    color: #777;
}
</style>
