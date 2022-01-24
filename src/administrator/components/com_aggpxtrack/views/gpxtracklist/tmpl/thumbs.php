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

$lang = JFactory::getLanguage();

JHtml::_('stylesheet', 'media/popup-imagelist.css', [], true);

if ($lang->isRtl()) {
	JHtml::_('stylesheet', 'media/popup-imagelist_rtl.css', [], true);
}

JFactory::getDocument()->addScriptDeclaration("var ImageManager = window.parent.ImageManager;");
JFactory::getDocument()->addStyleDeclaration(
	"
		@media (max-width: 767px) {
			li.imgOutline.thumbnail.height-80.width-80.center {
				float: left;
				margin-left: 15px;
			}
		}
	"
);
?>
<?php if (count($this->images) > 0 || count($this->folders) > 0) : ?>
	<ul class="manager thumbnails">
		<?php for ($i = 0, $n = count($this->folders); $i < $n; $i++) :
			$this->setFolder($i);
			echo $this->loadTemplate('folder');
		endfor; ?>

		<?php for ($i = 0, $n = count($this->images); $i < $n; $i++) :
			$this->setImage($i);
			echo $this->loadTemplate('image');
		endfor; ?>
	</ul>
<?php else : ?>
	<div id="media-noimages">
		<div class="alert alert-info"><?php echo JText::_('COM_AGGPXTRACK_NO_IMAGES_FOUND'); ?></div>
	</div>
<?php endif; ?>
