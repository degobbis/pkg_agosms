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

class ArticlesViewGoodSearch extends JViewCategory
{
	function display($search_type = "com_content")
	{
		require_once JPATH_SITE . "/plugins/system/plg_agosms_search/models/com_content/model.php";
		$model = new ArticlesModelGoodSearch;
		echo $model->total_items;
		die;
	}
}


