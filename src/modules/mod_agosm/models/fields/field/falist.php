<?php
/**
 * @package     Joomla.Site
 * @subpackage  pkg_agosm
 *
 * @copyright   Copyright (C) 2005 - 2018 Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a generic list of options.
 *
 * @since  1.0.76
 */
class JFormFieldFalist extends JFormField
	{

	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.0.76
	 */
	protected $type = 'List';

	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.0.76
	 */
	protected function getInput()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root(true) . '/media/mod_agosm/css/font-awesome.min.css');
		$style = '.chzn-container {
			font-family: \'FontAwesome\';
			}';
		$document->addStyleDeclaration($style);

		$html = array();
		$attr = '';

		// Initialize some field attributes.
		$attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required aria-required="true"' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';
		$attr .= ' style="font-family: \'FontAwesome\';" ';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true' || (string) $this->disabled == '1' || (string) $this->disabled == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		// Initialize JavaScript field attributes.
		$attr .= $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

		// Get the field options.
		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with hidden input(s) to store the value(s).
		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true')
		{
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);

			// E.g. form field type tag sends $this->value as array
			if ($this->multiple && is_array($this->value))
			{
				if (!count($this->value))
				{
					$this->value[] = '';
				}

				foreach ($this->value as $value)
				{
					$html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '"/>';
				}
			} else
			{
				$html[] = '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"/>';
			}
		} else
		// Create a regular list.
		{
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}

		return implode($html);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   1.0.76
	 */
	protected function getOptions()
	{
		$fieldname = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname);
		$options = array();

		$fontawesome_icons = [
			"home" => "&#xf015;",
			"500px" => "&#xf26e;",
			"address-book" => "&#xf2b9;",
			"500px" => "&#xf26e;",
			"address-book" => "&#xf2b9;",
			"address-book-o" => "&#xf2ba;",
			"address-card" => "&#xf2bb;",
			"address-card-o" => "&#xf2bc;",
			"adjust" => "&#xf042;",
			"adn" => "&#xf170;",
			"align-center" => "&#xf037;",
			"align-justify" => "&#xf039;",
			"align-left" => "&#xf036;",
			"align-right" => "&#xf038;",
			"amazon" => "&#xf270;",
			"ambulance" => "&#xf0f9;",
			"american-sign-language-interpreting" => "&#xf2a3;",
			"anchor" => "&#xf13d;",
			"android" => "&#xf17b;",
			"angellist" => "&#xf209;",
			"angle-double-down" => "&#xf103;",
			"angle-double-left" => "&#xf100;",
			"angle-double-right" => "&#xf101;",
			"angle-double-up" => "&#xf102;",
			"angle-down" => "&#xf107;",
			"angle-left" => "&#xf104;",
			"angle-right" => "&#xf105;",
			"angle-up" => "&#xf106;",
			"apple" => "&#xf179;",
			"archive" => "&#xf187;",
			"area-chart" => "&#xf1fe;",
			"arrow-circle-down" => "&#xf0ab;",
			"arrow-circle-left" => "&#xf0a8;",
			"arrow-circle-o-down" => "&#xf01a;",
			"arrow-circle-o-left" => "&#xf190;",
			"arrow-circle-o-right" => "&#xf18e;",
			"arrow-circle-o-up" => "&#xf01b;",
			"arrow-circle-right" => "&#xf0a9;",
			"arrow-circle-up" => "&#xf0aa;",
			"arrow-down" => "&#xf063;",
			"arrow-left" => "&#xf060;",
			"arrow-right" => "&#xf061;",
			"arrow-up" => "&#xf062;",
			"arrows" => "&#xf047;",
			"arrows-alt" => "&#xf0b2;",
			"arrows-h" => "&#xf07e;",
			"arrows-v" => "&#xf07d;",
			"asl-interpreting" => "&#xf2a3;",
			"assistive-listening-systems" => "&#xf2a2;",
			"asterisk" => "&#xf069;",
			"at" => "&#xf1fa;",
			"audio-description" => "&#xf29e;",
			"automobile" => "&#xf1b9;",
			"backward" => "&#xf04a;",
			"balance-scale" => "&#xf24e;",
			"ban" => "&#xf05e;",
			"bandcamp" => "&#xf2d5;",
			"bank" => "&#xf19c;",
			"bar-chart" => "&#xf080;",
			"bar-chart-o" => "&#xf080;",
			"barcode" => "&#xf02a;",
			"bars" => "&#xf0c9;",
			"bath" => "&#xf2cd;",
			"bathtub" => "&#xf2cd;",
			"battery" => "&#xf240;",
			"battery-0" => "&#xf244;",
			"battery-1" => "&#xf243;",
			"battery-2" => "&#xf242;",
			"battery-3" => "&#xf241;",
			"battery-4" => "&#xf240;",
			"battery-empty" => "&#xf244;",
			"battery-full" => "&#xf240;",
			"battery-half" => "&#xf242;",
			"battery-quarter" => "&#xf243;",
			"battery-three-quarters" => "&#xf241;",
			"bed" => "&#xf236;",
			"beer" => "&#xf0fc;",
			"behance" => "&#xf1b4;",
			"behance-square" => "&#xf1b5;",
			"bell" => "&#xf0f3;",
			"bell-o" => "&#xf0a2;",
			"bell-slash" => "&#xf1f6;",
			"bell-slash-o" => "&#xf1f7;",
			"bicycle" => "&#xf206;",
			"binoculars" => "&#xf1e5;",
			"birthday-cake" => "&#xf1fd;",
			"bitbucket" => "&#xf171;",
			"bitbucket-square" => "&#xf172;",
			"bitcoin" => "&#xf15a;",
			"black-tie" => "&#xf27e;",
			"blind" => "&#xf29d;",
			"bluetooth" => "&#xf293;",
			"bluetooth-b" => "&#xf294;",
			"bold" => "&#xf032;",
			"bolt" => "&#xf0e7;",
			"bomb" => "&#xf1e2;",
			"book" => "&#xf02d;",
			"bookmark" => "&#xf02e;",
			"bookmark-o" => "&#xf097;",
			"braille" => "&#xf2a1;",
			"briefcase" => "&#xf0b1;",
			"btc" => "&#xf15a;",
			"bug" => "&#xf188;",
			"building" => "&#xf1ad;",
			"building-o" => "&#xf0f7;",
			"bullhorn" => "&#xf0a1;",
			"bullseye" => "&#xf140;",
			"bus" => "&#xf207;",
			"buysellads" => "&#xf20d;",
			"cab" => "&#xf1ba;",
			"calculator" => "&#xf1ec;",
			"calendar" => "&#xf073;",
			"calendar-check-o" => "&#xf274;",
			"calendar-minus-o" => "&#xf272;",
			"calendar-o" => "&#xf133;",
			"calendar-plus-o" => "&#xf271;",
			"calendar-times-o" => "&#xf273;",
			"camera" => "&#xf030;",
			"camera-retro" => "&#xf083;",
			"car" => "&#xf1b9;",
			"caret-down" => "&#xf0d7;",
			"caret-left" => "&#xf0d9;",
			"caret-right" => "&#xf0da;",
			"caret-square-o-down" => "&#xf150;",
			"caret-square-o-left" => "&#xf191;",
			"caret-square-o-right" => "&#xf152;",
			"caret-square-o-up" => "&#xf151;",
			"caret-up" => "&#xf0d8;",
			"cart-arrow-down" => "&#xf218;",
			"cart-plus" => "&#xf217;",
			"cc" => "&#xf20a;",
			"cc-amex" => "&#xf1f3;",
			"cc-diners-club" => "&#xf24c;",
			"cc-discover" => "&#xf1f2;",
			"cc-jcb" => "&#xf24b;",
			"cc-mastercard" => "&#xf1f1;",
			"cc-paypal" => "&#xf1f4;",
			"cc-stripe" => "&#xf1f5;",
			"cc-visa" => "&#xf1f0;",
			"certificate" => "&#xf0a3;",
			"chain" => "&#xf0c1;",
			"chain-broken" => "&#xf127;",
			"check" => "&#xf00c;",
			"check-circle" => "&#xf058;",
			"check-circle-o" => "&#xf05d;",
			"check-square" => "&#xf14a;",
			"check-square-o" => "&#xf046;",
			"chevron-circle-down" => "&#xf13a;",
			"chevron-circle-left" => "&#xf137;",
			"chevron-circle-right" => "&#xf138;",
			"chevron-circle-up" => "&#xf139;",
			"chevron-down" => "&#xf078;",
			"chevron-left" => "&#xf053;",
			"chevron-right" => "&#xf054;",
			"chevron-up" => "&#xf077;",
			"child" => "&#xf1ae;",
			"chrome" => "&#xf268;",
			"circle" => "&#xf111;",
			"circle-o" => "&#xf10c;",
			"circle-o-notch" => "&#xf1ce;",
			"circle-thin" => "&#xf1db;",
			"clipboard" => "&#xf0ea;",
			"clock-o" => "&#xf017;",
			"clone" => "&#xf24d;",
			"close" => "&#xf00d;",
			"cloud" => "&#xf0c2;",
			"cloud-download" => "&#xf0ed;",
			"cloud-upload" => "&#xf0ee;",
			"cny" => "&#xf157;",
			"code" => "&#xf121;",
			"code-fork" => "&#xf126;",
			"codepen" => "&#xf1cb;",
			"codiepie" => "&#xf284;",
			"coffee" => "&#xf0f4;",
			"cog" => "&#xf013;",
			"cogs" => "&#xf085;",
			"columns" => "&#xf0db;",
			"comment" => "&#xf075;",
			"comment-o" => "&#xf0e5;",
			"commenting" => "&#xf27a;",
			"commenting-o" => "&#xf27b;",
			"comments" => "&#xf086;",
			"comments-o" => "&#xf0e6;",
			"compass" => "&#xf14e;",
			"compress" => "&#xf066;",
			"connectdevelop" => "&#xf20e;",
			"contao" => "&#xf26d;",
			"copy" => "&#xf0c5;",
			"copyright" => "&#xf1f9;",
			"creative-commons" => "&#xf25e;",
			"credit-card" => "&#xf09d;",
			"credit-card-alt" => "&#xf283;",
			"crop" => "&#xf125;",
			"crosshairs" => "&#xf05b;",
			"css3" => "&#xf13c;",
			"cube" => "&#xf1b2;",
			"cubes" => "&#xf1b3;",
			"cut" => "&#xf0c4;",
			"cutlery" => "&#xf0f5;",
			"dashboard" => "&#xf0e4;",
			"dashcube" => "&#xf210;",
			"database" => "&#xf1c0;",
			"deaf" => "&#xf2a4;",
			"deafness" => "&#xf2a4;",
			"dedent" => "&#xf03b;",
			"delicious" => "&#xf1a5;",
			"desktop" => "&#xf108;",
			"deviantart" => "&#xf1bd;",
			"diamond" => "&#xf219;",
			"digg" => "&#xf1a6;",
			"dollar" => "&#xf155;",
			"dot-circle-o" => "&#xf192;",
			"download" => "&#xf019;",
			"dribbble" => "&#xf17d;",
			"drivers-license" => "&#xf2c2;",
			"drivers-license-o" => "&#xf2c3;",
			"dropbox" => "&#xf16b;",
			"drupal" => "&#xf1a9;",
			"edge" => "&#xf282;",
			"edit" => "&#xf044;",
			"eercast" => "&#xf2da;",
			"eject" => "&#xf052;",
			"ellipsis-h" => "&#xf141;",
			"ellipsis-v" => "&#xf142;",
			"empire" => "&#xf1d1;",
			"envelope" => "&#xf0e0;",
			"envelope-o" => "&#xf003;",
			"envelope-open" => "&#xf2b6;",
			"envelope-open-o" => "&#xf2b7;",
			"envelope-square" => "&#xf199;",
			"envira" => "&#xf299;",
			"eraser" => "&#xf12d;",
			"etsy" => "&#xf2d7;",
			"eur" => "&#xf153;",
			"euro" => "&#xf153;",
			"exchange" => "&#xf0ec;",
			"exclamation" => "&#xf12a;",
			"exclamation-circle" => "&#xf06a;",
			"exclamation-triangle" => "&#xf071;",
			"expand" => "&#xf065;",
			"expeditedssl" => "&#xf23e;",
			"external-link" => "&#xf08e;",
			"external-link-square" => "&#xf14c;",
			"eye" => "&#xf06e;",
			"eye-slash" => "&#xf070;",
			"eyedropper" => "&#xf1fb;",
			"fa" => "&#xf2b4;",
			"facebook" => "&#xf09a;",
			"facebook-f" => "&#xf09a;",
			"facebook-official" => "&#xf230;",
			"facebook-square" => "&#xf082;",
			"fast-backward" => "&#xf049;",
			"fast-forward" => "&#xf050;",
			"fax" => "&#xf1ac;",
			"feed" => "&#xf09e;",
			"female" => "&#xf182;",
			"fighter-jet" => "&#xf0fb;",
			"file" => "&#xf15b;",
			"file-archive-o" => "&#xf1c6;",
			"file-audio-o" => "&#xf1c7;",
			"file-code-o" => "&#xf1c9;",
			"file-excel-o" => "&#xf1c3;",
			"file-image-o" => "&#xf1c5;",
			"file-movie-o" => "&#xf1c8;",
			"file-o" => "&#xf016;",
			"file-pdf-o" => "&#xf1c1;",
			"file-photo-o" => "&#xf1c5;",
			"file-picture-o" => "&#xf1c5;",
			"file-powerpoint-o" => "&#xf1c4;",
			"file-sound-o" => "&#xf1c7;",
			"file-text" => "&#xf15c;",
			"file-text-o" => "&#xf0f6;",
			"file-video-o" => "&#xf1c8;",
			"file-word-o" => "&#xf1c2;",
			"file-zip-o" => "&#xf1c6;",
			"files-o" => "&#xf0c5;",
			"film" => "&#xf008;",
			"filter" => "&#xf0b0;",
			"fire" => "&#xf06d;",
			"fire-extinguisher" => "&#xf134;",
			"firefox" => "&#xf269;",
			"first-order" => "&#xf2b0;",
			"flag" => "&#xf024;",
			"flag-checkered" => "&#xf11e;",
			"flag-o" => "&#xf11d;",
			"flash" => "&#xf0e7;",
			"flask" => "&#xf0c3;",
			"flickr" => "&#xf16e;",
			"floppy-o" => "&#xf0c7;",
			"folder" => "&#xf07b;",
			"folder-o" => "&#xf114;",
			"folder-open" => "&#xf07c;",
			"folder-open-o" => "&#xf115;",
			"font" => "&#xf031;",
			"font-awesome" => "&#xf2b4;",
			"fonticons" => "&#xf280;",
			"fort-awesome" => "&#xf286;",
			"forumbee" => "&#xf211;",
			"forward" => "&#xf04e;",
			"foursquare" => "&#xf180;",
			"free-code-camp" => "&#xf2c5;",
			"frown-o" => "&#xf119;",
			"futbol-o" => "&#xf1e3;",
			"gamepad" => "&#xf11b;",
			"gavel" => "&#xf0e3;",
			"gbp" => "&#xf154;",
			"ge" => "&#xf1d1;",
			"gear" => "&#xf013;",
			"gears" => "&#xf085;",
			"genderless" => "&#xf22d;",
			"get-pocket" => "&#xf265;",
			"gg" => "&#xf260;",
			"gg-circle" => "&#xf261;",
			"gift" => "&#xf06b;",
			"git" => "&#xf1d3;",
			"git-square" => "&#xf1d2;",
			"github" => "&#xf09b;",
			"github-alt" => "&#xf113;",
			"github-square" => "&#xf092;",
			"gitlab" => "&#xf296;",
			"gittip" => "&#xf184;",
			"glass" => "&#xf000;",
			"glide" => "&#xf2a5;",
			"glide-g" => "&#xf2a6;",
			"globe" => "&#xf0ac;",
			"google" => "&#xf1a0;",
			"google-plus" => "&#xf0d5;",
			"google-plus-circle" => "&#xf2b3;",
			"google-plus-official" => "&#xf2b3;",
			"google-plus-square" => "&#xf0d4;",
			"google-wallet" => "&#xf1ee;",
			"graduation-cap" => "&#xf19d;",
			"gratipay" => "&#xf184;",
			"grav" => "&#xf2d6;",
			"group" => "&#xf0c0;",
			"h-square" => "&#xf0fd;",
			"hacker-news" => "&#xf1d4;",
			"hand-grab-o" => "&#xf255;",
			"hand-lizard-o" => "&#xf258;",
			"hand-o-down" => "&#xf0a7;",
			"hand-o-left" => "&#xf0a5;",
			"hand-o-right" => "&#xf0a4;",
			"hand-o-up" => "&#xf0a6;",
			"hand-paper-o" => "&#xf256;",
			"hand-peace-o" => "&#xf25b;",
			"hand-pointer-o" => "&#xf25a;",
			"hand-rock-o" => "&#xf255;",
			"hand-scissors-o" => "&#xf257;",
			"hand-spock-o" => "&#xf259;",
			"hand-stop-o" => "&#xf256;",
			"handshake-o" => "&#xf2b5;",
			"hard-of-hearing" => "&#xf2a4;",
			"hashtag" => "&#xf292;",
			"hdd-o" => "&#xf0a0;",
			"header" => "&#xf1dc;",
			"headphones" => "&#xf025;",
			"heart" => "&#xf004;",
			"heart-o" => "&#xf08a;",
			"heartbeat" => "&#xf21e;",
			"history" => "&#xf1da;",
			"home" => "&#xf015;",
			"hospital-o" => "&#xf0f8;",
			"hotel" => "&#xf236;",
			"hourglass" => "&#xf254;",
			"hourglass-1" => "&#xf251;",
			"hourglass-2" => "&#xf252;",
			"hourglass-3" => "&#xf253;",
			"hourglass-end" => "&#xf253;",
			"hourglass-half" => "&#xf252;",
			"hourglass-o" => "&#xf250;",
			"hourglass-start" => "&#xf251;",
			"houzz" => "&#xf27c;",
			"html5" => "&#xf13b;",
			"i-cursor" => "&#xf246;",
			"id-badge" => "&#xf2c1;",
			"id-card" => "&#xf2c2;",
			"id-card-o" => "&#xf2c3;",
			"ils" => "&#xf20b;",
			"image" => "&#xf03e;",
			"imdb" => "&#xf2d8;",
			"inbox" => "&#xf01c;",
			"indent" => "&#xf03c;",
			"industry" => "&#xf275;",
			"info" => "&#xf129;",
			"info-circle" => "&#xf05a;",
			"inr" => "&#xf156;",
			"instagram" => "&#xf16d;",
			"institution" => "&#xf19c;",
			"internet-explorer" => "&#xf26b;",
			"intersex" => "&#xf224;",
			"ioxhost" => "&#xf208;",
			"italic" => "&#xf033;",
			"joomla" => "&#xf1aa;",
			"jpy" => "&#xf157;",
			"jsfiddle" => "&#xf1cc;",
			"key" => "&#xf084;",
			"keyboard-o" => "&#xf11c;",
			"krw" => "&#xf159;",
			"language" => "&#xf1ab;",
			"laptop" => "&#xf109;",
			"lastfm" => "&#xf202;",
			"lastfm-square" => "&#xf203;",
			"leaf" => "&#xf06c;",
			"leanpub" => "&#xf212;",
			"legal" => "&#xf0e3;",
			"lemon-o" => "&#xf094;",
			"level-down" => "&#xf149;",
			"level-up" => "&#xf148;",
			"life-bouy" => "&#xf1cd;",
			"life-buoy" => "&#xf1cd;",
			"life-ring" => "&#xf1cd;",
			"life-saver" => "&#xf1cd;",
			"lightbulb-o" => "&#xf0eb;",
			"line-chart" => "&#xf201;",
			"link" => "&#xf0c1;",
			"linkedin" => "&#xf0e1;",
			"linkedin-square" => "&#xf08c;",
			"linode" => "&#xf2b8;",
			"linux" => "&#xf17c;",
			"list" => "&#xf03a;",
			"list-alt" => "&#xf022;",
			"list-ol" => "&#xf0cb;",
			"list-ul" => "&#xf0ca;",
			"location-arrow" => "&#xf124;",
			"lock" => "&#xf023;",
			"long-arrow-down" => "&#xf175;",
			"long-arrow-left" => "&#xf177;",
			"long-arrow-right" => "&#xf178;",
			"long-arrow-up" => "&#xf176;",
			"low-vision" => "&#xf2a8;",
			"magic" => "&#xf0d0;",
			"mail-forward" => "&#xf064;",
			"magnet" => "&#xf076;",
			"mail-forward" => "&#xf064;",
			"mail-reply" => "&#xf112;",
			"mail-reply-all" => "&#xf122;",
			"male" => "&#xf183;",
			"map" => "&#xf279;",
			"map-marker" => "&#xf041;",
			"map-o" => "&#xf278;",
			"map-pin" => "&#xf276;",
			"map-signs" => "&#xf277;",
			"mars" => "&#xf222;",
			"mars-double" => "&#xf227;",
			"mars-stroke" => "&#xf229;",
			"mars-stroke-h" => "&#xf22b;",
			"mars-stroke-v" => "&#xf22a;",
			"maxcdn" => "&#xf136;",
			"meanpath" => "&#xf20c;",
			"medium" => "&#xf23a;",
			"medkit" => "&#xf0fa;",
			"meetup" => "&#xf2e0;",
			"meh-o" => "&#xf11a;",
			"mercury" => "&#xf223;",
			"microchip" => "&#xf2db;",
			"microphone" => "&#xf130;",
			"microphone-slash" => "&#xf131;",
			"minus" => "&#xf068;",
			"minus-circle" => "&#xf056;",
			"minus-square" => "&#xf146;",
			"minus-square-o" => "&#xf147;",
			"mixcloud" => "&#xf289;",
			"mobile" => "&#xf10b;",
			"mobile-phone" => "&#xf10b;",
			"modx" => "&#xf285;",
			"money" => "&#xf0d6;",
			"moon-o" => "&#xf186;",
			"mortar-board" => "&#xf19d;",
			"motorcycle" => "&#xf21c;",
			"mouse-pointer" => "&#xf245;",
			"music" => "&#xf001;",
			"navicon" => "&#xf0c9;",
			"neuter" => "&#xf22c;",
			"newspaper-o" => "&#xf1ea;",
			"object-group" => "&#xf247;",
			"object-ungroup" => "&#xf248;",
			"odnoklassniki" => "&#xf263;",
			"odnoklassniki-square" => "&#xf264;",
			"opencart" => "&#xf23d;",
			"openid" => "&#xf19b;",
			"opera" => "&#xf26a;",
			"optin-monster" => "&#xf23c;",
			"outdent" => "&#xf03b;",
			"pagelines" => "&#xf18c;",
			"paint-brush" => "&#xf1fc;",
			"paper-plane" => "&#xf1d8;",
			"paper-plane-o" => "&#xf1d9;",
			"paperclip" => "&#xf0c6;",
			"paragraph" => "&#xf1dd;",
			"paste" => "&#xf0ea;",
			"pause" => "&#xf04c;",
			"pause-circle" => "&#xf28b;",
			"pause-circle-o" => "&#xf28c;",
			"paw" => "&#xf1b0;",
			"paypal" => "&#xf1ed;",
			"pencil" => "&#xf040;",
			"pencil-square" => "&#xf14b;",
			"pencil-square-o" => "&#xf044;",
			"percent" => "&#xf295;",
			"phone" => "&#xf095;",
			"phone-square" => "&#xf098;",
			"photo" => "&#xf03e;",
			"picture-o" => "&#xf03e;",
			"pie-chart" => "&#xf200;",
			"pied-piper" => "&#xf2ae;",
			"pied-piper-alt" => "&#xf1a8;",
			"pied-piper-pp" => "&#xf1a7;",
			"pinterest" => "&#xf0d2;",
			"pinterest-p" => "&#xf231;",
			"pinterest-square" => "&#xf0d3;",
			"plane" => "&#xf072;",
			"play" => "&#xf04b;",
			"play-circle" => "&#xf144;",
			"play-circle-o" => "&#xf01d;",
			"plug" => "&#xf1e6;",
			"plus" => "&#xf067;",
			"plus-circle" => "&#xf055;",
			"plus-square" => "&#xf0fe;",
			"plus-square-o" => "&#xf196;",
			"podcast" => "&#xf2ce;",
			"power-off" => "&#xf011;",
			"print" => "&#xf02f;",
			"product-hunt" => "&#xf288;",
			"puzzle-piece" => "&#xf12e;",
			"qq" => "&#xf1d6;",
			"qrcode" => "&#xf029;",
			"question" => "&#xf128;",
			"question-circle" => "&#xf059;",
			"question-circle-o" => "&#xf29c;",
			"quora" => "&#xf2c4;",
			"quote-left" => "&#xf10d;",
			"quote-right" => "&#xf10e;",
			"ra" => "&#xf1d0;",
			"random" => "&#xf074;",
			"ravelry" => "&#xf2d9;",
			"rebel" => "&#xf1d0;",
			"recycle" => "&#xf1b8;",
			"reddit" => "&#xf1a1;",
			"reddit-alien" => "&#xf281;",
			"reddit-square" => "&#xf1a2;",
			"refresh" => "&#xf021;",
			"registered" => "&#xf25d;",
			"remove" => "&#xf00d;",
			"renren" => "&#xf18b;",
			"reorder" => "&#xf0c9;",
			"repeat" => "&#xf01e;",
			"reply" => "&#xf112;",
			"reply-all" => "&#xf122;",
			"resistance" => "&#xf1d0;",
			"retweet" => "&#xf079;",
			"rmb" => "&#xf157;",
			"road" => "&#xf018;",
			"rocket" => "&#xf135;",
			"rotate-left" => "&#xf0e2;",
			"rotate-right" => "&#xf01e;",
			"rouble" => "&#xf158;",
			"rss" => "&#xf09e;",
			"rss-square" => "&#xf143;",
			"rub" => "&#xf158;",
			"ruble" => "&#xf158;",
			"rupee" => "&#xf156;",
			"s15" => "&#xf2cd;",
			"safari" => "&#xf267;",
			"save" => "&#xf0c7;",
			"scissors" => "&#xf0c4;",
			"scribd" => "&#xf28a;",
			"search" => "&#xf002;",
			"search-minus" => "&#xf010;",
			"search-plus" => "&#xf00e;",
			"sellsy" => "&#xf213;",
			"send" => "&#xf1d8;",
			"send-o" => "&#xf1d9;",
			"server" => "&#xf233;",
			"share" => "&#xf064;",
			"share-alt" => "&#xf1e0;",
			"share-alt-square" => "&#xf1e1;",
			"share-square" => "&#xf14d;",
			"share-square-o" => "&#xf045;",
			"shekel" => "&#xf20b;",
			"sheqel" => "&#xf20b;",
			"shield" => "&#xf132;",
			"ship" => "&#xf21a;",
			"shirtsinbulk" => "&#xf214;",
			"shopping-bag" => "&#xf290;",
			"shopping-basket" => "&#xf291;",
			"shopping-cart" => "&#xf07a;",
			"shower" => "&#xf2cc;",
			"sign-in" => "&#xf090;",
			"sign-language" => "&#xf2a7;",
			"sign-out" => "&#xf08b;",
			"signal" => "&#xf012;",
			"signing" => "&#xf2a7;",
			"simplybuilt" => "&#xf215;",
			"sitemap" => "&#xf0e8;",
			"skyatlas" => "&#xf216;",
			"skype" => "&#xf17e;",
			"slack" => "&#xf198;",
			"sliders" => "&#xf1de;",
			"slideshare" => "&#xf1e7;",
			"smile-o" => "&#xf118;",
			"snapchat" => "&#xf2ab;",
			"snapchat-ghost" => "&#xf2ac;",
			"snapchat-square" => "&#xf2ad;",
			"snowflake-o" => "&#xf2dc;",
			"soccer-ball-o" => "&#xf1e3;",
			"sort" => "&#xf0dc;",
			"sort-alpha-asc" => "&#xf15d;",
			"sort-alpha-desc" => "&#xf15e;",
			"sort-amount-asc" => "&#xf160;",
			"sort-amount-desc" => "&#xf161;",
			"sort-asc" => "&#xf0de;",
			"sort-desc" => "&#xf0dd;",
			"sort-down" => "&#xf0dd;",
			"sort-numeric-asc" => "&#xf162;",
			"sort-numeric-desc" => "&#xf163;",
			"sort-up" => "&#xf0de;",
			"soundcloud" => "&#xf1be;",
			"space-shuttle" => "&#xf197;",
			"spinner" => "&#xf110;",
			"spoon" => "&#xf1b1;",
			"spotify" => "&#xf1bc;",
			"square" => "&#xf0c8;",
			"square-o" => "&#xf096;",
			"stack-exchange" => "&#xf18d;",
			"stack-overflow" => "&#xf16c;",
			"star" => "&#xf005;",
			"star-half" => "&#xf089;",
			"star-half-empty" => "&#xf123;",
			"star-half-full" => "&#xf123;",
			"star-half-o" => "&#xf123;",
			"star-o" => "&#xf006;",
			"steam" => "&#xf1b6;",
			"steam-square" => "&#xf1b7;",
			"step-backward" => "&#xf048;",
			"step-forward" => "&#xf051;",
			"stethoscope" => "&#xf0f1;",
			"sticky-note" => "&#xf249;",
			"sticky-note-o" => "&#xf24a;",
			"stop" => "&#xf04d;",
			"stop-circle" => "&#xf28d;",
			"stop-circle-o" => "&#xf28e;",
			"street-view" => "&#xf21d;",
			"strikethrough" => "&#xf0cc;",
			"stumbleupon" => "&#xf1a4;",
			"stumbleupon-circle" => "&#xf1a3;",
			"subscript" => "&#xf12c;",
			"subway" => "&#xf239;",
			"suitcase" => "&#xf0f2;",
			"sun-o" => "&#xf185;",
			"superpowers" => "&#xf2dd;",
			"superscript" => "&#xf12b;",
			"support" => "&#xf1cd;",
			"table" => "&#xf0ce;",
			"tablet" => "&#xf10a;",
			"tachometer" => "&#xf0e4;",
			"tag" => "&#xf02b;",
			"tags" => "&#xf02c;",
			"tasks" => "&#xf0ae;",
			"taxi" => "&#xf1ba;",
			"telegram" => "&#xf2c6;",
			"television" => "&#xf26c;",
			"tencent-weibo" => "&#xf1d5;",
			"terminal" => "&#xf120;",
			"text-height" => "&#xf034;",
			"text-width" => "&#xf035;",
			"th" => "&#xf00a;",
			"th-large" => "&#xf009;",
			"th-list" => "&#xf00b;",
			"themeisle" => "&#xf2b2;",
			"thermometer" => "&#xf2c7;",
			"thermometer-0" => "&#xf2cb;",
			"thermometer-1" => "&#xf2ca;",
			"thermometer-2" => "&#xf2c9;",
			"thermometer-3" => "&#xf2c8;",
			"thermometer-4" => "&#xf2c7;",
			"thermometer-empty" => "&#xf2cb;",
			"thermometer-full" => "&#xf2c7;",
			"thermometer-half" => "&#xf2c9;",
			"thermometer-quarter" => "&#xf2ca;",
			"thermometer-three-quarters" => "&#xf2c8;",
			"thumb-tack" => "&#xf08d;",
			"thumbs-down" => "&#xf165;",
			"thumbs-o-down" => "&#xf088;",
			"thumbs-o-up" => "&#xf087;",
			"thumbs-up" => "&#xf164;",
			"ticket" => "&#xf145;",
			"times" => "&#xf00d;",
			"times-circle" => "&#xf057;",
			"times-circle-o" => "&#xf05c;",
			"times-rectangle" => "&#xf2d3;",
			"times-rectangle-o" => "&#xf2d4;",
			"tint" => "&#xf043;",
			"toggle-down" => "&#xf150;",
			"toggle-left" => "&#xf191;",
			"toggle-off" => "&#xf204;",
			"toggle-on" => "&#xf205;",
			"toggle-right" => "&#xf152;",
			"toggle-up" => "&#xf151;",
			"trademark" => "&#xf25c;",
			"train" => "&#xf238;",
			"transgender" => "&#xf224;",
			"transgender-alt" => "&#xf225;",
			"trash" => "&#xf1f8;",
			"trash-o" => "&#xf014;",
			"tree" => "&#xf1bb;",
			"trello" => "&#xf181;",
			"tripadvisor" => "&#xf262;",
			"trophy" => "&#xf091;",
			"truck" => "&#xf0d1;",
			"try" => "&#xf195;",
			"tty" => "&#xf1e4;",
			"tumblr" => "&#xf173;",
			"tumblr-square" => "&#xf174;",
			"turkish-lira" => "&#xf195;",
			"tv" => "&#xf26c;",
			"twitch" => "&#xf1e8;",
			"twitter" => "&#xf099;",
			"twitter-square" => "&#xf081;",
			"umbrella" => "&#xf0e9;",
			"underline" => "&#xf0cd;",
			"undo" => "&#xf0e2;",
			"universal-access" => "&#xf29a;",
			"university" => "&#xf19c;",
			"unlink" => "&#xf127;",
			"unlock" => "&#xf09c;",
			"unlock-alt" => "&#xf13e;",
			"unsorted" => "&#xf0dc;",
			"upload" => "&#xf093;",
			"usb" => "&#xf287;",
			"usd" => "&#xf155;",
			"user" => "&#xf007;",
			"user-circle" => "&#xf2bd;",
			"user-circle-o" => "&#xf2be;",
			"user-md" => "&#xf0f0;",
			"user-o" => "&#xf2c0;",
			"user-o" => "&#xf2c0;",
			"user-plus" => "&#xf234;",
			"user-secret" => "&#xf21b;",
			"user-times" => "&#xf235;",
			"users" => "&#xf0c0;",
			"vcard" => "&#xf2bb;",
			"vcard-o" => "&#xf2bc;",
			"venus" => "&#xf221;",
			"venus-double" => "&#xf226;",
			"venus-mars" => "&#xf228;",
			"viacoin" => "&#xf237;",
			"viadeo" => "&#xf2a9;",
			"viadeo-square" => "&#xf2aa;",
			"video-camera" => "&#xf03d;",
			"vimeo" => "&#xf27d;",
			"vimeo-square" => "&#xf194;",
			"vine" => "&#xf1ca;",
			"vk" => "&#xf189;",
			"volume-control-phone" => "&#xf2a0;",
			"volume-down" => "&#xf027;",
			"volume-off" => "&#xf026;",
			"volume-up" => "&#xf028;",
			"warning" => "&#xf071;",
			"wechat" => "&#xf1d7;",
			"weibo" => "&#xf18a;",
			"weixin" => "&#xf1d7;",
			"whatsapp" => "&#xf232;",
			"wheelchair" => "&#xf193;",
			"wheelchair-alt" => "&#xf29b;",
			"wifi" => "&#xf1eb;",
			"wikipedia-w" => "&#xf266;",
			"window-close" => "&#xf2d3;",
			"window-close-o" => "&#xf2d4;",
			"window-maximize" => "&#xf2d0;",
			"window-minimize" => "&#xf2d1;",
			"window-restore" => "&#xf2d2;",
			"windows" => "&#xf17a;",
			"won" => "&#xf159;",
			"wordpress" => "&#xf19a;",
			"wpbeginner" => "&#xf297;",
			"wpexplorer" => "&#xf2de;",
			"wpforms" => "&#xf298;",
			"wrench" => "&#xf0ad;",
			"xing" => "&#xf168;",
			"xing-square" => "&#xf169;",
			"y-combinator" => "&#xf23b;",
			"y-combinator-square" => "&#xf1d4;",
			"yahoo" => "&#xf19e;",
			"yc" => "&#xf23b;",
			"yc-square" => "&#xf1d4;",
			"yelp" => "&#xf1e9;",
			"yen" => "&#xf157;",
			"yoast" => "&#xf2b1;",
			"youtube" => "&#xf167;",
			"youtube-play" => "&#xf16a;",
			"youtube-square" => "&#xf166;",
		];

		foreach ($fontawesome_icons as $fontawesome_icon_key => $fontawesome_icon_value)
		{
			$tmp = array(
				'value' => $fontawesome_icon_key,
				'text' => $fontawesome_icon_value,
				'disable' => 0,
				'class' => '',
				'selected' => 0,
				'checked' => 0,
			);
			$options[] = (object) $tmp;
		}

