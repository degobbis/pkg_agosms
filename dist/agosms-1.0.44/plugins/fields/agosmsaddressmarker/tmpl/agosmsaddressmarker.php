<?php
/**
 * @package     Joomla.Site
 * @subpackage  pkg_agosms
 *
 * @copyright   Copyright (C) 2005 - 2019 Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */

defined('_JEXEC') or die;

$value = $field->value;

$document = JFactory::getDocument();

$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/leaflet/leaflet.css');
$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/leaflet/leaflet.js');
$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/js/site-agosmsaddressmarker.js');

if ($fieldParams->get('scrollwheelzoom') === "2")
{
	$document->addStyleSheet(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/GoogleGestureHandling/leaflet-gesture-handling.min.css');
	$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/GoogleGestureHandling/leaflet-gesture-handling.min.js');
}

if ($fieldParams->get('maptype') === "mapbox")
{
	$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/js/site-agosmsaddressmarker-mapbox.js');
}
elseif ($fieldParams->get('maptype') === "google")
{
	$document->addScript('https://maps.googleapis.com/maps/api/js?key=' . $fieldParams->get('googlekey', ''));
	$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/GoogleMutant/Leaflet.GoogleMutant.js');
	$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/js/site-agosmsaddressmarker-google.js');
}
else
{
	$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/js/site-agosmsaddressmarker-openstreetmap.js');
}
$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/js/site-agosmsaddressmarker.js');

// We need this for list views
$unique = $field->id . '_' . uniqid();

if ($value == '')
{
	return;
}

$values = explode(',', $value);

// ToDo Prüfe ob genau zwei werte und ob koordinate
$lat = $values[0];
$lon = $values[1];
?>

<div
	<?php 
	if ( $lat == 0 && $lon == 0) echo 'style="display:none"' 
	?>
	id="map<?php echo $unique ?>"
	class = 'agosmsaddressmarkerleafletmap' 
	style="height: <?php echo $fieldParams->get('map_height', '400') ?>px;"
	data-unique='<?php echo $unique ?>'
	data-lat='<?php echo $lat ?>'
	data-lon='<?php echo $lon ?>'
	data-mapboxkey='<?php echo $fieldParams->get('mapboxkey', '') ?>'
	data-scrollwheelzoom='<?php echo $fieldParams->get('scrollwheelzoom', '1') ?>'
	data-owngooglegesturetext='<?php echo $fieldParams->get('owngooglegesturetext', '1') ?>'
	data-scroll='<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_SCROLL'); ?>'
	data-touch='<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_TOUCH'); ?>'
	data-scrollmac='<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_SCROLLMAC'); ?>'
>
</div>
