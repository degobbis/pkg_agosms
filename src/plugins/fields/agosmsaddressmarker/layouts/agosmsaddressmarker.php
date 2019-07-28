<?php
/**
 * @package     Joomla.Site
 * @subpackage  pkg_agosms
 *
 * @copyright   Copyright (C) 2005 - 2019 Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */
defined('JPATH_BASE') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   string   $accept          File types that are accepted.
 */
// Including fallback code for HTML5 non supported browsers.
JHtml::_('jquery.framework');
JHtml::_('script', 'system/html5fallback.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

$showspecialicon = "display:none";
if ($specialicon)
{
	$showspecialicon = "";
}

$showpopup = "display:none";
if ($popup)
{
	$showpopup = "";
}

$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . '/media/plg_fields_agosmsaddressmarker/leaflet/leaflet.js');
JHtml::_('script', 'plg_fields_agosmsaddressmarker/admin-agosmsaddressmarker.js', array('version' => 'auto', 'relative' => true));

if ($geocoder === "mapbox")
{
	JHtml::_('script', 'plg_fields_agosmsaddressmarker/agosmsaddressmarkerMapbox.js', array('version' => 'auto', 'relative' => true));
} elseif ($geocoder === "google")
{
	JHtml::_('script', 'plg_fields_agosmsaddressmarker/agosmsaddressmarkerGoogle.js', array('version' => 'auto', 'relative' => true));
} else
{
	JHtml::_('script', 'plg_fields_agosmsaddressmarker/agosmsaddressmarkerNominatim.js', array('version' => 'auto', 'relative' => true));
}

JHtml::_('stylesheet', 'plg_fields_agosmsaddressmarker/agosmsaddressmarker.css', array('version' => 'auto', 'relative' => true));

JText::script('PLG_AGOSMSADDRESSMARKER_ADDRESSE_ERROR');
JText::script('PLG_AGOSMSADDRESSMARKER_ADDRESSE_NOTICE');

$attributes = array(
	!empty($class) ? 'class="' . $class . '"' : '',
	!empty($size) ? 'size="' . $size . '"' : '',
	$disabled ? 'disabled' : '',
	$readonly ? 'readonly' : '',
	strlen($hint) ? 'placeholder="' . htmlspecialchars($hint, ENT_COMPAT, 'UTF-8') . '"' : '',
	$onchange ? ' onchange="' . $onchange . '"' : '',
	!empty($maxLength) ? $maxLength : '',
	$required ? 'required aria-required="true"' : '',
	$autocomplete,
	$autofocus ? ' autofocus' : '',
	$spellcheck ? '' : 'spellcheck="false"',
	!empty($inputmode) ? $inputmode : '',
	!empty($pattern) ? 'pattern="' . $pattern . '"' : '',
);

// Define defaults
$app = JFactory::getApplication();
$context = 'com_content.article';

// Com_categorie
if ($app->input->getCmd('option') === 'com_categories')
{
	$context = $app->input->getCmd('extension') . '.categories';
}

// Com_users
elseif ($app->input->getCmd('option') === 'com_users')
{
	$context = 'com_users.user';
} 

// Com_contact
elseif ($app->input->getCmd('option') === 'com_contact')
{
	//JFactory::getApplication()->enqueueMessage(JText::_('PLG_AGOSMSADDRESSMARKER_SUPPORTET'), 'message');
	$context = 'com_contact.contact';
} 

// Third Party
elseif ($app->input->getCmd('option') !== 'com_users' 
	&& $app->input->getCmd('option') !== 'com_content'
	&& $app->input->getCmd('option') !== 'com_categories'
	&& $app->input->getCmd('option') !== 'com_contact')
{
	$context = $app->input->getCmd('option') . '.' . $app->input->getCmd('view');
}	


// Load fields with prepared values
$fields = FieldsHelper::getFields($context);

$addressfieldsvalues = array();
$addressfieldsArray = json_decode($addressfields);

if (!empty($addressfieldsArray))
{
	foreach ($addressfieldsArray as $a) {
		$addressfieldsvalues[] = $a->value;
	}
}

// Build the string with the field names from the selected fields 
$fieldnames = "";
$fieldsNameArray = array();

if (!empty($fields))
{
	foreach ($fields as $field) {
		// Save value to fieldnames, if field is in the options of this custom field
		if (in_array($field->id, $addressfieldsvalues))
		{
			$fieldsNameArray[] = 'jform' . '_com_fields_' . str_replace('-', '_', $field->name);
			$fieldnames .= $field->label . ', ';
		}
	}
}

