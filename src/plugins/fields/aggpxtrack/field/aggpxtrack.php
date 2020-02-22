<?php
/**
 * @package     Joomla.Site
 * @subpackage  pkg_aggpxtrack
 *
 * @copyright   Copyright (C) 2005 - 2018 Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\Field\MediaField;

/**
 * Provides a modal media selector including upload mechanism
 *
 * @since  1.6
 */
class JFormFieldAggpxtrack extends MediaField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $type = 'Aggpxtrack';

	/**
	 * Layout to render
	 *
	 * @var    string
	 * @since  3.5
	 */
	protected $layout = 'aggpxtrack';

	/**
	 * Get the layout paths
	 *
	 * @return  array
	 *
	 * @since   3.5
	 */
	protected function getLayoutPaths()
	{
		$template = JFactory::getApplication()->getTemplate();

		return array(
			JPATH_ADMINISTRATOR . '/templates/' . $template . '/html/layouts/plugins/system/stats',
			dirname(__DIR__) . '/layouts',
			JPATH_SITE . '/layouts'
		);
	}
}
