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
 * HTML View class for the Aggpxtrack component
 *
 * @since  1.0
 */
class AggpxtrackViewGpxtrackList extends JViewLegacy
{
	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   1.0
	 */
	public function display($tpl = null)
	{
		// Do not allow cache
		JFactory::getApplication()->allowCache(false);

		$images  = $this->get('images');
		$folders = $this->get('folders');
		$state   = $this->get('state');

		$this->baseURL = COM_MEDIA_BASEURL;
		$this->images  = &$images;
		$this->folders = &$folders;
		$this->state   = &$state;

		parent::display($tpl);
	}

	/**
	 * Set the active folder
	 *
	 * @param   integer  $index  Folder position
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setFolder($index = 0)
	{
		if (isset($this->folders[$index])) {
			$this->_tmp_folder = &$this->folders[$index];
		} else {
			$this->_tmp_folder = new JObject;
		}
	}

	/**
	 * Set the active image
	 *
	 * @param   integer  $index  Image position
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setImage($index = 0)
	{
		if (isset($this->images[$index])) {
			$this->_tmp_img = &$this->images[$index];
		} else {
			$this->_tmp_img = new JObject;
		}
	}
}
