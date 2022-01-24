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
JHtml::_('behavior.tabstate');

$params = JComponentHelper::getParams('com_aggpxtrack');

define('COM_MEDIA_BASE', JPATH_ROOT . '/' . $params->get($path, 'images'));
define('COM_MEDIA_BASEURL', JUri::root() . $params->get($path, 'images'));

$controller = JControllerLegacy::getInstance('Aggpxtrack', ['base_path' => JPATH_COMPONENT_ADMINISTRATOR]);
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
