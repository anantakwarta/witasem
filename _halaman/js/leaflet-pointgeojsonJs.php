<!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin=""></script>

 <script src="assets/js/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
 <script src="assets/js/leaflet.ajax.js"></script>

   <script type="text/javascript">
	<?php
	$db->join('m_kecamatan b','a.id_kecamatan=b.id_kecamatan','LEFT');
	$getdata=$db->ObjectBuilder()->get('t_wisata a');
	$jsonPoint=array();
	foreach ($getdata as $row) {
		$saveJson=null;
		$saveJson['type']="Feature";
		$saveJson['properties']=[
									"nama_wisata"=>$row->nama_wisata,
									"lokasi"=>$row->lokasi.' Kec. '.$row->nm_kecamatan,
									"deskripsi"=>$row->deskripsi,
									"icon"=>assets('icons/marker.png'),
									"popUp"=>($row->img==''?'-':'<img src="'.assets('unggah/img/'.$row->img).'" width="100%">')."<h3>".$row->nama_wisata."</h3><br>".$row->deskripsi
									];
		$saveJson['geometry']=[
									"type" => "Point",
									"coordinates" => [$row->lng,$row->lat ] 
									];	

		$jsonPoint[]=$saveJson;
	}

	?>

	var geojsonPoint = <?=json_encode($jsonPoint, JSON_PRETTY_PRINT)?>;

   	var map = L.map('mapid').setView([-7.0218459442324646, 110.39749145507812], 12);

   	var LayerKita=L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
});
	map.addLayer(LayerKita);

	var myStyle2 = {
	    "color": "#ffff00",
	    "weight": 1,
	    "opacity": 0.9
	};

	function popUp(f,l){
	    var out = [];
	    if (f.properties){
	        for(key in f.properties){
	        console.log(key);

	        }
			out.push("Kecamatan "+f.properties['name']);
			out.push("Kota "+f.properties['is_in:city']);
	        l.bindPopup(out.join(",<br />"));
	    }
	}

	// legend

	function iconByName(name) {
		return '<i class="icon" style="background-color:'+name+';border-radius:50%"></i>';
	}

	function featureToMarker(feature, latlng) {
		return L.marker(latlng, {
			icon: L.divIcon({
				className: 'marker-'+feature.properties.amenity,
				html: iconByName(feature.properties.amenity),
				iconUrl: '../images/markers/'+feature.properties.amenity+'.png',
				iconSize: [25, 41],
				iconAnchor: [12, 41],
				popupAnchor: [1, -34],
				shadowSize: [41, 41]
			})
		});
	}

	var baseLayers = [
		{
			name: "OpenStreetMap",
			layer: LayerKita
		},
		{	
			name: "OpenCycleMap",
			layer: L.tileLayer('http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png')
		},
		{
			name: "Outdoors",
			layer: L.tileLayer('http://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png')
		}
	];

	<?php
		$getKecamatan=$db->ObjectBuilder()->get('m_kecamatan');
		foreach ($getKecamatan as $row) {
			?>

			var myStyle<?=$row->id_kecamatan?> = {
			    "color": "<?=$row->warna_kecamatan?>",
			    "weight": 1,
			    "opacity": 1
			};

			<?php
			$arrayKec[]='{
			name: "'.$row->nm_kecamatan.'",
			icon: iconByName("'.$row->warna_kecamatan.'"),
			layer: new L.GeoJSON.AJAX(["assets/unggah/geojson/'.$row->geojson_kecamatan.'"],{onEachFeature:popUp,style: myStyle'.$row->id_kecamatan.',pointToLayer: featureToMarker }).addTo(map)
			}';
		}
	?>

	var overLayers = [{
		group: "Layer Kecamatan",
		layers: [
			<?=implode(',', $arrayKec);?>
		]
	}
	];

	var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers,{
		collapsibleGroups: true
	});

	map.addControl(panelLayers);

	// marker
	var myIcon = L.Icon.extend({
	    options: {
	    	iconSize: [30, 36]
	    }
	});
	


	L.geoJSON(geojsonPoint, {
	    pointToLayer: function (feature, latlng) {
	    	console.log(feature)
	        return L.marker(latlng, {
	        	icon : new myIcon({iconUrl: feature.properties.icon})
	        });
	    },
    	onEachFeature: function(feature,layer){
    		 if (feature.properties && feature.properties.nama_wisata) {
		        layer.bindPopup(feature.properties.popUp);
		    }
    	}
	}).addTo(map);


   </script>