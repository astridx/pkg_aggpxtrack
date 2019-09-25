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
 * FolderInstaller Plugin.
 *
 * @see    https://github.com/joomla/joomla-cms/pull/2769
 *
 * @since  1.0.0
 */
class PlgInstallerAggpxtrackInstaller extends JPlugin
{
	  /**
	   * @var    string  base update url, to decide whether to process the event or not
	   * @since  1.0.0
	   */
	private $baseUrl = 'http://astrid-guenther.de/updates/aggpxtrack/';

	  /**
	   * @var    string  your extension identifier, to retrieve its params
	   * @since  1.0.0
	   */
	private $extension = 'com_aggpxtrack';

	  /**
	   * Handle adding credentials to package download request
	   *
	   * @param   string  &$url  url from which package is going to be downloaded
	   *
	   * @return  boolean true  Always true, regardless of success
	   *
	   * @since   1.0.0
	   */
	public function onInstallerBeforePackageDownload(&$url)
	{

		return true;
	}
}
