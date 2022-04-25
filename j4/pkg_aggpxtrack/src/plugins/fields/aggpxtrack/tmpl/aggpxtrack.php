<?php

/**
 * @package     Joomla.Site
 * @subpackage  pkg_aggpxtrack
 *
 * @copyright   Copyright (C) 2005 - 2018 Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */
defined('_JEXEC') or die;

JHtml::_('bootstrap.framework');

if ($field->value == '') {
	return;
}

$class = $fieldParams->get('image_class');

if ($class) {
	$class = ' class="' . htmlentities($class, ENT_COMPAT, 'UTF-8', true) . '"';
}

$value_raw = $field->value;

$value = (array) $value_raw;

if (str_contains($value_raw, '#joomlaImage:')) {
	$value = (array) substr($value_raw, 0, strpos($value_raw, '#joomlaImage:'));
}

$buffer = '';

// Include skripts/styles to the header
$document = JFactory::getDocument();
$jinput = JFactory::getApplication()->input;

if ($fieldParams->get('show_inactivefirst', 0) && !$jinput->get('aggpxtrackshow', '0')) {
	$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/js/site.js');
	echo '<a class="aggpxtrackactivate btn btn-primary">' . JText::_('PLG_AGGPXTRACK_INHALT_AKTIVIEREN') . '</a>';
} else {
	if ($fieldParams->get('show_inactivefirst', 0)) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/js/site.js');
		echo '<a class="aggpxtrackdeactivate btn btn-primary">' . JText::_('PLG_AGGPXTRACK_INHALT_DEAKTIVIEREN') . '</a>';
	}
	$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet/leaflet.css');
	$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/css/style.css');
	$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet/leaflet.js');
	$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet-gpx/gpx.js');

	$stylecolorlight = $fieldParams->get('stylecolorlight', '#cadea5');
	$stylecolordark = $fieldParams->get('stylecolordark', '#86b827');

	if ($fieldParams->get('show_elevantioncontrol', 0)) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/d3/d3.v3.min.js');
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/Leaflet.Elevation-master/leaflet.elevation-0.0.4.src.js');
		$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/Leaflet.Elevation-master/leaflet.elevation-0.0.4.css');
	}

	if ($fieldParams->get('show_fullscreencontrol', 0)) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/Leaflet.fullscreen/Leaflet.fullscreen.js');
		$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/Leaflet.fullscreen/leaflet.fullscreen.css');
	}

	if ($fieldParams->get('show_currentposition', 0)) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/L.Control.Locate/L.Control.Locate.min.js');
		$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/L.Control.Locate/L.Control.Locate.css');
	}

	if ($fieldParams->get('show_currentposition', 0) || $fieldParams->get('custom_icons', 0) || $fieldParams->get('show_omnivore', 0)) {
		$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/L.Control.Locate/font-awesome.min.css');
	}

	if ($fieldParams->get('custom_icons', 0) || $fieldParams->get('show_omnivore', 0)) {
		$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/Leaflet.awesome-markers/leaflet.awesome-markers.css');
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/Leaflet.awesome-markers/leaflet.awesome-markers.js');
	}

	if ($fieldParams->get('show_omnivore', 0)) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet-omnivore/leaflet-omnivore.js');
	}

	if ($fieldParams->get('easyprint_position', 0)) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet-easyPrint/bundle.js');
	}

	if ($fieldParams->get('show_panelLayers', 0)) {
		$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet-panel-layers/leaflet-panel-layers.min.css');
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/leaflet-panel-layers/leaflet-panel-layers.min.js');
	}

	if ($fieldParams->get('maptype', 'osm') == 'google') {
		$document->addScript('https://maps.googleapis.com/maps/api/js?key=' . $fieldParams->get('googlekey', ''));
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/GoogleMutant/Leaflet.GoogleMutant.js');
	}

	if ($fieldParams->get('addlayertree', '0') == 1) {
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/layerstree/L.Control.Layers.Tree.js');
		$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/layerstree/L.Control.Layers.Tree.css');
	}
	
	$document->addScript(JURI::root(true) . '/media/plg_fields_aggpxtrack/js/aggpxtrack.js');

	foreach ($value as $path) {
		if (!$path) {
			continue;
		}

		$unique = $field->id . '_' . uniqid();
		$path = JURI::base() . $path;
		$startIconUrl = JURI::base() . 'media/plg_fields_aggpxtrack/leaflet-gpx/pin-icon-start.png';
		$endIconUrl = JURI::base() . 'media/plg_fields_aggpxtrack/leaflet-gpx/pin-icon-end.png';
		$shadowUrl = JURI::base() . 'media/plg_fields_aggpxtrack/leaflet-gpx/pin-shadow.png';
		$wptIconUrls = JURI::base() . 'media/plg_fields_aggpxtrack/leaflet-gpx/pin-icon-wpt.png';

		$defaultArray = [];

		$skriptstring = "";
		$skriptstring .= "<div class='aggpxtrackabove' id='aggpxtrackabove" . $unique . "'></div><br>";
		$skriptstring .= "<div id='map" . $unique . "'";
		$skriptstring .= " class = 'leafletmap'";
		$skriptstring .= " style='z-index:1;height: " . $fieldParams->get('map_height', '400') . "px;'";
		$skriptstring .= " data-unique='" . $unique . "' ";
		$skriptstring .= " data-scrollwheelzoom='" . $fieldParams->get('scrollwheelzoom', '1') . "' ";
		$skriptstring .= " data-maptype='" . $fieldParams->get('maptype', 'osm') . "' ";
		$skriptstring .= " data-layertree='" . $fieldParams->get('addlayertree', '0') . "' ";

		$skriptstring .= " data-thunderforestkey='" . $fieldParams->get('thunderforestkey', '') . "' ";
		$skriptstring .= " data-thunderforestmaptype='" . $fieldParams->get('thunderforestmaptype', 'cycle') . "' ";
		$skriptstring .= " data-mapboxkey='" . $fieldParams->get('mapboxkey', '') . "' ";
		$skriptstring .= " data-geoportailfrancekey='" . $fieldParams->get('geoportailfrancekey', 'choisirgeoportail') . "' ";
		$skriptstring .= " data-googlekey='" . $fieldParams->get('googlekey', '') . "' ";
		$skriptstring .= " data-googlemapstype='" . $fieldParams->get('googlemapstype', 'satellite') . "' ";

		$skriptstring .= " data-show_omnivore='" . $fieldParams->get('show_omnivore', 0) . "' ";
		if ($fieldParams->get('show_omnivore', 0)) {
			$skriptstring .= " data-omnivore_icon='" . $fieldParams->get('omnivore_icon', 'home') . "' ";
			$skriptstring .= " data-omnivore_markercolor='" . $fieldParams->get('omnivore_markercolor', 'red') . "' ";
			$skriptstring .= " data-omnivore_iconcolor='" . $fieldParams->get('omnivore_iconcolor', '#ffffff') . "' ";
			$skriptstring .= " data-omnivore_spin='" . $fieldParams->get('omnivore_spin', 'false') . "' ";
			$skriptstring .= " data-omnivore_extraclasses='" . $fieldParams->get('omnivore_extraclasses', '') . "' ";
			$skriptstring .= " data-omnivore_file='" . JURI::base() . "images/com_aggpxtrack/" . $fieldParams->get('omnivore_file', '') . "' ";
		}

		$skriptstring .= " data-show_fullscreencontrol='" . $fieldParams->get('show_fullscreencontrol', 0) . "' ";
		if ($fieldParams->get('show_fullscreencontrol', 0)) {
			$skriptstring .= " data-fullscreencontrol_viewfullscreen='" . JText::_('PLG_AGGPXTRACK_VIEW_FULLSCREEN') . "' ";
			$skriptstring .= " data-fullscreencontrol_exitfullscreen='" . JText::_('PLG_AGGPXTRACK_EXIT_FULLSCREEN') . "' ";
			$skriptstring .= " data-fullscreencontrol_position='" . $fieldParams->get('fullscreencontrol_position', 'topleft') . "' ";
		}

		$skriptstring .= " data-show_easyprint='" . $fieldParams->get('show_easyprint', 0) . "' ";
		$skriptstring .= " data-easyprint_position='" . $fieldParams->get('easyprint_position', 'topleft') . "' ";
		$skriptstring .= " data-gpx_file_name='" . $path . "' ";
		$skriptstring .= " data-startIconUrl='" . $startIconUrl . "' ";
		$skriptstring .= " data-endIconUrl='" . $endIconUrl . "' ";
		$skriptstring .= " data-shadowUrl='" . $shadowUrl . "' ";
		$skriptstring .= " data-wptIconUrls='" . $wptIconUrls . "' ";
		$skriptstring .= " data-custom_icons='" . $fieldParams->get('custom_icons', 0) . "' ";
		$skriptstring .= " data-customiconstart_icon='" . $fieldParams->get('customiconstart_icon', 'home') . "' ";
		$skriptstring .= " data-customiconstart_markercolor='" . $fieldParams->get('customiconstart_markercolor', 'red') . "' ";
		$skriptstring .= " data-customiconstart_iconcolor='" . $fieldParams->get('customiconstart_iconcolor', '#ffffff') . "' ";
		$skriptstring .= " data-customiconstart_spin='" . $fieldParams->get('customiconstart_spin', 'false') . "' ";
		$skriptstring .= " data-customiconstart_extraclasses='" . $fieldParams->get('customiconstart_extraclasses', ' ') . "' ";
		$skriptstring .= " data-customiconend_icon='" . $fieldParams->get('customiconend_icon', 'home') . "' ";
		$skriptstring .= " data-customiconend_markercolor='" . $fieldParams->get('customiconend_markercolor', 'red') . "' ";
		$skriptstring .= " data-customiconend_iconcolor='" . $fieldParams->get('customiconend_iconcolor', '#ffffff') . "' ";
		$skriptstring .= " data-customiconend_spin='" . $fieldParams->get('customiconend_spin', 'false') . "' ";
		$skriptstring .= " data-customiconend_extraclasses='" . $fieldParams->get('customiconend_extraclasses', ' ') . "' ";
		$skriptstring .= " data-customiconwaypoint_icon='" . $fieldParams->get('customiconwaypoint_icon', 'home') . "' ";
		$skriptstring .= " data-customiconwaypoint_markercolor='" . $fieldParams->get('customiconwaypoint_markercolor', 'red') . "' ";
		$skriptstring .= " data-customiconwaypoint_iconcolor='" . $fieldParams->get('customiconwaypoint_iconcolor', '#ffffff') . "' ";
		$skriptstring .= " data-customiconwaypoint_spin='" . $fieldParams->get('customiconwaypoint_spin', 'false') . "' ";
		$skriptstring .= " data-customiconwaypoint_extraclasses='" . $fieldParams->get('customiconwaypoint_extraclasses', ' ') . "' ";
		$skriptstring .= " data-specialwaypoints='" . json_encode($fieldParams->get('specialwaypoints', null)) . "' ";
		$skriptstring .= " data-polylinecolor='" . $fieldParams->get('polylinecolor', '#0000ff') . "' ";
		$skriptstring .= " data-showelements='" . $fieldParams->get('showelements', 'track,route,waypoint') . "' ";
		$skriptstring .= " data-show_kilometer_points='" . $fieldParams->get('show_kilometer_points', 0) . "' ";
		$skriptstring .= " data-kilometer_point_color='" . $fieldParams->get('kilometer_point_color', '#0000ff') . "' ";
		$skriptstring .= " data-kilometer_point_color_text='" . $fieldParams->get('kilometer_point_color_text', '#ffffff') . "' ";
		$skriptstring .= " data-kilometer_point_intervall='" . $fieldParams->get('kilometer_point_intervall', '1') . "' ";
		$skriptstring .= " data-kilometer_point_radius='" . $fieldParams->get('kilometer_point_radius', '10') . "' ";
		$skriptstring .= " data-show_currentposition='" . $fieldParams->get('show_currentposition', 0) . "' ";
		$skriptstring .= " data-currentposition_position='" . $fieldParams->get('currentposition_position', 'topleft') . "' ";
		$skriptstring .= " data-currentposition_initialZoomLevel='" . $fieldParams->get('currentposition_initialZoomLevel', '17') . "' ";

		if (null !== $fieldParams->get('scale')) {
			$skriptstring .= " data-scale='" . count($fieldParams->get('scale')) . "' ";
		}

		$skriptstring .= " data-scale-metric='" . in_array('metric', $fieldParams->get('scale', $defaultArray)) . "' ";
		$skriptstring .= " data-scale-imperial='" . in_array('imperial', $fieldParams->get('scale', $defaultArray)) . "' ";

		$skriptstring .= " data-show_elevantioncontrol='" . $fieldParams->get('show_elevantioncontrol', 0) . "' ";
		if ($fieldParams->get('show_elevantioncontrol', 0)) {
			$skriptstring .= " data-elevantioncontrol_collapsed='" . $fieldParams->get('elevantioncontrol_collapsed', false) . "' ";
			$skriptstring .= " data-elevantioncontrol_top='" . $fieldParams->get('elevantioncontrol_top', '10') . "' ";
			$skriptstring .= " data-elevantioncontrol_right='" . $fieldParams->get('elevantioncontrol_right', '20') . "' ";
			$skriptstring .= " data-elevantioncontrol_bottom='" . $fieldParams->get('elevantioncontrol_bottom', '30') . "' ";
			$skriptstring .= " data-elevantioncontrol_left='" . $fieldParams->get('elevantioncontrol_left', '50') . "' ";
			$skriptstring .= " data-elevantioncontrol_position='" . $fieldParams->get('elevantioncontrol_position', 'topright') . "' ";
			$skriptstring .= " data-elevantioncontrol_theme='" . $fieldParams->get('elevantioncontrol_theme', 'elevation-lime') . "' ";
			$skriptstring .= " data-elevantioncontrol_width='" . $fieldParams->get('elevantioncontrol_width', '600') . "' ";
			$skriptstring .= " data-elevantioncontrol_height='" . $fieldParams->get('elevantioncontrol_height', '125') . "' ";
		}

		$skriptstring .= " data-show_panelLayers='" . $fieldParams->get('show_panelLayers', 0) . "' ";
		if ($fieldParams->get('show_panelLayers', 0)) {
			$skriptstring .= " data-panelLayers='" . htmlspecialchars(json_encode($fieldParams->get('panelLayers', null)), ENT_QUOTES, 'UTF-8') . "' ";
		}

		$skriptstring .= " %s>";
		$skriptstring .= "</div>";
		$skriptstring .= "<div class='aggpxtrackunder' id='aggpxtrackunder" . $unique . "'></div>";

		JText::script('PLG_AGGPXTRACK_CURRENTPOSITION_STRING');

		$buffer .= sprintf(
			$skriptstring,
			$class,
			htmlentities($path, ENT_COMPAT, 'UTF-8', true),
			htmlentities($startIconUrl, ENT_COMPAT, 'UTF-8', true),
			htmlentities($endIconUrl, ENT_COMPAT, 'UTF-8', true),
			htmlentities($shadowUrl, ENT_COMPAT, 'UTF-8', true),
			htmlentities($wptIconUrls, ENT_COMPAT, 'UTF-8', true)
		);

		$buttonstyle = '';
		if ($fieldParams->get('show_downloadlink', 0) == 'text') {
			$buffer .= '<p class="agbutton_p' . $unique . '"><span>' . JText::_('PLG_AGGPXTRACK_DOWNLOAD_LABEL') . '</span>'
				. '<a href="' . $path . '" download>' . JText::_('PLG_AGGPXTRACK_DOWNLOAD_LINKTEXT') . '</a></p>';
			$buttonstyle .= '.agbutton_p' . $unique . ' {';
			$buttonstyle .= 'margin: 2%;';
			$buttonstyle .= '}';
			$document->addStyleDeclaration($buttonstyle);
		}
		if ($fieldParams->get('show_downloadlink', 0) == 'button') {
			$buffer .= '<p class="agbutton_p' . $unique . '"><a class="agbutton' . $unique . '" '
				. 'href="' . $path . '" '
				. 'download>'
				. JText::_('PLG_AGGPXTRACK_DOWNLOAD_LABEL')
				. ' '
				. JText::_('PLG_AGGPXTRACK_DOWNLOAD_LINKTEXT')
				. '</a></p>';

			$downloadbuttoncolor = $fieldParams->get('downloadbuttoncolor', '#cadea5');
			$buttonstyle .= '.agbutton' . $unique . ' {';
			$buttonstyle .= 'text-decoration: none;';
			$buttonstyle .= 'background-color: ' . $downloadbuttoncolor . ';';
			$buttonstyle .= 'color: #333333;';
			$buttonstyle .= 'padding: 2%;';
			$buttonstyle .= 'border-top: 1px solid #CCCCCC;';
			$buttonstyle .= 'border-right: 1px solid #333333;';
			$buttonstyle .= 'border-bottom: 1px solid #333333;';
			$buttonstyle .= 'border-left: 1px solid #CCCCCC;';
			$buttonstyle .= '}';
			$buttonstyle .= '.agbutton_p' . $unique . ' {';
			$buttonstyle .= 'margin: 4% 2%;';
			$buttonstyle .= '}';
			$document->addStyleDeclaration($buttonstyle);
		}

		$buffer_info = '';

		if ($fieldParams->get('showinfo', 'no') != 'no') {
			$buffer_info = '<div class="gpx_info" id="gpx_info_' . $unique . '">';
			$buffer_info .= '<table class="gpx_info_table">';

			$infovalues = [
				"distance",
				"name",
				"start_time",
				"end_time",
				"moving_time",
				"total_time",
				"moving_pace",
				"moving_speed",
				"total_speed",
				"elevation_min",
				"elevation_max",
				"elevation_loss",
				"elevation_gain",
				"average_hr",
				"average_cadence",
				"average_temp"
			];

			foreach ($infovalues as $value) {
				if ($fieldParams->get('show_' . $value, 0)) {
					$buffer_info .= ''
						. '<tr>'
						. '<td>'
						. '<span class="' . $value . '_name" id="' . $value . '_name' . $unique . '">' . JText::_('PLG_AGGPXTRACK_' . $value . '_NAME') . '</span>'
						. '</td>'
						. '<td>'
						. '<span class="' . $value . '_value" id="' . $value . '_value' . $unique . '"></span>'
						. '<span class="' . $value . '_unit" id="' . $value . '_unit' . $unique . '">' . JText::_('PLG_AGGPXTRACK_' . $value . '_UNIT') . '</span>'
						. '</td>'
						. '</tr>';
				}
			}

			$buffer_info .= '</table>';
			$buffer_info .= '</div>';
		}

		$style = '';

		if ($fieldParams->get('infostyle', 'style') == 'style_1') {
			$style = '#gpx_info_' . $unique . ' tr:nth-child(even) td {';
			$style .= 'background: ' . $stylecolorlight . ';';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' td, #gpx_info_' . $unique . ' th {';
			$style .= 'border: 1px solid' . $stylecolordark . ';';
			$style .= 'padding:1%;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' {';
			$style .= 'margin: 1% 0;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' td, #gpx_info_' . $unique . ' th {';
			$style .= 'padding:1%;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table {';
			$style .= 'border-collapse: collapse;';
			$style .= 'border-spacing: 0;';
			$style .= 'min-width:100%;';
			$style .= 'max-width:100%;';
			$style .= '}';
		}

		if ($fieldParams->get('infostyle', 'style') == 'style_2') {
			$style = '#gpx_info_' . $unique . ' table tbody tr {';
			$style .= 'border-top: 2px solid ' . $stylecolordark . ';';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody td:first-child {';
			$style .= 'background: ' . $stylecolorlight . ';';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' {';
			$style .= 'margin: 1% 0;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table th, #gpx_info_' . $unique . ' table td {';
			$style .= 'text-align: center;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody {';
			$style .= 'font-size: 1em;';
			$style .= 'line-height: 15px;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody tr {';
			$style .= 'transition: background 0.6s, color 0.6s;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody tr:nth-child(even) {';
			$style .= 'background: rgba(255, 255, 255, 0.2);';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody tr:hover {';
			$style .= 'color: #000;';
			$style .= 'background: rgba(255, 255, 255, 0.7);';
			$style .= 'font-weight: 900;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody td {';
			$style .= 'padding: 12px;';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody tr:hover td:first-child {';
			$style .= 'background: rgba(0,0,0,0);';
			$style .= '}';
			$style .= '#gpx_info_' . $unique . ' table tbody td:first-child {';
			$style .= 'text-align: left;';
			$style .= 'padding-left: 20px;';
			$style .= 'font-weight: 700;';
			$style .= 'transition: background 0.6s;';
			$style .= '}';
		}
		$document->addStyleDeclaration($style);
	}

	if ($fieldParams->get('showinfo', 'no') == 'before') {
		echo $buffer_info . $buffer;
	} else if ($fieldParams->get('showinfo', 'no') == 'after') {
		echo $buffer . $buffer_info;
	} else {
		echo $buffer;
	}
}
