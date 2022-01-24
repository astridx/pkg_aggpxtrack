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

use Joomla\Registry\Registry;

$params = JComponentHelper::getParams('com_aggpxtrack');

$dispatcher = JEventDispatcher::getInstance();
$dispatcher->trigger('onContentBeforeDisplay', ['com_aggpxtrack.file', &$this->_tmp_img, &$params]);
?>
	<tr>

		<td>
			<a class="img-preview" href="javascript:ImageManager.populateFields('<?php echo $this->_tmp_img->path_relative; ?>')" title="<?php echo $this->_tmp_img->name; ?>" >
				<span class="icon-file"></span>
			</a>
		</td>

		<td class="description">
			<a class="img-preview" href="javascript:ImageManager.populateFields('<?php echo $this->_tmp_img->path_relative; ?>')" title="<?php echo $this->_tmp_img->name; ?>" >
				<?php echo $this->escape($this->_tmp_img->name); ?>
			</a>
		</td>

		<td class="filesize">
			<?php echo JHtml::_('number.bytes', $this->_tmp_img->size); ?>
		</td>

		<td class="filedate">
			<?php echo $this->escape($this->_tmp_img->date); ?>
		</td>

	</tr>
<?php
$dispatcher->trigger('onContentAfterDisplay', ['com_aggpxtrack.file', &$this->_tmp_img, &$params]);
