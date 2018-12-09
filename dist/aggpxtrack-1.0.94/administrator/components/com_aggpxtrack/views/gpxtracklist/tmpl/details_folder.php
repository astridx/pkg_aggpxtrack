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

$params = JComponentHelper::getParams('com_aggpxtrack');

$input = JFactory::getApplication()->input;
?>
	<tr>
		<td class="imgTotal">
			<a href="index.php?option=com_aggpxtrack&amp;view=gpxtrackList&layout=<?php echo $params->get('aggpxtrackview', 'thumbs');?>&amp;tmpl=component&amp;folder=<?php echo $this->_tmp_folder->path_relative; ?>&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author');?>" target="imageframe"><span class="icon-folder-2"></span></a>
		</td>

		<td class="description">
			<a href="index.php?option=com_aggpxtrack&amp;view=gpxtrackList&layout=<?php echo $params->get('aggpxtrackview', 'thumbs');?>&amp;tmpl=component&amp;folder=<?php echo $this->_tmp_folder->path_relative; ?>&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author');?>" target="imageframe"><?php echo $this->_tmp_folder->name; ?></a>
		</td>

		<td>&#160;</td>

		<td>&#160;</td>

	</tr>
