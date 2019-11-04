<<<<<<< HEAD
document.addEventListener('DOMContentLoaded', function () {

	var leafletmapsMod = document.querySelectorAll('.leafletmapMod');

	[].forEach.call(leafletmapsMod, function (element) {

		// Create map with worldWarp
		var uriroot = element.getAttribute('data-uriroot');
		var scrollwheelzoom = element.getAttribute('data-scrollwheelzoom');
		var noWorldWarp = element.getAttribute('data-no-world-warp');
		var moduleId = element.getAttribute('data-module-id');
		var detectRetina = element.getAttribute('data-detect-retina');
		var baselayer = element.getAttribute('data-baselayer');
		var lonlat = element.getAttribute('data-lonlat').split(",", 3);
		var zoom = element.getAttribute('data-zoom');
		var mapboxkey = element.getAttribute('data-mapboxkey');
		var thunderforestkey = element.getAttribute('data-thunderforestkey');
		var stamenmaptype = element.getAttribute('data-stamenmaptype');
		var thunderforestmaptype = element.getAttribute('data-thunderforestmaptype');
		var googlemapstype = element.getAttribute('data-googlemapstype');
		var mapboxmaptype = element.getAttribute('data-mapboxmaptype');
		var attrModule = element.getAttribute('data-attr-module');
		var customBaselayer = element.getAttribute('data-customBaselayer');
		var customBaselayerURL = element.getAttribute('data-customBaselayerURL');
		var scale = element.getAttribute('data-scale');
		var scaleMetric = element.getAttribute('data-scale-metric');
		var scaleImperial = element.getAttribute('data-scale-imperial');
		var showgeocoder = element.getAttribute('data-showgeocoder');
		var useesri = element.getAttribute('data-useesri');
		var esrireversegeocoding = element.getAttribute('data-esrireversegeocoding');
		var geocodercollapsed = (element.getAttribute('data-geocodercollapsed') === "true");
		var geocoderposition = element.getAttribute('data-geocoderposition');
		var expand = element.getAttribute('data-expand');
		var dataEsrigeocoderopengetaddress = (element.getAttribute('data-esrigeocoderopengetaddress') === "true");
		var showgeocoderesri = element.getAttribute('data-showgeocoderesri');
		var positionesrigeocoder = element.getAttribute('data-positionesrigeocoder');
		var esrigeocoderzoomToResult = (element.getAttribute('data-esrigeocoderzoomToResult') === "true");
		var esrigeocoderuseMapBounds = (element.getAttribute('data-esrigeocoderuseMapBounds') === "true");
		var esrigeocodercollapseAfterResult = (element.getAttribute('data-esrigeocodercollapseAfterResult') === "true");
		var esrigeocoderexpanded = (element.getAttribute('data-esrigeocoderexpanded') === "true");
		var esriallowMultipleResults = (element.getAttribute('data-esriallowMultipleResults') === "true");
		var showrouting_simple = element.getAttribute('data-showrouting-simple');

		if (showrouting_simple === '1')
		{
			var routesimpleposition = element.getAttribute('data-route-simple-position');
			var routesimpletarget = element.getAttribute('data-route-simple-target');
			var routesimplerouter = element.getAttribute('data-route-simple-router');
			var routesimplerouterkey = element.getAttribute('data-route-simple-routerkey');
		}
		var showrouting = element.getAttribute('data-showrouting');
		if (showrouting === '1')
		{
			var routingstart = element.getAttribute('data-routingstart').split(",", 3);
			var routingend = element.getAttribute('data-routingend').split(",", 3);
			var mapboxkeyRouting = element.getAttribute('data-mapboxkey-routing');
			var routingprofile = element.getAttribute('data-routingprofile');
			var routinglanguage = element.getAttribute('data-routinglanguage');
			var routingmetric = element.getAttribute('data-routingmetric');
			var routewhiledragging = element.getAttribute('data-routewhiledragging');
		}
		var showpin = element.getAttribute('data-showpin');
		if (showpin === '1')
		{
			var specialpins = JSON.parse(element.getAttribute('data-specialpins'));
		}
		var showcomponentpin = element.getAttribute('data-showcomponentpin');
		if (showcomponentpin === '1')
		{
			var specialcomponentpins = JSON.parse(element.getAttribute('data-specialcomponentpins'));
		}
		var showcustomfieldpin = element.getAttribute('data-showcustomfieldpin');
		if (showcustomfieldpin === '1')
		{
			var specialcustomfieldpins = JSON.parse(element.getAttribute('data-specialcustomfieldpins'));
		}
		var touch = element.getAttribute('data-touch');
		var scroll = element.getAttribute('data-scroll');
		var scrollmac = element.getAttribute('data-scrollmac');
		var owngooglegesturetext = element.getAttribute('data-owngooglegesturetext');

		// Default: worldCopyJump: false && scrollWheelZoom: true
		if (noWorldWarp === "1" && scrollwheelzoom === "0")
		{
			window['mymap' + moduleId] = new L.Map('map' + moduleId, {
				scrollWheelZoom: false,
				worldCopyJump: false,
				maxBounds: [[82, -180], [-82, 180]]
			}).setView(lonlat, zoom);
		} else if (noWorldWarp === "1" && scrollwheelzoom === "1") {
			window['mymap' + moduleId] = new L.Map('map' + moduleId, {
				worldCopyJump: false,
				maxBounds: [[82, -180], [-82, 180]]
			}).setView(lonlat, zoom);
		} else if (noWorldWarp === "1" && scrollwheelzoom === "2") {
			if (owngooglegesturetext === "1") {
				window['mymap' + moduleId] = new L.Map('map' + moduleId, {
					worldCopyJump: false,
					maxBounds: [[82, -180], [-82, 180]],
					gestureHandling: true,
					gestureHandlingText: {
						touch: touch,
						scroll: scroll,
						scrollMac: scrollmac
					}
				}).setView(lonlat, zoom);
			} else
			{
				window['mymap' + moduleId] = new L.Map('map' + moduleId, {
					worldCopyJump: false,
					maxBounds: [[82, -180], [-82, 180]],
					gestureHandling: true
				}).setView(lonlat, zoom);
			}
		} else if (noWorldWarp === "0" && scrollwheelzoom === "0") {
			window['mymap' + moduleId] = new L.Map('map' + moduleId, {
				scrollWheelZoom: false,
				worldCopyJump: true
			}).setView(lonlat, zoom);
		} else if (noWorldWarp === "0" && scrollwheelzoom === "2") {
			if (owngooglegesturetext === "1") {
				window['mymap' + moduleId] = new L.Map('map' + moduleId, {
					worldCopyJump: true,
					gestureHandling: true,
					gestureHandlingText: {
						touch: touch,
						scroll: scroll,
						scrollMac: scrollmac
					}
				}).setView(lonlat, zoom);
			} else
			{
				window['mymap' + moduleId] = new L.Map('map' + moduleId, {
					worldCopyJump: true,
					gestureHandling: true
				}).setView(lonlat, zoom);
			}
		} else {
			window['mymap' + moduleId] = new L.Map('map' + moduleId, {
				worldCopyJump: true
			}).setView(lonlat, zoom);
		}

		// Add Scrollwheele Listener, so that you can activate it on mouse click
		if (scrollwheelzoom === "0") {
			window['mymap' + moduleId].on('click', function () {
				if (window['mymap' + moduleId].scrollWheelZoom.enabled()) {
					window['mymap' + moduleId].scrollWheelZoom.disable();
				} else
				{
					window['mymap' + moduleId].scrollWheelZoom.enable();
				}
			});
		}

		// Baselayer
		var nowarp = "noWrap: false, ";
		if (noWorldWarp === "1")
		{
			nowarp = "noWrap: true, ";
		}
		var detectRetina = "detectRetina: false, ";
		if (detectRetina === "1")
		{
			detectRetina = "detectRetina: true, ";
		}

		// Base layer url
		var astrid = '';
		if (attrModule === '1')
		{
			astrid = ' ' + Joomla.JText._('MOD_AGOSM_MODULE_BY') + ' <a href="https://www.astrid-guenther.de">Astrid Günther</a>';
		}
		var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: '&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a>' + astrid
		});
		if (baselayer === 'mapbox')
		{
			tileLayer = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxkey, {
				maxZoom: 18,
				attribution: 'Map data &copy; <a href=\"https://openstreetmap.org\">OpenStreetMap</a> contributors, ' +
					'<a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
					'Imagery © <a href=\"https://mapbox.com\">Mapbox</a>' + astrid,
				id: mapboxmaptype
			});
		}
		if (baselayer === 'mapnikde')
		{
			tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>' + astrid
			});
		}
		if (baselayer === 'stamen')
		{
			tileLayer = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/' + stamenmaptype + '/{z}/{x}/{y}.png', {
				subdomains: 'abcd', minZoom: 1, maxZoom: 16,
				attribution: 'Map data &copy; <a href=\"https://openstreetmap.org\">OpenStreetMap</a> contributors, ' +
					'<a href=\"https://creativecommons.org/licenses/by-sa/3.0/\">CC-BY 3.0</a>, ' +
					'Imagery &copy; <a href=\"http://stamen.com\">Stamen Design</a>' + astrid,
				id: ''
			});
		}
		if (baselayer === 'opentopomap')
		{
			tileLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
				maxZoom: 16,
				attribution: '<a href=\"https://creativecommons.org/licenses/by-sa/3.0/\">CC-BY 3.0</a>, ' +
					'Imagery &copy; <a href=\"http://viewfinderpanoramas.org\">SRTM</a>' + astrid,
				id: ''
			});
		}
		if (baselayer === 'openmapsurfer')
		{
			tileLayer = L.tileLayer('http://korona.geog.uni-heidelberg.de/tiles/roads/x={x}&y={y}&z={z}', {
				maxZoom: 20,
				attribution: '<a href=\"https://creativecommons.org/licenses/by-sa/3.0/\">CC-BY 3.0</a>, ' +
					'Imagery &copy; <a href=\"http://giscience.uni-hd.de\">GIScience Research Group</a>' + astrid,
				id: ''
			});
		}
		if (baselayer === 'humanitarian')
		{
			tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
				maxZoom: 20,
				attribution: '<a href=\"https://creativecommons.org/licenses/by-sa/3.0/\">CC-BY 3.0</a>, ' +
					'Imagery &copy; <a href=\"https://hotosm.org\">Humanitarian OpenStreetMap Team</a>' + astrid,
				id: ''
			});
		}
		if (baselayer === 'custom')
		{
			//tileLayer = L.tileLayer(customBaselayerURL, {customBaselayer});
		}
		if (baselayer === 'google')
		{
			tileLayer = L.gridLayer.googleMutant({
				type: googlemapstype,
				attribution: astrid
			});
		}
		if (baselayer === 'thunderforest')
		{
			tileLayer = L.tileLayer('https://{s}.tile.thunderforest.com/' + thunderforestmaptype + '/{z}/{x}/{y}.png?apikey={apikey}', {
				maxZoom: 22,
				apikey: thunderforestkey,
				attribution: '&copy; <a href=\"http://www.thunderforest.com/\">Thunderforest</a>, &copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
			});
		}

		tileLayer.addTo(window['mymap' + moduleId]);

		// SCALE CONTROL
		if ((scale) !== '0')
		{
			let aggpxScale = L.control.scale();

			if (scaleMetric !== '1')
			{
				aggpxScale.options.metric = false;
			}

			if (scaleImperial !== '1')
			{
				aggpxScale.options.imperial = false;
			}

			aggpxScale.addTo(window['mymap' + moduleId]);

		}

		// Add Geocoder
		if (showgeocoder === "1")
		{
			var osmGeocoder = new L.Control.Geocoder({
				collapsed: geocodercollapsed,
				position: geocoderposition,
				geocoder: new L.Control.Geocoder.Nominatim(),
				expand: expand,
				placeholder: Joomla.JText._('MOD_AGOSM_DEFAULT_TEXT_PLACEHOLDER'),
				errorMessage: Joomla.JText._('MOD_AGOSM_DEFAULT_TEXT_ERRORMESSAGE')
			});
			window['mymap' + moduleId].addControl(osmGeocoder);
		}

		// Add ESRI Geocoder
		if (useesri === "1")
		{
			if (dataEsrigeocoderopengetaddress)
			{
				function getURLParameter(name) {
					var value = decodeURIComponent((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, ""])[1]);
					return (value !== 'null') ? value : false;
				}
				var address = decodeURIComponent(getURLParameter('address'));
				L.esri.Geocoding.geocode().text(address).run(function (err, result, response) {
					if (typeof result !== 'undefined' && result.length > 0) {
						L.marker(result.results[0].latlng).addTo(window['mymap' + moduleId]);
						window['mymap' + moduleId].setView(result.results[0].latlng, 13);
					}
				});
			}


			if (esrireversegeocoding === 'true')
			{
				var r = L.marker();
				window['mymap' + moduleId].on('click', function (e) {
					L.esri.Geocoding.reverseGeocode()
						.latlng(e.latlng)
						.run(function (error, result, response) {
							r = L.marker(result.latlng).addTo(window['mymap' + moduleId]).bindPopup(result.address.Match_addr).openPopup();
						});
				});
			}

			if (showgeocoderesri === '1')
			{
				var esriGeocoder = L.esri.Geocoding.geosearch({
					position: positionesrigeocoder,
					zoomToResult: esrigeocoderzoomToResult,
					useMapBounds: esrigeocoderuseMapBounds,
					collapseAfterResult: esrigeocodercollapseAfterResult,
					expanded: esrigeocoderexpanded,
					allowMultipleResults: esriallowMultipleResults,
					placeholder: Joomla.JText._('MOD_AGOSM_DEFAULT_ESRI_GEOCODER_PLACEHOLDER'),
					title: Joomla.JText._('MOD_AGOSM_DEFAULT_ESRI_GEOCODER_TITLE')
				});
				var results = L.layerGroup().addTo(window['mymap' + moduleId]);
				esriGeocoder.on('results', function (data) {
					results.clearLayers();
					for (var i = data.results.length - 1; i >= 0; i--) {
						results.addLayer(L.marker(data.results[i].latlng));
					}
				});
				window['mymap' + moduleId].addControl(esriGeocoder);
			}
		}

		// Add Routing Simple
		if (showrouting_simple === '1')
		{
			L.leafletControlRoutingtoaddress({
				position: routesimpleposition,
				router: routesimplerouter,
				token: routesimplerouterkey,
				placeholder: Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_PLACEHOLDER'),
				errormessage: Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_ERRORMESSAGE'),
				distance: Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_DISTANCE'),
				duration: Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_DURATION'),
				target: routesimpletarget,
				addresserror: Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_ADDRESSERROR'),
				requesterror: Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_REQUESTERROR')
			}).addTo(window['mymap' + moduleId]);

		}

		// Add Routing Mapbox
		if (showrouting === '1')
		{
			function button(label, container) {
				var btn = L.DomUtil.create('button', '', container);
				btn.setAttribute('type', 'button');
				btn.innerHTML = label;
				return btn;
			}
			
			var control = L.Routing.control({
				geocoder: L.Control.Geocoder.nominatim({}),
				waypoints: [
					L.latLng(routingstart),
					L.latLng(routingend)
				],
				collapsible: true,
				show: false,
				autoRoute: true,
				router: L.Routing.mapbox(mapboxkeyRouting,
					{
						profile: routingprofile,
						language: routinglanguage,
					}),
				units: routingmetric,
				reverseWaypoints: true,
				routeWhileDragging: routewhiledragging
			}).addTo(window['mymap' + moduleId]);

			(window['mymap' + moduleId]).on('click', function (e) {
				var container = L.DomUtil.create('div');
				var startBtn = button('Start', container);
				var destBtn = button('End', container);
				L.DomEvent.on(startBtn, 'click', function () {
					control.spliceWaypoints(0, 1, e.latlng);
					(window['mymap' + moduleId]).closePopup();
				});
				L.DomEvent.on(destBtn, 'click', function () {
					control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng);
					(window['mymap' + moduleId]).closePopup();
				});
				L.popup().setContent(container).setLatLng(e.latlng).openOn(window['mymap' + moduleId]);
			});
		}

		// Special Pins
		if (showpin === '1')
		{
			for (var specialpin in specialpins) {
				// skip loop if the property is from prototype
				if (!specialpins.hasOwnProperty(specialpin))
					continue;

				var obj = specialpins[specialpin];
				let tempMarker = L.marker(obj.latlonpin.split(",", 3));

				if (obj.pin === "2" && obj.customPinPath != "")
				{
					/*					var LeafIcon = L.Icon.extend({
					 options: {
					 iconUrl: obj.customPinPath,
					 shadowUrl: obj.customPinShadowPath,
					 iconSize: obj.customPinSize.split(",", 3).map(e => parseInt(e)),
					 shadowSize: obj.customPinShadowSize.split(",", 3).map(e => parseInt(e)),
					 iconAnchor: obj.customPinOffset.split(",", 3).map(e => parseInt(e)),
					 popupAnchor: obj.customPinPopupOffset.split(",", 3).map(e => parseInt(e)),
					 }
					 });*/
					var LeafIcon = L.Icon.extend({
						options: {
							iconUrl: obj.customPinPath,
							shadowUrl: obj.customPinShadowPath,
							iconSize: obj.customPinSize.split(",", 3).map(function (e) {
								return parseInt(e);
							}),
							shadowSize: obj.customPinShadowSize.split(",", 3).map(function (e) {
								return parseInt(e);
							}),
							iconAnchor: obj.customPinOffset.split(",", 3).map(function (e) {
								return parseInt(e);
							}),
							popupAnchor: obj.customPinPopupOffset.split(",", 3).map(function (e) {
								return parseInt(e);
							})
						}
					});
					tempMarker.setIcon(new LeafIcon());
				}

				if (obj.pin === "3")
				{
					var AwesomeIcon = new L.AwesomeMarkers.icon(
						{
							icon: obj.awesomeicon_icon,
							markerColor: obj.awesomeicon_markercolor,
							iconColor: obj.awesomeicon_iconcolor,
							prefix: 'fa',
							spin: (obj.awesomeicon_spin === "true"),
							extraClasses: obj.awesomeicon_extraclasses,
						})
					tempMarker.setIcon(AwesomeIcon);
				}



				tempMarker.addTo(window['mymap' + moduleId]);

				if (obj.popup === "1")
				{
						tempMarker.bindPopup(obj.popuptext.replace(/<img src="images/g, '<img src="' + uriroot + 'images'));
				}

				if (obj.popup === "2")
				{
					tempMarker.bindPopup(obj.popuptext.replace(/<img src="images/g, '<img src="' + uriroot + 'images')).openPopup();
				}
			}
		}

		// Show Pins from component
		if (showcomponentpin === '1')
		{

			for (var specialcomponentpin in specialcomponentpins) {
				// skip loop if the property is from prototype
				if (!specialcomponentpins.hasOwnProperty(specialcomponentpin))
					continue;

				var obj = specialcomponentpins[specialcomponentpin];
				let tempMarker = L.marker(obj.coordinates.split(",", 3));

				if (obj.showdefaultpin === "2" && obj.customPinPath != "")
				{
					/*					var LeafIcon = L.Icon.extend({
					 options: {
					 iconUrl: obj.customPinPath,
					 shadowUrl: obj.customPinShadowPath,
					 iconSize: obj.customPinSize.split(",", 3).map(e => parseInt(e)),
					 shadowSize: obj.customPinShadowSize.split(",", 3).map(e => parseInt(e)),
					 iconAnchor: obj.customPinOffset.split(",", 3).map(e => parseInt(e)),
					 popupAnchor: obj.customPinPopupOffset.split(",", 3).map(e => parseInt(e)),
					 }
					 });*/
					var LeafIcon = L.Icon.extend({
						options: {
							iconUrl: obj.customPinPath,
							shadowUrl: obj.customPinShadowPath,
							iconSize: obj.customPinSize.split(",", 3).map(function (e) {
								return parseInt(e);
							}),
							shadowSize: obj.customPinShadowSize.split(",", 3).map(function (e) {
								return parseInt(e);
							}),
							iconAnchor: obj.customPinOffset.split(",", 3).map(function (e) {
								return parseInt(e);
							}),
							popupAnchor: obj.customPinPopupOffset.split(",", 3).map(function (e) {
								return parseInt(e);
							})
						}
					});
					tempMarker.setIcon(new LeafIcon());
				}

				if (obj.showdefaultpin === "3")
				{
					var AwesomeIcon = new L.AwesomeMarkers.icon(
						{
							icon: obj.awesomeicon_icon,
							markerColor: obj.awesomeicon_markercolor,
							iconColor: obj.awesomeicon_iconcolor,
							prefix: 'fa',
							spin: (obj.awesomeicon_spin === "true"),
							extraClasses: obj.awesomeicon_extraclasses,
						})
					tempMarker.setIcon(AwesomeIcon);
				}



				tempMarker.addTo(window['mymap' + moduleId]);

				if (obj.showpopup === "1")
				{
					tempMarker.bindPopup(obj.popuptext.replace(/<img src="images/g, '<img src="' + uriroot + 'images'));
				}

				if (obj.showpopup === "2")
				{
					tempMarker.bindPopup(obj.popuptext.replace(/<img src="images/g, '<img src="' + uriroot + 'images')).openPopup();
				}
			}
		}

		// Show Pins from customfield
		if (showcustomfieldpin === '1')
		{
			var clustermarkers = L.markerClusterGroup();

			for (var specialcustomfieldpin in specialcustomfieldpins) {
				// skip loop if the property is from prototype
				if (!specialcustomfieldpins.hasOwnProperty(specialcustomfieldpin))
					continue;

				var objcf = specialcustomfieldpins[specialcustomfieldpin];

				let tempMarkercf = null;

				if (objcf.cords)
				{
					var values = objcf.cords.split(",");
					tempMarkercf = L.marker(objcf.cords.split(",").slice(0, 2));

					if (values.length > 4 && objcf.type !== 'agosmsaddressmarker')
					{
						var AwesomeIcon = new L.AwesomeMarkers.icon(
							{
								icon: values[4],
								markerColor: values[2],
								iconColor: values[3],
								prefix: 'fa',
								spin: false,
								extraClasses: "agosmsmarkerextraklasse",
							})
						tempMarkercf.setIcon(AwesomeIcon);
					}

					if (objcf.type === 'agosmsaddressmarker' && objcf.iconcolor && objcf.markercolor && objcf.icon)
					{
						var AwesomeIcon = new L.AwesomeMarkers.icon(
							{
								icon: objcf.icon,
								markerColor: objcf.markercolor,
								iconColor: objcf.iconcolor,
								prefix: 'fa',
								spin: false,
								extraClasses: "agosmsaddressmarkerextraklasse",
							})
						tempMarkercf.setIcon(AwesomeIcon);
					}

					let url = "index.php?options=com_content&view=article&id=" + objcf.id;
					let title = objcf.title;

					if (values.length > 5 && values[5].trim() != '')
					{
						title = values[5];
					}
					let popuptext = "<a href=' " + url + " '> " + title + " </a>";
					tempMarkercf.bindPopup(popuptext.replace(/<img src="images/g, '<img src="' + uriroot + 'images'));
					tempMarkercf.addTo(clustermarkers);
				}
			}
			window['mymap' + moduleId].fitBounds(clustermarkers.getBounds());
			clustermarkers.addTo(window['mymap' + moduleId]);
		}

	})
}, false);

=======
;
document.addEventListener('DOMContentLoaded',function(){var e=document.querySelectorAll('.leafletmapMod');[].forEach.call(e,function(e){var u=e.getAttribute('data-uriroot'),c=e.getAttribute('data-scrollwheelzoom'),d=e.getAttribute('data-no-world-warp'),o=e.getAttribute('data-module-id'),h=e.getAttribute('data-detect-retina'),n=e.getAttribute('data-baselayer'),p=e.getAttribute('data-lonlat').split(',',3),s=e.getAttribute('data-zoom'),Le=e.getAttribute('data-mapboxkey'),Me=e.getAttribute('data-thunderforestkey'),xe=e.getAttribute('data-stamenmaptype'),ie=e.getAttribute('data-thunderforestmaptype'),Te=e.getAttribute('data-googlemapstype'),ke=e.getAttribute('data-mapboxmaptype'),ne=e.getAttribute('data-attr-module'),Se=e.getAttribute('data-customBaselayer'),ve=e.getAttribute('data-customBaselayerURL'),X=e.getAttribute('data-scale'),re=e.getAttribute('data-scale-metric'),z=e.getAttribute('data-scale-imperial'),B=e.getAttribute('data-showgeocoder'),Z=e.getAttribute('data-useesri'),W=e.getAttribute('data-esrireversegeocoding'),U=(e.getAttribute('data-geocodercollapsed')==='true'),H=e.getAttribute('data-geocoderposition'),V=e.getAttribute('data-expand'),N=(e.getAttribute('data-esrigeocoderopengetaddress')==='true'),Y=e.getAttribute('data-showgeocoderesri'),F=e.getAttribute('data-positionesrigeocoder'),q=(e.getAttribute('data-esrigeocoderzoomToResult')==='true'),Q=(e.getAttribute('data-esrigeocoderuseMapBounds')==='true'),ee=(e.getAttribute('data-esrigeocodercollapseAfterResult')==='true'),te=(e.getAttribute('data-esrigeocoderexpanded')==='true'),oe=(e.getAttribute('data-esriallowMultipleResults')==='true'),M=e.getAttribute('data-showrouting-simple');
if(M==='1'){var we=e.getAttribute('data-route-simple-position'),Oe=e.getAttribute('data-route-simple-target'),se=e.getAttribute('data-route-simple-router'),he=e.getAttribute('data-route-simple-routerkey')};
var x=e.getAttribute('data-showrouting');
if(x==='1'){var pe=e.getAttribute('data-routingstart').split(',',3),me=e.getAttribute('data-routingend').split(',',3),le=e.getAttribute('data-mapboxkey-routing'),de=e.getAttribute('data-routingprofile'),ce=e.getAttribute('data-routinglanguage'),ue=e.getAttribute('data-routingmetric'),ge=e.getAttribute('data-routewhiledragging')};
var T=e.getAttribute('data-showpin');
if(T==='1'){var b=JSON.parse(e.getAttribute('data-specialpins'))};
var k=e.getAttribute('data-showcomponentpin');
if(k==='1'){var g=JSON.parse(e.getAttribute('data-specialcomponentpins'))};
var S=e.getAttribute('data-showcustomfieldpin');
if(S==='1'){var A=JSON.parse(e.getAttribute('data-specialcustomfieldpins'))};
var G=e.getAttribute('data-touch'),E=e.getAttribute('data-scroll'),v=e.getAttribute('data-scrollmac'),C=e.getAttribute('data-owngooglegesturetext');
if(d==='1'&&c==='0'){window['mymap'+o]=new L.Map('map'+o,{scrollWheelZoom:!1,worldCopyJump:!1,maxBounds:[[82,-180],[-82,180]]}).setView(p,s)}
else if(d==='1'&&c==='1'){window['mymap'+o]=new L.Map('map'+o,{worldCopyJump:!1,maxBounds:[[82,-180],[-82,180]]}).setView(p,s)}
else if(d==='1'&&c==='2'){if(C==='1'){window['mymap'+o]=new L.Map('map'+o,{worldCopyJump:!1,maxBounds:[[82,-180],[-82,180]],gestureHandling:!0,gestureHandlingText:{touch:G,scroll:E,scrollMac:v}}).setView(p,s)}
else{window['mymap'+o]=new L.Map('map'+o,{worldCopyJump:!1,maxBounds:[[82,-180],[-82,180]],gestureHandling:!0}).setView(p,s)}}
else if(d==='0'&&c==='0'){window['mymap'+o]=new L.Map('map'+o,{scrollWheelZoom:!1,worldCopyJump:!0}).setView(p,s)}
else if(d==='0'&&c==='2'){if(C==='1'){window['mymap'+o]=new L.Map('map'+o,{worldCopyJump:!0,gestureHandling:!0,gestureHandlingText:{touch:G,scroll:E,scrollMac:v}}).setView(p,s)}
else{window['mymap'+o]=new L.Map('map'+o,{worldCopyJump:!0,gestureHandling:!0}).setView(p,s)}}
else{window['mymap'+o]=new L.Map('map'+o,{worldCopyJump:!0}).setView(p,s)};
if(c==='0'){window['mymap'+o].on('click',function(){if(window['mymap'+o].scrollWheelZoom.enabled()){window['mymap'+o].scrollWheelZoom.disable()}
else{window['mymap'+o].scrollWheelZoom.enable()}})};
var fe='noWrap: false, ';
if(d==='1'){fe='noWrap: true, '};
var h='detectRetina: false, ';
if(h==='1'){h='detectRetina: true, '};
var r='';
if(ne==='1'){r=' '+Joomla.JText._('MOD_AGOSM_MODULE_BY')+' <a href="https://www.astrid-guenther.de">Astrid Günther</a>'};
var i=L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18,attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'+r});
if(n==='mapbox'){i=L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+Le,{maxZoom:18,attribution:'Map data &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://mapbox.com">Mapbox</a>'+r,id:ke})};
if(n==='mapnikde'){i=L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png',{maxZoom:18,attribution:'&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'+r})};
if(n==='stamen'){i=L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/'+xe+'/{z}/{x}/{y}.png',{subdomains:'abcd',minZoom:1,maxZoom:16,attribution:'Map data &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY 3.0</a>, Imagery &copy; <a href="http://stamen.com">Stamen Design</a>'+r,id:''})};
if(n==='opentopomap'){i=L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',{maxZoom:16,attribution:'<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY 3.0</a>, Imagery &copy; <a href="http://viewfinderpanoramas.org">SRTM</a>'+r,id:''})};
if(n==='openmapsurfer'){i=L.tileLayer('http://korona.geog.uni-heidelberg.de/tiles/roads/x={x}&y={y}&z={z}',{maxZoom:20,attribution:'<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY 3.0</a>, Imagery &copy; <a href="http://giscience.uni-hd.de">GIScience Research Group</a>'+r,id:''})};
if(n==='humanitarian'){i=L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',{maxZoom:20,attribution:'<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY 3.0</a>, Imagery &copy; <a href="https://hotosm.org">Humanitarian OpenStreetMap Team</a>'+r,id:''})};
if(n==='custom'){};
if(n==='google'){i=L.gridLayer.googleMutant({type:Te,attribution:r})};
if(n==='thunderforest'){i=L.tileLayer('https://{s}.tile.thunderforest.com/'+ie+'/{z}/{x}/{y}.png?apikey={apikey}',{maxZoom:22,apikey:Me,attribution:'&copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'})};
i.addTo(window['mymap'+o]);
if((X)!=='0'){let aggpxScale=L.control.scale();
if(re!=='1'){aggpxScale.options.metric=!1};
if(z!=='1'){aggpxScale.options.imperial=!1};
aggpxScale.addTo(window['mymap'+o])};
if(B==='1'){var ye=new L.Control.Geocoder({collapsed:U,position:H,geocoder:new L.Control.Geocoder.Nominatim(),expand:V,placeholder:Joomla.JText._('MOD_AGOSM_DEFAULT_TEXT_PLACEHOLDER'),errorMessage:Joomla.JText._('MOD_AGOSM_DEFAULT_TEXT_ERRORMESSAGE')});
window['mymap'+o].addControl(ye)};
if(Z==='1'){if(N){function ae(e){var t=decodeURIComponent((RegExp(e+'=(.+?)(&|$)').exec(location.search)||[,''])[1]);
return(t!=='null')?t:!1};
var be=decodeURIComponent(ae('address'));
L.esri.Geocoding.geocode().text(be).run(function(e,t,a){if(typeof t!=='undefined'&&t.length>0){L.marker(t.results[0].latlng).addTo(window['mymap'+o]);
window['mymap'+o].setView(t.results[0].latlng,13)}})};
if(W==='true'){var Ae=L.marker();
window['mymap'+o].on('click',function(e){L.esri.Geocoding.reverseGeocode().latlng(e.latlng).run(function(e,t,a){Ae=L.marker(t.latlng).addTo(window['mymap'+o]).bindPopup(t.address.Match_addr).openPopup()})})};
if(Y==='1'){var D=L.esri.Geocoding.geosearch({position:F,zoomToResult:q,useMapBounds:Q,collapseAfterResult:ee,expanded:te,allowMultipleResults:oe,placeholder:Joomla.JText._('MOD_AGOSM_DEFAULT_ESRI_GEOCODER_PLACEHOLDER'),title:Joomla.JText._('MOD_AGOSM_DEFAULT_ESRI_GEOCODER_TITLE')});
var J=L.layerGroup().addTo(window['mymap'+o]);
D.on('results',function(e){J.clearLayers();
for(var t=e.results.length-1;t>=0;t--){J.addLayer(L.marker(e.results[t].latlng))}});
window['mymap'+o].addControl(D)}};
if(M==='1'){L.leafletControlRoutingtoaddress({position:we,router:se,token:he,placeholder:Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_PLACEHOLDER'),errormessage:Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_ERRORMESSAGE'),distance:Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_DISTANCE'),duration:Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_DURATION'),target:Oe,addresserror:Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_ADDRESSERROR'),requesterror:Joomla.JText._('MOD_AGOSM_ROUTING_SIMPLE_TEXT_REQUESTERROR')}).addTo(window['mymap'+o])};
if(x==='1'){function O(e,t){var o=L.DomUtil.create('button','',t);
o.setAttribute('type','button');
o.innerHTML=e;
return o};
var w=L.Routing.control({geocoder:L.Control.Geocoder.nominatim({}),waypoints:[L.latLng(pe),L.latLng(me)],collapsible:!0,show:!1,autoRoute:!0,router:L.Routing.mapbox(le,{profile:de,language:ce,}),units:ue,reverseWaypoints:!0,routeWhileDragging:ge}).addTo(window['mymap'+o]);(window['mymap'+o]).on('click',function(e){var t=L.DomUtil.create('div'),a=O('Start',t),r=O('End',t);
L.DomEvent.on(a,'click',function(){w.spliceWaypoints(0,1,e.latlng);(window['mymap'+o]).closePopup()});
L.DomEvent.on(r,'click',function(){w.spliceWaypoints(w.getWaypoints().length-1,1,e.latlng);(window['mymap'+o]).closePopup()});
L.popup().setContent(t).setLatLng(e.latlng).openOn(window['mymap'+o])})};
if(T==='1'){for(var I in b){if(!b.hasOwnProperty(I))continue;
var t=b[I];
let tempMarker=L.marker(t.latlonpin.split(',',3));
if(t.pin==='2'&&t.customPinPath!=''){var f=L.Icon.extend({options:{iconUrl:t.customPinPath,shadowUrl:t.customPinShadowPath,iconSize:t.customPinSize.split(',',3).map(function(e){return parseInt(e)}),shadowSize:t.customPinShadowSize.split(',',3).map(function(e){return parseInt(e)}),iconAnchor:t.customPinOffset.split(',',3).map(function(e){return parseInt(e)}),popupAnchor:t.customPinPopupOffset.split(',',3).map(function(e){return parseInt(e)})}});
tempMarker.setIcon(new f())};
if(t.pin==='3'){var m=new L.AwesomeMarkers.icon({icon:t.awesomeicon_icon,markerColor:t.awesomeicon_markercolor,iconColor:t.awesomeicon_iconcolor,prefix:'fa',spin:(t.awesomeicon_spin==='true'),extraClasses:t.awesomeicon_extraclasses,});
tempMarker.setIcon(m)};
tempMarker.addTo(window['mymap'+o]);
if(t.popup==='1'){tempMarker.bindPopup(t.popuptext.replace(/<img src="images/g,'<img src="'+u+'images'))};
if(t.popup==='2'){tempMarker.bindPopup(t.popuptext.replace(/<img src="images/g,'<img src="'+u+'images')).openPopup()}}};
if(k==='1'){for(var P in g){if(!g.hasOwnProperty(P))continue;
var t=g[P];
let tempMarker=L.marker(t.coordinates.split(',',3));
if(t.showdefaultpin==='2'&&t.customPinPath!=''){var f=L.Icon.extend({options:{iconUrl:t.customPinPath,shadowUrl:t.customPinShadowPath,iconSize:t.customPinSize.split(',',3).map(function(e){return parseInt(e)}),shadowSize:t.customPinShadowSize.split(',',3).map(function(e){return parseInt(e)}),iconAnchor:t.customPinOffset.split(',',3).map(function(e){return parseInt(e)}),popupAnchor:t.customPinPopupOffset.split(',',3).map(function(e){return parseInt(e)})}});
tempMarker.setIcon(new f())};
if(t.showdefaultpin==='3'){var m=new L.AwesomeMarkers.icon({icon:t.awesomeicon_icon,markerColor:t.awesomeicon_markercolor,iconColor:t.awesomeicon_iconcolor,prefix:'fa',spin:(t.awesomeicon_spin==='true'),extraClasses:t.awesomeicon_extraclasses,});
tempMarker.setIcon(m)};
tempMarker.addTo(window['mymap'+o]);
if(t.showpopup==='1'){tempMarker.bindPopup(t.popuptext.replace(/<img src="images/g,'<img src="'+u+'images'))};
if(t.showpopup==='2'){tempMarker.bindPopup(t.popuptext.replace(/<img src="images/g,'<img src="'+u+'images')).openPopup()}}};
if(S==='1'){var y=L.markerClusterGroup();
for(var R in A){if(!A.hasOwnProperty(R))continue;
var a=A[R];
let tempMarkercf=null;
if(a.cords){var l=a.cords.split(',');
tempMarkercf=L.marker(a.cords.split(',').slice(0,2));
if(l.length>4&&a.type!=='agosmsaddressmarker'){var m=new L.AwesomeMarkers.icon({icon:l[4],markerColor:l[2],iconColor:l[3],prefix:'fa',spin:!1,extraClasses:'agosmsmarkerextraklasse',});
tempMarkercf.setIcon(m)};
if(a.type==='agosmsaddressmarker'&&a.iconcolor&&a.markercolor&&a.icon){var m=new L.AwesomeMarkers.icon({icon:a.icon,markerColor:a.markercolor,iconColor:a.iconcolor,prefix:'fa',spin:!1,extraClasses:'agosmsaddressmarkerextraklasse',});
tempMarkercf.setIcon(m)};
let url='index.php?options=com_content&view=article&id='+a.id;
let title=a.title;
if(l.length>5&&l[5].trim()!=''){title=l[5]};
let popuptext='<a href=\' '+url+' \'> '+title+' </a>';
tempMarkercf.bindPopup(t.popuptext.replace(/<img src="images/g,'<img src="'+u+'images'));
tempMarkercf.addTo(y)}};
window['mymap'+o].fitBounds(y.getBounds());
y.addTo(window['mymap'+o])}})},!1);
>>>>>>> master
