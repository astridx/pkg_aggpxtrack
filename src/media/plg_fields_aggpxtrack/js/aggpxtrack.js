document.addEventListener('DOMContentLoaded', function () {
	var leafletmaps = document.querySelectorAll('.leafletmap');

	// For all maps [start]
	[].forEach.call(leafletmaps, function (element) {

		var unique = element.getAttribute('data-unique');
		var scrollwheelzoom = element.getAttribute('data-scrollwheelzoom');
		var maptype = element.getAttribute('data-maptype');
		var thunderforestkey = element.getAttribute('data-thunderforestkey');
		var mapboxkey = element.getAttribute('data-mapboxkey');
		var thunderforestmaptype = element.getAttribute('data-thunderforestmaptype');
		var googlemapstype = element.getAttribute('data-googlemapstype');
		var show_omnivore = element.getAttribute('data-show_omnivore');
		var omnivore_icon = element.getAttribute('data-omnivore_icon');
		var omnivore_markercolor = element.getAttribute('data-omnivore_markercolor');
		var omnivore_iconcolor = element.getAttribute('data-omnivore_iconcolor');
		var omnivore_spin = (element.getAttribute('data-omnivore_spin') === "1");
		var omnivore_extraclasses = element.getAttribute('data-omnivore_extraclasses');
		var omnivore_file = element.getAttribute('data-omnivore_file');
		var show_fullscreencontrol = element.getAttribute('data-show_fullscreencontrol');
		var fullscreencontrol_viewfullscreen = element.getAttribute('data-fullscreencontrol_viewfullscreen');
		var fullscreencontrol_exitfullscreen = element.getAttribute('data-fullscreencontrol_exitfullscreen');
		var fullscreencontrol_position = element.getAttribute('data-fullscreencontrol_position');
		var show_easyprint = element.getAttribute('data-show_easyprint');
		var easyprint_position = element.getAttribute('data-easyprint_position');
		var gpx_file_name = element.getAttribute('data-gpx_file_name');
		var startIconUrl = element.getAttribute('data-startIconUrl');
		var endIconUrl = element.getAttribute('data-endIconUrl');
		var shadowUrl = element.getAttribute('data-shadowUrl');
		var wptIconUrls = element.getAttribute('data-wptIconUrls');

		var custom_icons = element.getAttribute('data-custom_icons');
		var customiconstart_icon = element.getAttribute('data-customiconstart_icon');
		var customiconstart_markercolor = element.getAttribute('data-customiconstart_markercolor');
		var customiconstart_iconcolor = element.getAttribute('data-customiconstart_iconcolor');
		var customiconstart_spin = (element.getAttribute('data-customiconstart_spin') === "1");
		var customiconstart_extraclasses = element.getAttribute('data-customiconstart_extraclasses');
		var customiconend_icon = element.getAttribute('data-customiconend_icon');
		var customiconend_markercolor = element.getAttribute('data-customiconend_markercolor');
		var customiconend_iconcolor = element.getAttribute('data-customiconend_iconcolor');
		var customiconend_spin = (element.getAttribute('data-customiconend_spin') === "1");
		var customiconend_extraclasses = element.getAttribute('data-customiconend_extraclasses');
		var customiconwaypoint_icon = element.getAttribute('data-customiconwaypoint_icon');
		var customiconwaypoint_markercolor = element.getAttribute('data-customiconwaypoint_markercolor');
		var customiconwaypoint_iconcolor = element.getAttribute('data-customiconwaypoint_iconcolor');
		var customiconwaypoint_spin = (element.getAttribute('data-customiconwaypoint_spin') === "1");
		var customiconwaypoint_extraclasses = element.getAttribute('data-customiconwaypoint_extraclasses');
		var specialwaypoints = JSON.parse(element.getAttribute('data-specialwaypoints'));
		var polylinecolor = element.getAttribute('data-polylinecolor');
		var showelements = element.getAttribute('data-showelements');
		var show_kilometer_points = (element.getAttribute('data-show_kilometer_points') === "1");
		var kilometer_point_color = element.getAttribute('data-kilometer_point_color');
		var kilometer_point_color_text = element.getAttribute('data-kilometer_point_color_text');
		var kilometer_point_intervall = element.getAttribute('data-kilometer_point_intervall');
		var kilometer_point_radius = element.getAttribute('data-kilometer_point_radius');
		var show_currentposition = element.getAttribute('data-show_currentposition');
		var currentposition_position = element.getAttribute('data-currentposition_position');
		var currentposition_initialZoomLevel = element.getAttribute('data-currentposition_initialZoomLevel');
		var scale = element.getAttribute('data-scale');
		var scale_metric = element.getAttribute('data-scale-metric');
		var scale_imperial = element.getAttribute('data-scale-imperial');

		var show_elevantioncontrol = element.getAttribute('data-show_elevantioncontrol');
		if (show_elevantioncontrol)
		{
			var elevantioncontrol_collapsed = (element.getAttribute('data-elevantioncontrol_collapsed') === "true");
			var elevantioncontrol_top = element.getAttribute('data-show_elevantioncontrol');
			var elevantioncontrol_right = element.getAttribute('data-elevantioncontrol_right');
			var elevantioncontrol_bottom = element.getAttribute('data-elevantioncontrol_bottom');
			var elevantioncontrol_left = element.getAttribute('data-elevantioncontrol_left');
			var elevantioncontrol_position = element.getAttribute('data-elevantioncontrol_position');
			var elevantioncontrol_theme = element.getAttribute('data-elevantioncontrol_theme');
			var elevantioncontrol_width = element.getAttribute('data-elevantioncontrol_width');
			var elevantioncontrol_height = element.getAttribute('data-elevantioncontrol_height');
		}

		var show_panelLayers = element.getAttribute('data-show_panelLayers');
		if (show_panelLayers)
		{
			var panelLayers = JSON.parse(element.getAttribute('data-panelLayers'));
		}


		// Initialize the Map
		if (scrollwheelzoom === "0")
		{
			window['mymap' + unique] = L.map('map' + unique, {scrollWheelZoom: false}).setView([51.505, -0.09], 13);
		} else {
			window['mymap' + unique] = L.map('map' + unique).setView([51.505, -0.09], 13);
		}

		//
		// GPX OBJEKT
		//

		// Custom Markers
		window['aggpx_marker_options' + unique] = {
			startIconUrl: startIconUrl,
			endIconUrl: endIconUrl,
			shadowUrl: shadowUrl,
			wptIconUrls: {'': wptIconUrls, }
		};
		if (custom_icons === "1")
		{
			window['aggpx_marker_options' + unique] = {
				startIcon: new L.AwesomeMarkers.icon(
						{
							icon: customiconstart_icon,
							markerColor: customiconstart_markercolor,
							iconColor: customiconstart_iconcolor,
							prefix: 'fa',
							spin: customiconstart_spin,
							extraClasses: customiconstart_extraclasses,
						}
				),
				endIcon: new L.AwesomeMarkers.icon(
						{
							icon: customiconend_icon,
							markerColor: customiconend_markercolor,
							iconColor: customiconend_iconcolor,
							prefix: 'fa',
							spin: customiconend_spin,
							extraClasses: customiconend_extraclasses,
						}
				),
				wptIcons: {
					'':
							new L.AwesomeMarkers.icon(
									{
										icon: customiconwaypoint_icon,
										markerColor: customiconwaypoint_markercolor,
										iconColor: customiconwaypoint_iconcolor,
										prefix: 'fa',
										spin: customiconwaypoint_spin,
										extraClasses: customiconwaypoint_extraclasses,
									}
							)
				}
			}

			if (typeof specialwaypoints !== 'undefined')
			{
				for (var element in specialwaypoints) {
					if ([specialwaypoints[element].sub_customicon_tagname] !== '') {
						Object.assign(window['aggpx_marker_options' + unique].wptIcons, {
							[specialwaypoints[element].sub_customicon_tagname]:
									new L.AwesomeMarkers.icon(
											{
												icon: specialwaypoints[element].sub_customicon_icon,
												markerColor: specialwaypoints[element].sub_customicon_markercolor,
												iconColor: specialwaypoints[element].sub_customicon_iconcolor,
												prefix: 'fa',
												//spin: specialwaypoints[element].sub_customicon_spin,
												//spin: "0",
												extraClasses: specialwaypoints[element].sub_customicon_extraclasses,
											})
						});
					}
				}
			}
		}

		// GPX Object
		window['leaflet_gpx_objekt' + unique] = new L.GPX(gpx_file_name, {
			polyline_options: {
				color: polylinecolor,
			},
			async: true,
			gpx_options: {
				parseElements: showelements.split(','),
				show_kilometer_point: show_kilometer_points,
				kilometer_point_options: {
					kilometer_point_color: kilometer_point_color,
					kilometer_point_color_text: kilometer_point_color_text,
					kilometer_point_intervall: kilometer_point_intervall,
					kilometer_point_radius: kilometer_point_radius,
				},
				show_mile_point: false,
				mile_point_options: {
					mile_point_color: 'red',
					mile_point_color_text: 'green',
					mile_point_intervall: 0,
					mile_point_radius: 10,
				},
			},
			marker_options: window['aggpx_marker_options' + unique]
		});



		// Add Listener if Scroolwheelzoom is deactivated
		if (scrollwheelzoom === "0")
		{
			window['mymap' + unique].on('click', function () {
				if (window['mymap' + unique].scrollWheelZoom.enabled())
				{
					window['mymap' + unique].scrollWheelZoom.disable();
				} else {
					window['mymap' + unique].scrollWheelZoom.enable();
				}
			});
		}

		// Load the correct map
		if (maptype === "osm")
		{
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
			}).addTo(window['mymap' + unique]);
		} else if (maptype === "osm_bw")
		{
			L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: '&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
			}).addTo(window['mymap' + unique]);
		} else if (maptype === 'thunderforest')
		{
			L.tileLayer('https://{s}.tile.thunderforest.com/' + thunderforestmaptype + '/{z}/{x}/{y}.png?apikey={apikey}', {
				maxZoom: 22,
				apikey: thunderforestkey,
				attribution: '&copy; <a href=\"http://www.thunderforest.com/\">Thunderforest</a>, &copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>'
			}).addTo(window['mymap' + unique]);
		} else if (maptype === 'mapbox')
		{
			L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxkey, {
				maxZoom: 18,
				attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, ' +
						'<a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
						'Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',
				id: 'mapbox.streets'
			}).addTo(window['mymap' + unique]);
		} else if (maptype === 'opentopomap')
		{
			L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
				maxZoom: 17,
				attribution: 'Map data: &copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>, <a href=\"http://viewfinderpanoramas.org\">SRTM</a> | Map style: &copy; <a href=\"https://opentopomap.org\">OpenTopoMap</a> (<a href=\"https://creativecommons.org/licenses/by-sa/3.0/\">CC-BY-SA</a>)'
			}).addTo(window['mymap' + unique]);
		} else if (maptype === 'google')
		{
			L.gridLayer.googleMutant({
				type: googlemapstype,
			}).addTo(window['mymap' + unique]);
		} else
		{
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: ''
			}).addTo(window['mymap' + unique]);
		}

		// KML Overlay
		if (show_omnivore === "1")
		{
			var runLayer = omnivore.kml(omnivore_file).on('ready', function () {
				var omnivoreIcon = new L.AwesomeMarkers.icon(
						{
							icon: omnivore_icon,
							markerColor: omnivore_markercolor,
							iconColor: omnivore_iconcolor,
							prefix: 'fa',
							spin: omnivore_spin,
							extraClasses: omnivore_extraclasses,
						}
				);
				runLayer.eachLayer(function (layer) {
					layer.setIcon(omnivoreIcon);
					if (!layer.feature.properties.name) {
						layer.feature.properties.name;
					}
					if (!layer.feature.properties.description) {
						layer.feature.properties.description = '';
					}
					layer.bindPopup(layer.feature.properties.name + '<br />' + layer.feature.properties.description);
				})
			}).addTo(window['mymap' + unique]);
		}

		// Fullscreen
		if (show_fullscreencontrol === "1")
		{
			window['mymap' + unique].addControl(
					new L.Control.Fullscreen({
						position: fullscreencontrol_position,
						title: {
							'false': fullscreencontrol_viewfullscreen,
							'true': fullscreencontrol_exitfullscreen
						}
					})
					);
		}

		// SCALE CONTROL
		if (show_currentposition === "1")
		{
			L.control.locate({
				position: currentposition_position,
				initialZoomLevel: currentposition_initialZoomLevel,
				keepCurrentZoomLevel: true,
				setView: 'always',
				strings: {
					'title': Joomla.JText._('PLG_AGGPXTRACK_CURRENTPOSITION_STRING'),
				},
				locateOptions: {
					enableHighAccuracy: true,
					watch: true,
				}
			}).addTo(window['mymap' + unique]);
		}


		// SCALE CONTROL
		if ((scale) !== '0')
		{
			let aggpxScale = L.control.scale();

			if (scale_metric !== '1')
			{
				aggpxScale.options.metric = false;
			}

			if (scale_imperial !== '1')
			{
				aggpxScale.options.imperial = false;
			}

			aggpxScale.addTo(window['mymap' + unique]);

		}


		if (show_elevantioncontrol === "1")
		{

			if (elevantioncontrol_height === "-100")
			{
				elevantioncontrol_height = document.getElementById('map' + unique).offsetHeight;
			}
			if (elevantioncontrol_height === "-75")
			{
				elevantioncontrol_height = document.getElementById('map' + unique).offsetHeight * 0.75;
			}
			if (elevantioncontrol_height === "-50")
			{
				elevantioncontrol_height = document.getElementById('map' + unique).offsetHeight * 0.5;
			}
			if (elevantioncontrol_height === "-25")
			{
				elevantioncontrol_height = document.getElementById('map' + unique).offsetHeight * 0.25;
			}

			if (elevantioncontrol_width === "-100")
			{
				elevantioncontrol_width = document.getElementById('map' + unique).offsetWidth;
			}
			if (elevantioncontrol_width === "-75")
			{
				elevantioncontrol_width = document.getElementById('map' + unique).offsetWidth * 0.75;
			}
			if (elevantioncontrol_width === "-50")
			{
				elevantioncontrol_width = document.getElementById('map' + unique).offsetWidth * 0.5;
			}
			if (elevantioncontrol_width === "-25")
			{
				elevantioncontrol_width = document.getElementById('map' + unique).offsetWidth * 0.25;
			}

			window['aggpx_elevation' + unique] = L.control.elevation({
				position: elevantioncontrol_position,
				mapid: '#map' + unique,
				theme: elevantioncontrol_theme, //default: lime-theme
				width: elevantioncontrol_width,
				height: elevantioncontrol_height,
				margins: {
					top: elevantioncontrol_top,
					right: elevantioncontrol_right,
					bottom: elevantioncontrol_bottom,
					left: elevantioncontrol_left
				},
				useHeightIndicator: true, //if false a marker is drawn at map position
				interpolation: "linear", //see https://github.com/mbostock/d3/wiki/SVG-Shapes#wiki-area_interpolate
				hoverNumber: {
					decimalsX: 3, //decimals on distance (always in km)
					decimalsY: 0, //deciamls on hehttps://www.npmjs.com/package/leaflet.coordinatesight (always in m)
					formatter: undefined //custom formatter function may be injected
				},
				xTicks: undefined, //number of ticks in x axis, calculated by default according to width
				yTicks: undefined, //number of ticks on y axis, calculated by default according to height
				collapsed: elevantioncontrol_collapsed, //collapsed mode, show chart on click or mouseover
				imperial: false    //display imperial units instead of metric
			});

			window['aggpx_elevation' + unique].addTo(window['mymap' + unique]);
			window['leaflet_gpx_objekt' + unique].on('addline', function (e) {
				window['aggpx_elevation' + unique].addData(e.line);
			});
		}

		window['leaflet_gpx_objekt' + unique].on('loaded', function (e) {
			window['mymap' + unique].fitBounds(e.target.getBounds(), {padding: [15, 15]});

			var gpx = e.target;

			var infoElements = [
				'distance',
				'name',
				'start_time',
				'end_time',
				'moving_time',
				'total_time',
				'moving_pace',
				'moving_speed',
				'total_speed',
				'elevation_min',
				'elevation_max',
				'elevation_gain',
				'elevation_loss',
				'average_hr',
				'average_cadence',
				'average_temp'];

			infoElements.forEach(function (infoElement) {
				var value = document.getElementById(infoElement + '_value' + unique);
				if (value)
				{
					if (infoElement === 'distance') {
						value.innerHTML = (gpx.get_distance() / 1000).toFixed(0);
					}
					if (infoElement === 'name') {
						value.innerHTML = gpx.get_name();
						;
					}
					if (infoElement === 'start_time') {
						value.innerHTML = gpx.get_start_time().toLocaleDateString() + ' - ' + gpx.get_start_time().toLocaleTimeString();
					}
					if (infoElement === 'end_time') {
						value.innerHTML = gpx.get_end_time().toLocaleDateString() + ' - ' + gpx.get_end_time().toLocaleTimeString();
						;
					}
					if (infoElement === 'moving_time') {
						value.innerHTML = gpx.get_duration_string(gpx.get_moving_time());
					}
					if (infoElement === 'total_time') {
						value.innerHTML = gpx.get_duration_string(gpx.get_total_time());
					}
					if (infoElement === 'moving_pace') {
						value.innerHTML = gpx.get_duration_string(gpx.get_moving_pace());
					}
					if (infoElement === 'moving_speed') {
						value.innerHTML = gpx.get_moving_speed().toFixed(0);
					}
					if (infoElement === 'total_speed') {
						value.innerHTML = gpx.get_total_speed().toFixed(0);
					}
					if (infoElement === 'elevation_min') {
						value.innerHTML = gpx.get_elevation_min().toFixed(0);
					}
					if (infoElement === 'elevation_max') {
						value.innerHTML = gpx.get_elevation_max().toFixed(0);
					}
					if (infoElement === 'elevation_gain') {
						value.innerHTML = gpx.get_elevation_gain().toFixed(0);
					}
					if (infoElement === 'elevation_loss') {
						value.innerHTML = gpx.get_elevation_loss().toFixed(0);
					}
					if (infoElement === 'average_hr') {
						value.innerHTML = gpx.get_average_hr().toFixed(0);
					}
					if (infoElement === 'average_cadence') {
						value.innerHTML = gpx.get_average_cadence().toFixed(0);
					}
					if (infoElement === 'average_temp') {
						value.innerHTML = gpx.get_average_temp().toFixed(0);
					}
				}
			});

		}).addTo(window['mymap' + unique]);



		if (show_easyprint === "1")
		{
			window['mymap' + unique].addControl(
					new L.easyPrint({
						hideControlContainer: true,
						sizeModes: ['Current', 'A4Portrait', 'A4Landscape'],
						position: easyprint_position,
						exportOnly: true,
					}));
		}




		if (show_panelLayers === "1")
		{
			var panelLayersControl = L.control.panelLayers();

			for (var panelLayer in panelLayers) {
				// skip loop if the property is from prototype
				if (!panelLayers.hasOwnProperty(panelLayer))
					continue;

				var obj = panelLayers[panelLayer];

				panelLayersControl.addBaseLayer({
					name: obj.name,
					layer: L.tileLayer(obj.value),
				})
			}
			panelLayersControl.addTo(window['mymap' + unique]);
		}

	});
	// For all maps [end]

}, false);