$fieldsNameImplode = implode(',', $fieldsNameArray);

?>

<hr>
<div class="agosmsaddressmarkersurroundingdiv form-horizontal">

<div class="control-group">
<label class="control-label"><?php echo JText::_('PLG_AGOSMSADDRESSMARKER_LAT'); ?></label>	
<div class="controls">
	<input type="text" class="agosmsaddressmarkerlat" >
</div>
</div>

<div class="control-group">
<label class="control-label"><?php echo JText::_('PLG_AGOSMSADDRESSMARKER_LON'); ?></label>	
<div class="controls">	
<input type="text" class="agosmsaddressmarkerlon" >
</div>
</div>
	
<button 
		data-fieldsnamearray="<?php echo $fieldsNameImplode; ?>"
		data-mapboxkey="<?php echo $mapboxkey; ?>"
		data-googlekey="<?php echo $googlekey; ?>"
		class="btn btn-success agosmsaddressmarkerbutton" 
		type="button">
<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_CALCULATE_CORDS'); ?>
	</button>

<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_HINT'); ?>
<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_USED_FIELDS'); ?>
<?php echo $fieldnames; ?>
	
<hr>
<h4><?php echo JText::_('PLG_AGOSMSADDRESSMARKER_HEADING_OPTIONAL_VALUES'); ?></h4>

<div style="<?php echo $showspecialicon; ?>">
<div class="control-group">
<label class="control-label"><?php echo JText::_('Iconcolor'); ?></label>	
<div class="controls">
<select 
	class="agosmsaddressmarkericoncolor">
	<option></option>
	<option value="red">red</option>
	<option value="darkred">darkred</option>
	<option value="orange">orange</option>
	<option value="green">green</option>
	<option value="darkgreen">darkgreen</option>
	<option value="blue">blue</option>
	<option value="purple">purple</option>
	<option value="darkpurple">darkpurple</option>
	<option value="cadetblue">cadetblue</option>
	<option value="#FFFFFF">white</option>
	<option value="#000000">black</option>
</select>
</div>
</div>

<div class="control-group">
<label class="control-label"><?php echo JText::_('Markercolor'); ?></label>	
<div class="controls">
<select 
	class="agosmsaddressmarkercolor">
	<option></option>
	<option value="red">red</option>
	<option value="darkred">darkred</option>
	<option value="orange">orange</option>
	<option value="green">green</option>
	<option value="darkgreen">darkgreen</option>
	<option value="blue">blue</option>
	<option value="purple">purple</option>
	<option value="darkpurple">darkpurple</option>
	<option value="cadetblue">cadetblue</option>
</select>
</div>
</div>

<div class="control-group">
<label class="control-label"><?php echo JText::_('Icon'); ?></label>	
<div class="controls">
<select 
class="agosmsmarkericon">
<option></option>	
<option value="circle">circle &#xf111;</option>
<option value="">noicon</option>
<option value="home">home &#xf015;</option>
<option value="star">star &#xf005;</option>
<option value="500px">&#xf26e;</option>
<option value="address-book">&#xf2b9;</option>
<option value="address-book">&#xf2b9;</option>
<option value="address-book-o">&#xf2ba;</option>
<option value="address-card">&#xf2bb;</option>
<option value="address-card-o">&#xf2bc;</option>
<option value="yelp">&#xf1e9;</option>
<option value="yen">&#xf157;</option>
<option value="yoast">&#xf2b1;</option>
<option value="youtube">&#xf167;</option>
<option value="youtube-play">&#xf16a;</option>
<option value="youtube-square">&#xf166;</option></select>
</div>
</div>
</div>

<div style="<?php echo $showpopup; ?>">
<div class="control-group">
<label class="control-label"><?php echo JText::_('Popuptext'); ?></label>	
<div class="controls">	
<input type="text" id="agosmsmarkerpopuptext">
</div>
</div>
</div>

<p>
<?php echo JText::_('PLG_AGOSMSADDRESSMARKER_OPTIONAL_HINT'); ?>	
</p>

<input 
	class="agosmsaddressmarkerhiddenfield" 
	type="hidden" 
	readonly name="<?php echo $name; ?>" id="<?php echo $id; ?>" 
	value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>" <?php echo implode(' ', $attributes); ?> 
/>
</div>
<hr>