/*		TODO $testarray = $this->element->xpath('option');

		foreach ($testarray as $option)
		{
			// Filter requirements
			if ($requires = explode(',', (string) $option['requires']))
			{
				// Requires multilanguage
				if (in_array('multilanguage', $requires) && !JLanguageMultilang::isEnabled())
				{
					continue;
				}

				// Requires associations
				if (in_array('associations', $requires) && !JLanguageAssociations::isEnabled())
				{
					continue;
				}

				// Requires adminlanguage
				if (in_array('adminlanguage', $requires) && !JModuleHelper::isAdminMultilang())
				{
					continue;
				}

				// Requires vote plugin
				if (in_array('vote', $requires) && !JPluginHelper::isEnabled('content', 'vote'))
				{
					continue;
				}
			}

			$value = (string) $option['value'];
			$text = trim((string) $option) != '' ? trim((string) $option) : $value;

			$disabled = (string) $option['disabled'];
			$disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');
			$disabled = $disabled || ($this->readonly && $value != $this->value);

			$checked = (string) $option['checked'];
			$checked = ($checked == 'true' || $checked == 'checked' || $checked == '1');

			$selected = (string) $option['selected'];
			$selected = ($selected == 'true' || $selected == 'selected' || $selected == '1');

			$tmp = array(
				'value' => $value,
				'text' => JText::alt($text, $fieldname),
				'disable' => $disabled,
				'class' => (string) $option['class'],
				'selected' => ($checked || $selected),
				'checked' => ($checked || $selected),
			);

			// Set some event handler attributes. But really, should be using unobtrusive js.
			$tmp['onclick'] = (string) $option['onclick'];
			$tmp['onchange'] = (string) $option['onchange'];

			// Add the option object to the result set.
			//$options[] = (object) $tmp;
		}

		if ($this->element['useglobal'])
		{
			$tmp = new stdClass;
			$tmp->value = '';
			$tmp->text = JText::_('JGLOBAL_USE_GLOBAL');
			$component = JFactory::getApplication()->input->getCmd('option');

			// Get correct component for menu items
			if ($component == 'com_menus')
			{
				$link = $this->form->getData()->get('link');
				$uri = new JUri($link);
				$component = $uri->getVar('option', 'com_menus');
			}

			$params = JComponentHelper::getParams($component);
			$value = $params->get($this->fieldname);

			// Try with global configuration
			if (is_null($value))
			{
				$value = JFactory::getConfig()->get($this->fieldname);
			}

			// Try with menu configuration
			if (is_null($value) && JFactory::getApplication()->input->getCmd('option') == 'com_menus')
			{
				$value = JComponentHelper::getParams('com_menus')->get($this->fieldname);
			}

			if (!is_null($value))
			{
				$value = (string) $value;

				foreach ($options as $option)
				{
					if ($option->value === $value)
					{
						$value = $option->text;

						break;
					}
				}

				$tmp->text = JText::sprintf('JGLOBAL_USE_GLOBAL_VALUE', $value);
			}

			array_unshift($options, $tmp);
		}

		reset($options);*/

		return $options;
	}

	/**
	 * Method to add an option to the list field.
	 *
	 * @param   string  $text        Text/Language variable of the option.
	 * @param   array   $attributes  Array of attributes ('name' => 'value' format)
	 *
	 * @return  JFormFieldList  For chaining.
	 *
	 * @since   1.0.76
	 */
