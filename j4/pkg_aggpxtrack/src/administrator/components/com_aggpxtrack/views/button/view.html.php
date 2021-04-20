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
class AggpxtrackViewButton extends JViewLegacy
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
		$config = JComponentHelper::getParams('com_aggpxtrack');

		JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_media/models', 'MediaModelManager');
		$mediamodel = JModelLegacy::getInstance('Manager', 'MediaModel');

		/*
		 * Display form for FTP credentials?
		 * Don't set them here, as there are other functions called before this one if there is any file write operation
		 */
		$ftp = !JClientHelper::hasCredentials('ftp');

		$this->session     = JFactory::getSession();
		$this->config      = $config;
		$this->state       = $mediamodel->getstate();
		$this->folderList  = $mediamodel->getfolderList();
		$this->require_ftp = $ftp;

		parent::display($tpl);
	}
}
