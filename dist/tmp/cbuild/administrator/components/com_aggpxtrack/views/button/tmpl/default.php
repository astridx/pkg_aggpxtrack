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

$user   = JFactory::getUser();
$input  = JFactory::getApplication()->input;
$params = JComponentHelper::getParams('com_aggpxtrack');
$lang   = JFactory::getLanguage();
$onClick    = '';
$fieldInput = $this->state->get('field.id');
$isMoo      = $input->getInt('ismoo', 1);

JHtml::_('formbehavior.chosen', 'select');

// Load tooltip instance without HTML support because we have a HTML tag in the tip
JHtml::_('bootstrap.tooltip', '.noHtmlTip', ['html' => false]);

// Include jQuery
JHtml::_('jquery.framework');
JHtml::_('script', 'com_aggpxtrack/popup-manager.js', false, true, false, false, true);
JHtml::_('stylesheet', 'media/popup-imagemanager.css', [], true);

if ($lang->isRtl()) {
	JHtml::_('stylesheet', 'media/popup-imagemanager_rtl.css', [], true);
}

JFactory::getDocument()->addScriptDeclaration(
	"
		var image_base_path = '" . $params->get('image_path', 'images') . "/';
	"
);

/**
 * Mootools compatibility
 *
 * There is an extra option passed in the URL for the iframe &ismoo=0 for the bootstrap fields.
 * By default the value will be 1 or defaults to mootools behaviour
 *
 * This should be removed when mootools won't be shipped by Joomla.
 */
if (!empty($fieldInput)) { // Media Form Field
	if ($isMoo) {
		$onClick = "window.parent.jInsertFieldValue(document.getElementById('f_url').value, '" . $fieldInput . "');window.parent.jModalClose();window.parent.jQuery('.modal.in').modal('hide');";
	}
} else // XTD Image plugin
{
	$onClick = 'ImageManager.onok();window.parent.jModalClose();';
}
?>
<div class="container-popup">

	<form action="index.php?option=com_media&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author'); ?>" class="form-vertical" id="imageForm" method="post" enctype="multipart/form-data">

		<div id="messages" style="display: none;">
			<span id="message"></span><?php echo JHtml::_('image', 'media/dots.gif', '...', ['width' => 22, 'height' => 12], true) ?>
		</div>

		<div class="well">
			<div class="row">
				<div class="span12 control-group">
					<div class="control-label">
						<label class="control-label" for="folder"><?php echo JText::_('COM_AGGPXTRACK_DIRECTORY') ?></label>
					</div>
					<div class="controls">
						<?php echo $this->folderList; ?>
						<div id="f_layout" style="display:none"><?php echo $params->get('aggpxtrackview', 'thumbs');?></div>
						<button class="btn" type="button" id="upbutton" title="<?php echo JText::_('COM_AGGPXTRACK_DIRECTORY_UP') ?>"><?php echo JText::_('COM_AGGPXTRACK_UP') ?></button>
					</div>
				</div>
				<div class="pull-right">
					<button class="btn btn-success button-save-selected" type="button" <?php if (!empty($onClick)) :
					// This is for Mootools compatibility ?>onclick="<?php echo $onClick; ?>"<?php
																					   endif; ?> data-dismiss="modal"><?php echo JText::_('COM_AGGPXTRACK_INSERT'); ?></button>
					<button class="btn button-cancel" type="button" onclick="window.parent.jModalClose();" data-dismiss="modal"><?php echo JText::_('JCANCEL'); ?></button>
				</div>
			</div>
		</div>

		<iframe id="imageframe" name="imageframe" src="index.php?option=com_aggpxtrack&amp;view=gpxtrackList&layout=<?php echo $params->get('aggpxtrackview', 'thumbs');?>&amp;tmpl=component&amp;folder=<?php echo $this->state->folder?>&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author');?>"></iframe>

		<div class="well">
			<div class="row">
				<div class="span6 control-group">
					<div class="control-label">
						<label for="f_url"><?php echo JText::_('COM_AGGPXTRACK_IMAGE_URL') ?></label>
					</div>
					<div class="controls">
						<input type="text" id="f_url" value="" />
					</div>
				</div>
			</div>
			<?php if (!$this->state->get('field.id')) :?>
				<div class="row">
					<div class="span6 control-group">
						<div class="control-label">
							<label for="f_alt"><?php echo JText::_('COM_AGGPXTRACK_IMAGE_DESCRIPTION') ?></label>
						</div>
						<div class="controls">
							<input type="text" id="f_alt" value="" />
						</div>
					</div>
					<div class="span6 control-group">
						<div class="control-label">
							<label for="f_title"><?php echo JText::_('COM_AGGPXTRACK_TITLE') ?></label>
						</div>
						<div class="controls">
							<input type="text" id="f_title" value="<?php echo JText::_('COM_AGGPXTRACK_TITLE_ERROR') ?>" />
						</div>
					</div>
				</div>
			<?php endif;?>

			<input type="hidden" id="dirPath" name="dirPath" />
			<input type="hidden" id="f_file" name="f_file" />
			<input type="hidden" id="tmpl" name="component" />

		</div>
	</form>

	<?php if ($user->authorise('core.create', 'com_media')) : ?>
		<form action="<?php echo JUri::base(); ?>index.php?option=com_aggpxtrack&amp;task=file.upload&amp;tmpl=component&amp;<?php echo $this->session->getName() . '=' . $this->session->getId(); ?>&amp;<?php echo JSession::getFormToken();?>=1&amp;asset=<?php echo $input->getCmd('asset'); ?>&amp;author=<?php echo $input->getCmd('author'); ?>&amp;view=images" id="uploadForm" class="form-horizontal" name="uploadForm" method="post" enctype="multipart/form-data">
			<div id="uploadform" class="well">
				<fieldset id="upload-noflash" class="actions">
					<div class="control-group">
						<div class="control-label">
							<label for="upload-file" class="control-label"><?php echo JText::_('COM_AGGPXTRACK_UPLOAD_FILE'); ?></label>
						</div>
						<div class="controls">
							<input required type="file" id="upload-file" name="Filedata[]" multiple /><button class="btn btn-primary" id="upload-submit"><span class="icon-upload icon-white"></span> <?php echo JText::_('COM_AGGPXTRACK_START_UPLOAD'); ?></button>
							<p class="help-block"><?php echo $this->config->get('upload_maxsize') == '0' ? JText::_('COM_AGGPXTRACK_UPLOAD_FILES_NOLIMIT') : JText::sprintf('COM_AGGPXTRACK_UPLOAD_FILES', $this->config->get('upload_maxsize')); ?></p>
						</div>
					</div>
				</fieldset>
				<?php JFactory::getSession()->set('com_aggpxtrack.return_url', 'index.php?option=com_aggpxtrack&view=button&tmpl=component&fieldid=' . $input->getCmd('fieldid', '') . '&e_name=' . $input->getCmd('e_name') . '&asset=' . $input->getCmd('asset') . '&author=' . $input->getCmd('author')); ?>
			</div>
		</form>
	<?php endif; ?>
</div>
