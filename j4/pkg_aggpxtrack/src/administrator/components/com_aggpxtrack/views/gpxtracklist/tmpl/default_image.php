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

$params     = new Registry;
$dispatcher = JEventDispatcher::getInstance();
$dispatcher->trigger('onContentBeforeDisplay', ['com_aggpxtrack.file', &$this->_tmp_img, &$params]);
?>

<li class="imgOutline thumbnail height-80 width-80 center">
	<a class="img-preview" href="javascript:ImageManager.populateFields('<?php echo $this->_tmp_img->path_relative; ?>')" title="<?php echo $this->_tmp_img->name; ?>" >
		<div class="height-50">
			<?php echo '<i class="icon-compass icon-white"> </i>';
			?>
		</div>
		<div class="small">
			<?php echo JHtml::_('string.truncate', $this->_tmp_img->name, 10, false); ?>
		</div>
	</a>
</li>
<?php
$dispatcher->trigger('onContentAfterDisplay', ['com_aggpxtrack.file', &$this->_tmp_img, &$params]);
