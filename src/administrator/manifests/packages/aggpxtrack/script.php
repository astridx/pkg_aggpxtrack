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

/**
 * Installation class to perform additional changes during install/uninstall/update
 *
 * @since  1.0.76
 */
class Pkg_AggpxtrackInstallerScript extends JInstallerScript
{
	/**
	 * Extension script constructor.
	 *
	 * @since   1.0.76
	 */
	public function __construct()
	{
		$this->minimumJoomla = '4.0.0-beta1-dev';
		$this->minimumPhp    = JOOMLA_MINIMUM_PHP;
	}
}
