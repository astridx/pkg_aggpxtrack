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
 * @since  1.0
 */
class Com_AggpxtrackInstallerScript
{
	/**
	 * Function to perform changes during install
	 *
	 * @param   JInstallerAdapterComponent  $parent  The class calling this method
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function install($parent)
	{
		$parent->getParent()->setRedirectURL('index.php?option=com_aggpxtrack');

		return true;
	}

	/**
	 * This method is called after a component is uninstalled.
	 *
	 * @param   \stdClass  $parent  Parent object calling this method.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function uninstall($parent)
	{
		echo '<p>' . JText::_('COM_AGADVENT_UNINSTALL_TEXT') . '</p>';

		return true;
	}

	/**
	 * Method to run after the install routine.
	 *
	 * @param   string                      $type    The action being performed
	 * @param   JInstallerAdapterComponent  $parent  The class calling this method
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function postflight($type, $parent)
	{
		$this->copyFiles();
	}

	/**
	 * Method to rcopy files.
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function copyFiles()
	{
		// Creating a folder
		$mode = 0755;
		$path = JPATH_SITE . "/images/com_aggpxtrack/";
		JFolder::create($path, $mode);

		$pathsearch = JPATH_SITE . "/media/com_aggpxtrack/gpxfiles/";

		// Now we read all png files and put them in an array.
		$gpx_files = JFolder::files($pathsearch, '.gpx');

		foreach ($gpx_files as $file)
		{
			if (!file_exists($path . $file))
			{
				JFile::copy($pathsearch . $file, $path . $file);
			}
		}

		return true;
	}
}