/*	public function addOption($text, $attributes = array())
	{
		if ($text && $this->element instanceof SimpleXMLElement)
		{
			$child = $this->element->addChild('option', $text);

			foreach ($attributes as $name => $value)
			{
				$child->addAttribute($name, $value);
			}
		}

		return $this;
	}*/

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to get the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   1.0.76
	 */
	public function __get($name)
	{
		if ($name == 'options')
		{
			return $this->getOptions();
		}

		return parent::__get($name);
	}

	}

/**
500px &#xf26e;
address-book  &#xf2b9;
address-book-o  &#xf2ba;
address-card  &#xf2bb;
address-card-o  &#xf2bc;
adjust  &#xf042;
adn  &#xf170;
align-center  &#xf037;
align-justify  &#xf039;
align-left  &#xf036;
align-right  &#xf038;
amazon  &#xf270;
ambulance  &#xf0f9;
american-sign-language-interpreting &#xf2a3;
anchor &#xf13d;
android &#xf17b;
angellist &#xf209;
angle-double-down &#xf103;
angle-double-left &#xf100;
angle-double-right &#xf101;
angle-double-up &#xf102;
angle-down &#xf107;
angle-left &#xf104;
angle-right &#xf105;
angle-up &#xf106;
apple &#xf179;
archive &#xf187;
area-chart &#xf1fe;
arrow-circle-down &#xf0ab;
arrow-circle-left &#xf0a8;
arrow-circle-o-down &#xf01a;
arrow-circle-o-left &#xf190;
arrow-circle-o-right &#xf18e;
arrow-circle-o-up &#xf01b;
arrow-circle-right &#xf0a9;
arrow-circle-up &#xf0aa;
arrow-down &#xf063;
arrow-left &#xf060;
arrow-right &#xf061;
arrow-up &#xf062;
arrows &#xf047;
arrows-alt &#xf0b2;
arrows-h &#xf07e;
arrows-v &#xf07d;
asl-interpreting &#xf2a3;
assistive-listening-systems &#xf2a2;
asterisk &#xf069;
at &#xf1fa;
audio-description &#xf29e;
automobile &#xf1b9;
backward &#xf04a;
balance-scale &#xf24e;
ban &#xf05e;
bandcamp &#xf2d5;
bank &#xf19c;
bar-chart &#xf080;
bar-chart-o &#xf080;
barcode &#xf02a;
bars &#xf0c9;
bath &#xf2cd;
bathtub &#xf2cd;
battery &#xf240;
battery-0 &#xf244;
battery-1 &#xf243;
battery-2 &#xf242;
battery-3 &#xf241;
battery-4 &#xf240;
battery-empty &#xf244;
battery-full &#xf240;
battery-half &#xf242;
battery-quarter &#xf243;
battery-three-quarters &#xf241;
bed &#xf236;
beer &#xf0fc;
behance &#xf1b4;
behance-square &#xf1b5;
bell &#xf0f3;
bell-o &#xf0a2;
bell-slash &#xf1f6;
bell-slash-o &#xf1f7;
bicycle &#xf206;
binoculars &#xf1e5;
birthday-cake &#xf1fd;
bitbucket &#xf171;
bitbucket-square &#xf172;
bitcoin &#xf15a;
black-tie &#xf27e;
blind &#xf29d;
bluetooth &#xf293;
bluetooth-b &#xf294;
bold &#xf032;
bolt &#xf0e7;
bomb &#xf1e2;
book &#xf02d;
bookmark &#xf02e;
bookmark-o &#xf097;
braille &#xf2a1;
briefcase &#xf0b1;
btc &#xf15a;
bug &#xf188;
building &#xf1ad;
building-o &#xf0f7;
bullhorn &#xf0a1;
bullseye &#xf140;
bus &#xf207;
buysellads &#xf20d;
cab &#xf1ba;
calculator &#xf1ec;
calendar &#xf073;
calendar-check-o &#xf274;
calendar-minus-o &#xf272;
calendar-o &#xf133;
calendar-plus-o &#xf271;
calendar-times-o &#xf273;
camera &#xf030;
camera-retro &#xf083;
car &#xf1b9;
caret-down &#xf0d7;
caret-left &#xf0d9;
caret-right &#xf0da;
caret-square-o-down &#xf150;
caret-square-o-left &#xf191;
caret-square-o-right &#xf152;
caret-square-o-up &#xf151;
caret-up &#xf0d8;
cart-arrow-down &#xf218;
cart-plus &#xf217;
cc &#xf20a;
cc-amex &#xf1f3;
cc-diners-club &#xf24c;
cc-discover &#xf1f2;
cc-jcb &#xf24b;
cc-mastercard &#xf1f1;
cc-paypal &#xf1f4;
cc-stripe &#xf1f5;
cc-visa &#xf1f0;
certificate &#xf0a3;
chain &#xf0c1;
chain-broken &#xf127;
check &#xf00c;
check-circle &#xf058;
check-circle-o &#xf05d;
check-square &#xf14a;
check-square-o &#xf046;
chevron-circle-down &#xf13a;
chevron-circle-left &#xf137;
chevron-circle-right &#xf138;
chevron-circle-up &#xf139;
chevron-down &#xf078;
chevron-left &#xf053;
chevron-right &#xf054;
chevron-up &#xf077;
child &#xf1ae;
chrome &#xf268;
circle &#xf111;
circle-o &#xf10c;
circle-o-notch &#xf1ce;
circle-thin &#xf1db;
clipboard &#xf0ea;
clock-o &#xf017;
clone &#xf24d;
close &#xf00d;
cloud &#xf0c2;
cloud-download &#xf0ed;
cloud-upload &#xf0ee;
cny &#xf157;
code &#xf121;
code-fork &#xf126;
codepen &#xf1cb;
codiepie &#xf284;
coffee &#xf0f4;
cog &#xf013;
cogs &#xf085;
columns &#xf0db;
comment &#xf075;
comment-o &#xf0e5;
commenting &#xf27a;
commenting-o &#xf27b;
comments &#xf086;
comments-o &#xf0e6;
compass &#xf14e;
compress &#xf066;
connectdevelop &#xf20e;
contao &#xf26d;
copy &#xf0c5;
copyright &#xf1f9;
creative-commons &#xf25e;
credit-card &#xf09d;
credit-card-alt &#xf283;
crop &#xf125;
crosshairs &#xf05b;
css3 &#xf13c;
cube &#xf1b2;
cubes &#xf1b3;
cut &#xf0c4;
cutlery &#xf0f5;
dashboard &#xf0e4;
dashcube &#xf210;
database &#xf1c0;
deaf &#xf2a4;
deafness &#xf2a4;
dedent &#xf03b;
delicious &#xf1a5;
desktop &#xf108;
deviantart &#xf1bd;
diamond &#xf219;
digg &#xf1a6;
dollar &#xf155;
dot-circle-o &#xf192;
download &#xf019;
dribbble &#xf17d;
drivers-license &#xf2c2;
drivers-license-o &#xf2c3;
dropbox &#xf16b;
drupal &#xf1a9;
edge &#xf282;
edit &#xf044;
eercast &#xf2da;
eject &#xf052;
ellipsis-h &#xf141;
ellipsis-v &#xf142;
empire &#xf1d1;
envelope &#xf0e0;
envelope-o &#xf003;
envelope-open &#xf2b6;
envelope-open-o &#xf2b7;
envelope-square &#xf199;
envira &#xf299;
eraser &#xf12d;
etsy &#xf2d7;
eur &#xf153;
euro &#xf153;
exchange &#xf0ec;
exclamation &#xf12a;
exclamation-circle &#xf06a;
exclamation-triangle &#xf071;
expand &#xf065;
expeditedssl &#xf23e;
external-link &#xf08e;
external-link-square &#xf14c;
eye &#xf06e;
eye-slash &#xf070;
eyedropper &#xf1fb;
fa &#xf2b4;
facebook &#xf09a;
facebook-f &#xf09a;
facebook-official &#xf230;
facebook-square &#xf082;
fast-backward &#xf049;
fast-forward &#xf050;
fax &#xf1ac;
feed &#xf09e;
female &#xf182;
fighter-jet &#xf0fb;
file &#xf15b;
file-archive-o &#xf1c6;
file-audio-o &#xf1c7;
file-code-o &#xf1c9;
file-excel-o &#xf1c3;
file-image-o &#xf1c5;
file-movie-o &#xf1c8;
file-o &#xf016;
file-pdf-o &#xf1c1;
file-photo-o &#xf1c5;
file-picture-o &#xf1c5;
file-powerpoint-o &#xf1c4;
file-sound-o &#xf1c7;
file-text &#xf15c;
file-text-o &#xf0f6;
file-video-o &#xf1c8;
file-word-o &#xf1c2;
file-zip-o &#xf1c6;
files-o &#xf0c5;
film &#xf008;
filter &#xf0b0;
fire &#xf06d;
fire-extinguisher &#xf134;
firefox &#xf269;
first-order &#xf2b0;
flag &#xf024;
flag-checkered &#xf11e;
flag-o &#xf11d;
flash &#xf0e7;
flask &#xf0c3;
flickr &#xf16e;
floppy-o &#xf0c7;
folder &#xf07b;
folder-o &#xf114;
folder-open &#xf07c;
folder-open-o &#xf115;
font &#xf031;
font-awesome &#xf2b4;
fonticons &#xf280;
fort-awesome &#xf286;
forumbee &#xf211;
forward &#xf04e;
foursquare &#xf180;
free-code-camp &#xf2c5;
frown-o &#xf119;
futbol-o &#xf1e3;
gamepad &#xf11b;
gavel &#xf0e3;
gbp &#xf154;
ge &#xf1d1;
gear &#xf013;
gears &#xf085;
genderless &#xf22d;
get-pocket &#xf265;
gg &#xf260;
gg-circle &#xf261;
gift &#xf06b;
git &#xf1d3;
git-square &#xf1d2;
github &#xf09b;
github-alt &#xf113;
github-square &#xf092;
gitlab &#xf296;
gittip &#xf184;
glass &#xf000;
glide &#xf2a5;
glide-g &#xf2a6;
globe &#xf0ac;
google &#xf1a0;
google-plus &#xf0d5;
google-plus-circle &#xf2b3;
google-plus-official &#xf2b3;
google-plus-square &#xf0d4;
google-wallet &#xf1ee;
graduation-cap &#xf19d;
gratipay &#xf184;
grav &#xf2d6;
group &#xf0c0;
h-square &#xf0fd;
hacker-news &#xf1d4;
hand-grab-o &#xf255;
hand-lizard-o &#xf258;
hand-o-down &#xf0a7;
hand-o-left &#xf0a5;
hand-o-right &#xf0a4;
hand-o-up &#xf0a6;
hand-paper-o &#xf256;
hand-peace-o &#xf25b;
hand-pointer-o &#xf25a;
hand-rock-o &#xf255;
hand-scissors-o &#xf257;
hand-spock-o &#xf259;
hand-stop-o &#xf256;
handshake-o &#xf2b5;
hard-of-hearing &#xf2a4;
hashtag &#xf292;
hdd-o &#xf0a0;
header &#xf1dc;
headphones &#xf025;
heart &#xf004;
heart-o &#xf08a;
heartbeat &#xf21e;
history &#xf1da;
home &#xf015;
hospital-o &#xf0f8;
hotel &#xf236;
hourglass &#xf254;
hourglass-1 &#xf251;
hourglass-2 &#xf252;
hourglass-3 &#xf253;
hourglass-end &#xf253;
hourglass-half &#xf252;
hourglass-o &#xf250;
hourglass-start &#xf251;
houzz &#xf27c;
html5 &#xf13b;
i-cursor &#xf246;
id-badge &#xf2c1;
id-card &#xf2c2;
id-card-o &#xf2c3;
ils &#xf20b;
image &#xf03e;
imdb &#xf2d8;
inbox &#xf01c;
indent &#xf03c;
industry &#xf275;
info &#xf129;
info-circle &#xf05a;
inr &#xf156;
instagram &#xf16d;
institution &#xf19c;
internet-explorer &#xf26b;
intersex &#xf224;
ioxhost &#xf208;
italic &#xf033;
joomla &#xf1aa;
jpy &#xf157;
jsfiddle &#xf1cc;
key &#xf084;
keyboard-o &#xf11c;
krw &#xf159;
language &#xf1ab;
laptop &#xf109;
lastfm &#xf202;
lastfm-square &#xf203;
leaf &#xf06c;
leanpub &#xf212;
legal &#xf0e3;
lemon-o &#xf094;
level-down &#xf149;
level-up &#xf148;
life-bouy &#xf1cd;
life-buoy &#xf1cd;
life-ring &#xf1cd;
life-saver &#xf1cd;
lightbulb-o &#xf0eb;
line-chart &#xf201;
link &#xf0c1;
linkedin &#xf0e1;
linkedin-square &#xf08c;
linode &#xf2b8;
linux &#xf17c;
list &#xf03a;
list-alt &#xf022;
list-ol &#xf0cb;
list-ul &#xf0ca;
location-arrow &#xf124;
lock &#xf023;
long-arrow-down &#xf175;
long-arrow-left &#xf177;
long-arrow-right &#xf178;
long-arrow-up &#xf176;
low-vision &#xf2a8;
magic &#xf0d0;
magnet &#xf076;
mail-forward &#xf064;
mail-reply &#xf112;
mail-reply-all &#xf122;
male &#xf183;
map &#xf279;
map-marker &#xf041;
map-o &#xf278;
map-pin &#xf276;
map-signs &#xf277;
mars &#xf222;
mars-double &#xf227;
mars-stroke &#xf229;
mars-stroke-h &#xf22b;
mars-stroke-v &#xf22a;
maxcdn &#xf136;
meanpath &#xf20c;
medium &#xf23a;
medkit &#xf0fa;
meetup &#xf2e0;
meh-o &#xf11a;
mercury &#xf223;
microchip &#xf2db;
microphone &#xf130;
microphone-slash &#xf131;
minus &#xf068;
minus-circle &#xf056;
minus-square &#xf146;
minus-square-o &#xf147;
mixcloud &#xf289;
mobile &#xf10b;
mobile-phone &#xf10b;
modx &#xf285;
money &#xf0d6;
moon-o &#xf186;
mortar-board &#xf19d;
motorcycle &#xf21c;
mouse-pointer &#xf245;
music &#xf001;
navicon &#xf0c9;
neuter &#xf22c;
newspaper-o &#xf1ea;
object-group &#xf247;
object-ungroup &#xf248;
odnoklassniki &#xf263;
odnoklassniki-square &#xf264;
opencart &#xf23d;
openid &#xf19b;
opera &#xf26a;
optin-monster &#xf23c;
outdent &#xf03b;
pagelines &#xf18c;
paint-brush &#xf1fc;
paper-plane &#xf1d8;
paper-plane-o &#xf1d9;
paperclip &#xf0c6;
paragraph &#xf1dd;
paste &#xf0ea;
pause &#xf04c;
pause-circle &#xf28b;
pause-circle-o &#xf28c;
paw &#xf1b0;
paypal &#xf1ed;
pencil &#xf040;
pencil-square &#xf14b;
pencil-square-o &#xf044;
percent &#xf295;
phone &#xf095;
phone-square &#xf098;
photo &#xf03e;
picture-o &#xf03e;
pie-chart &#xf200;
pied-piper &#xf2ae;
pied-piper-alt &#xf1a8;
pied-piper-pp &#xf1a7;
pinterest &#xf0d2;
pinterest-p &#xf231;
pinterest-square &#xf0d3;
plane &#xf072;
play &#xf04b;
play-circle &#xf144;
play-circle-o &#xf01d;
plug &#xf1e6;
plus &#xf067;
plus-circle &#xf055;
plus-square &#xf0fe;
plus-square-o &#xf196;
podcast &#xf2ce;
power-off &#xf011;
print &#xf02f;
product-hunt &#xf288;
puzzle-piece &#xf12e;
qq &#xf1d6;
qrcode &#xf029;
question &#xf128;
question-circle &#xf059;
question-circle-o &#xf29c;
quora &#xf2c4;
quote-left &#xf10d;
quote-right &#xf10e;
ra &#xf1d0;
random &#xf074;
ravelry &#xf2d9;
rebel &#xf1d0;
recycle &#xf1b8;
reddit &#xf1a1;
reddit-alien &#xf281;
reddit-square &#xf1a2;
refresh &#xf021;
registered &#xf25d;
remove &#xf00d;
renren &#xf18b;
reorder &#xf0c9;
repeat &#xf01e;
reply &#xf112;
reply-all &#xf122;
resistance &#xf1d0;
retweet &#xf079;
rmb &#xf157;
road &#xf018;
rocket &#xf135;
rotate-left &#xf0e2;
rotate-right &#xf01e;
rouble &#xf158;
rss &#xf09e;
rss-square &#xf143;
rub &#xf158;
ruble &#xf158;
rupee &#xf156;
s15 &#xf2cd;
safari &#xf267;
save &#xf0c7;
scissors &#xf0c4;
scribd &#xf28a;
search &#xf002;
search-minus &#xf010;
search-plus &#xf00e;
sellsy &#xf213;
send &#xf1d8;
send-o &#xf1d9;
server &#xf233;
share &#xf064;
share-alt &#xf1e0;
share-alt-square &#xf1e1;
share-square &#xf14d;
share-square-o &#xf045;
shekel &#xf20b;
sheqel &#xf20b;
shield &#xf132;
ship &#xf21a;
shirtsinbulk &#xf214;
shopping-bag &#xf290;
shopping-basket &#xf291;
shopping-cart &#xf07a;
shower &#xf2cc;
sign-in &#xf090;
sign-language &#xf2a7;
sign-out &#xf08b;
signal &#xf012;
signing &#xf2a7;
simplybuilt &#xf215;
sitemap &#xf0e8;
skyatlas &#xf216;
skype &#xf17e;
slack &#xf198;
sliders &#xf1de;
slideshare &#xf1e7;
smile-o &#xf118;
snapchat &#xf2ab;
snapchat-ghost &#xf2ac;
snapchat-square &#xf2ad;
snowflake-o &#xf2dc;
soccer-ball-o &#xf1e3;
sort &#xf0dc;
sort-alpha-asc &#xf15d;
sort-alpha-desc &#xf15e;
sort-amount-asc &#xf160;
sort-amount-desc &#xf161;
sort-asc &#xf0de;
sort-desc &#xf0dd;
sort-down &#xf0dd;
sort-numeric-asc &#xf162;
sort-numeric-desc &#xf163;
sort-up &#xf0de;
soundcloud &#xf1be;
space-shuttle &#xf197;
spinner &#xf110;
spoon &#xf1b1;
spotify &#xf1bc;
square &#xf0c8;
square-o &#xf096;
stack-exchange &#xf18d;
stack-overflow &#xf16c;
star &#xf005;
star-half &#xf089;
star-half-empty &#xf123;
star-half-full &#xf123;
star-half-o &#xf123;
star-o &#xf006;
steam &#xf1b6;
steam-square &#xf1b7;
step-backward &#xf048;
step-forward &#xf051;
stethoscope &#xf0f1;
sticky-note &#xf249;
sticky-note-o &#xf24a;
stop &#xf04d;
stop-circle &#xf28d;
stop-circle-o &#xf28e;
street-view &#xf21d;
strikethrough &#xf0cc;
stumbleupon &#xf1a4;
stumbleupon-circle &#xf1a3;
subscript &#xf12c;
subway &#xf239;
suitcase &#xf0f2;
sun-o &#xf185;
superpowers &#xf2dd;
superscript &#xf12b;
support &#xf1cd;
table &#xf0ce;
tablet &#xf10a;
tachometer &#xf0e4;
tag &#xf02b;
tags &#xf02c;
tasks &#xf0ae;
taxi &#xf1ba;
telegram &#xf2c6;
television &#xf26c;
tencent-weibo &#xf1d5;
terminal &#xf120;
text-height &#xf034;
text-width &#xf035;
th &#xf00a;
th-large &#xf009;
th-list &#xf00b;
themeisle &#xf2b2;
thermometer &#xf2c7;
thermometer-0 &#xf2cb;
thermometer-1 &#xf2ca;
thermometer-2 &#xf2c9;
thermometer-3 &#xf2c8;
thermometer-4 &#xf2c7;
thermometer-empty &#xf2cb;
thermometer-full &#xf2c7;
thermometer-half &#xf2c9;
thermometer-quarter &#xf2ca;
thermometer-three-quarters &#xf2c8;
thumb-tack &#xf08d;
thumbs-down &#xf165;
thumbs-o-down &#xf088;
thumbs-o-up &#xf087;
thumbs-up &#xf164;
ticket &#xf145;
times &#xf00d;
times-circle &#xf057;
times-circle-o &#xf05c;
times-rectangle &#xf2d3;
times-rectangle-o &#xf2d4;
tint &#xf043;
toggle-down &#xf150;
toggle-left &#xf191;
toggle-off &#xf204;
toggle-on &#xf205;
toggle-right &#xf152;
toggle-up &#xf151;
trademark &#xf25c;
train &#xf238;
transgender &#xf224;
transgender-alt &#xf225;
trash &#xf1f8;
trash-o &#xf014;
tree &#xf1bb;
trello &#xf181;
tripadvisor &#xf262;
trophy &#xf091;
truck &#xf0d1;
try &#xf195;
tty &#xf1e4;
tumblr &#xf173;
tumblr-square &#xf174;
turkish-lira &#xf195;
tv &#xf26c;
twitch &#xf1e8;
twitter &#xf099;
twitter-square &#xf081;
umbrella &#xf0e9;
underline &#xf0cd;
undo &#xf0e2;
universal-access &#xf29a;
university &#xf19c;
unlink &#xf127;
unlock &#xf09c;
unlock-alt &#xf13e;
unsorted &#xf0dc;
upload &#xf093;
usb &#xf287;
usd &#xf155;
user &#xf007;
user-circle &#xf2bd;
user-circle-o &#xf2be;
user-md &#xf0f0;
user-o &#xf2c0;
user-plus &#xf234;
user-secret &#xf21b;
user-times &#xf235;
users &#xf0c0;
vcard &#xf2bb;
vcard-o &#xf2bc;
venus &#xf221;
venus-double &#xf226;
venus-mars &#xf228;
viacoin &#xf237;
viadeo &#xf2a9;
viadeo-square &#xf2aa;
video-camera &#xf03d;
vimeo &#xf27d;
vimeo-square &#xf194;
vine &#xf1ca;
vk &#xf189;
volume-control-phone &#xf2a0;
volume-down &#xf027;
volume-off &#xf026;
volume-up &#xf028;
warning &#xf071;
wechat &#xf1d7;
weibo &#xf18a;
weixin &#xf1d7;
whatsapp &#xf232;
wheelchair &#xf193;
wheelchair-alt &#xf29b;
wifi &#xf1eb;
wikipedia-w &#xf266;
window-close &#xf2d3;
window-close-o &#xf2d4;
window-maximize &#xf2d0;
window-minimize &#xf2d1;
window-restore &#xf2d2;
windows &#xf17a;
won &#xf159;
wordpress &#xf19a;
wpbeginner &#xf297;
wpexplorer &#xf2de;
wpforms &#xf298;
wrench &#xf0ad;
xing &#xf168;
xing-square &#xf169;
y-combinator &#xf23b;
y-combinator-square &#xf1d4;
yahoo &#xf19e;
yc &#xf23b;
yc-square &#xf1d4;
yelp &#xf1e9;
yen &#xf157;
yoast &#xf2b1;
youtube &#xf167;
youtube-play &#xf16a;
youtube-square &#xf166;

 *
 *  /
 */