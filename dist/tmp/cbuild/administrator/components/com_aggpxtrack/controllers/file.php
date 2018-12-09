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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Media File Controller
 *
 * @since  1.5
 */
class AggpxtrackControllerFile extends JControllerLegacy
{
	/**
	 * The folder we are uploading into
	 *
	 * @var   string
	 */
	protected $folder = '';

	/**
	 * Upload one or more files
	 *
	 * @return  boolean
	 *
	 * @since   1.5
	 */
	public function upload()
	{
		// Check for request forgeries
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
		$params = JComponentHelper::getParams('com_aggpxtrack');
		$app   = JFactory::getApplication();

		// Get some data from the request
		$files        = $this->input->files->get('Filedata', '', 'array');
		$return       = JFactory::getSession()->get('com_aggpxtrack.return_url');
		$this->folder = $this->input->get('folder', '', 'path');

		// Don't redirect to an external URL.
		if (!JUri::isInternal($return))
		{
			$return = '';
		}

		// Set the redirect
		if ($return)
		{
			$this->setRedirect($return . '&folder=' . $this->folder);
		}
		else
		{
			$this->setRedirect('index.php?option=com_aggpxtrack&folder=' . $this->folder);
		}

		// Authorize the user
		if (!$this->authoriseUser('create'))
		{
			return false;
		}

		// Total length of post back data in bytes.
		$contentLength = (int) $_SERVER['CONTENT_LENGTH'];

		$mediaHelper = new JHelperMedia;

		// Maximum allowed size of post back data in MB.
		$postMaxSize = $mediaHelper->toBytes(ini_get('post_max_size'));

		// Maximum allowed size of script execution in MB.
		$memoryLimit = $mediaHelper->toBytes(ini_get('memory_limit'));

		// Check for the total size of post back data.
		if (($postMaxSize > 0 && $contentLength > $postMaxSize)
			|| ($memoryLimit != -1 && $contentLength > $memoryLimit))
		{
			$app->enqueueMessage(JText::_('COM_AGGPXTRACK_ERROR_WARNUPLOADTOOLARGE'), 'warning');

			return false;
		}

		$uploadMaxSize = $params->get('upload_maxsize', 0) * 1024 * 1024;
		$uploadMaxFileSize = $mediaHelper->toBytes(ini_get('upload_max_filesize'));

		// Perform basic checks on file info before attempting anything
		foreach ($files as &$file)
		{
			$file['name']     = JFile::makeSafe($file['name']);
			$file['name']     = str_replace(' ', '-', $file['name']);
			$file['filepath'] = JPath::clean(implode(DIRECTORY_SEPARATOR, array(COM_MEDIA_BASE, $this->folder, $file['name'])));

			if (($file['error'] == 1)
				|| ($uploadMaxSize > 0 && $file['size'] > $uploadMaxSize)
				|| ($uploadMaxFileSize > 0 && $file['size'] > $uploadMaxFileSize))
			{
				// File size exceed either 'upload_max_filesize' or 'upload_maxsize'.
				$app->enqueueMessage(JText::_('COM_AGGPXTRACK_ERROR_WARNFILETOOLARGE'), 'warning');

				return false;
			}

			if (JFile::exists($file['filepath']))
			{
				// A file with this name already exists
				$app->enqueueMessage(JText::_('COM_AGGPXTRACK_ERROR_FILE_EXISTS'), 'warning');

				return false;
			}

			if (!isset($file['name']))
			{
				// No filename (after the name was cleaned by JFile::makeSafe)
				$this->setRedirect('index.php', JText::_('COM_AGGPXTRACK_INVALID_REQUEST'), 'error');

				return false;
			}
		}

		// Set FTP credentials, if given
		JClientHelper::setCredentialsFromRequest('ftp');
		JPluginHelper::importPlugin('content');
		$dispatcher = JEventDispatcher::getInstance();

		foreach ($files as &$file)
		{
			// The request is valid
			$ext = 'com_media';

			if (!$mediaHelper->canUpload($file, $ext))
			{
				// The file can't be uploaded

				return false;
			}

			// Trigger the onContentBeforeSave event.
			$object_file = new JObject($file);
			$result = $dispatcher->trigger('onContentBeforeSave', array('com_aggpxtrack.file', &$object_file, true));

			if (in_array(false, $result, true))
			{
				// There are some errors in the plugins
				$app->enqueueMessage(
						JText::plural('COM_AGGPXTRACK_ERROR_BEFORE_SAVE', count($errors = $object_file->getErrors()), implode('<br />', $errors)),
						'warning'
						);

				return false;
			}

			if (!JFile::upload($object_file->tmp_name, $object_file->filepath))
			{
				// Error in upload
				$app->enqueueMessage(JText::_('COM_AGGPXTRACK_ERROR_UNABLE_TO_UPLOAD_FILE'), 'warning');

				return false;
			}

			// Trigger the onContentAfterSave event.
			$dispatcher->trigger('onContentAfterSave', array('com_aggpxtrack.file', &$object_file, true));
			$this->setMessage(JText::sprintf('COM_AGGPXTRACK_UPLOAD_COMPLETE', substr($object_file->filepath, strlen(COM_MEDIA_BASE))));
		}

		return true;
	}

	/**
	 * Check that the user is authorized to perform this action
	 *
	 * @param   string  $action  - the action to be peformed (create or delete)
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function authoriseUser($action)
	{
		if (!JFactory::getUser()->authorise('core.' . strtolower($action), 'com_aggpxtrack'))
		{
			// User is not authorised
			$app   = JFactory::getApplication();
			$app->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_' . strtoupper($action) . '_NOT_PERMITTED'), 'warning');

			return false;
		}

		return true;
	}
}
