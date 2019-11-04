document.addEventListener('DOMContentLoaded', function () {
	var leafletmaps = document.querySelectorAll('.agosmsaddressmarkerleafletmap');

	// For all maps [start]
	[].forEach.call(leafletmaps, function (element) {

		var unique = element.getAttribute('data-unique');
		var lat = element.getAttribute('data-lat');
		var lon = element.getAttribute('data-lon');

		map = new L.Map('map' + unique);

		var googleLayer = L.gridLayer.googleMutant({
			type: 'roadmap'
		}).addTo(map);
		

		// For all maps [end]

		try {
			map.setView(new L.LatLng(lat, lon), 13);
			var marker = L.marker([lat, lon]).addTo(map);
		} catch (e) {
			map.setView(new L.LatLng(0, 0), 13);
			var marker = L.marker([0, 0]).addTo(map);
			console.log(e);
		}
	});

}, false);