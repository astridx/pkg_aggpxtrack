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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\MediaHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

extract($displayData);

$attr = '';

// Initialize some field attributes.
$attr .= !empty($class) ? ' class="form-control field-media-input ' . $class . '"' : ' class="form-control field-media-input"';
$attr .= !empty($size) ? ' size="' . $size . '"' : '';
$attr .= $dataAttribute;

// Initialize JavaScript field attributes.
$attr .= !empty($onchange) ? ' onchange="' . $onchange . '"' : '';

switch ($preview) {
	case 'no': // Deprecated parameter value
	case 'false':
	case 'none':
		$showPreview = false;
		break;
	case 'yes': // Deprecated parameter value
	case 'true':
	case 'show':
	case 'tooltip':
	default:
		$showPreview = true;
		break;
}

// The url for the modal
$url = ($readonly ? ''
	: ($link ?: 'index.php?option=com_media&view=media&tmpl=component&mediatypes=' . $mediaTypes
		. '&asset=' . $asset . '&author=' . $authorId)
	. '&fieldid={field-media-id}&path=' . $folder);

// Correctly route the url to ensure it's correctly using sef modes and subfolders
$url = Route::_($url);
$doc = Factory::getDocument();
$wam = $doc->getWebAssetManager();

$wam->useScript('webcomponent.media-select');

Text::script('JFIELD_MEDIA_LAZY_LABEL');
Text::script('JFIELD_MEDIA_ALT_LABEL');
Text::script('JFIELD_MEDIA_ALT_CHECK_LABEL');
Text::script('JFIELD_MEDIA_ALT_CHECK_DESC_LABEL');
Text::script('JFIELD_MEDIA_CLASS_LABEL');
Text::script('JFIELD_MEDIA_FIGURE_CLASS_LABEL');
Text::script('JFIELD_MEDIA_FIGURE_CAPTION_LABEL');
Text::script('JFIELD_MEDIA_LAZY_LABEL');
Text::script('JFIELD_MEDIA_SUMMARY_LABEL');
Text::script('JFIELD_MEDIA_EMBED_CHECK_DESC_LABEL');
Text::script('JFIELD_MEDIA_DOWNLOAD_CHECK_DESC_LABEL');
Text::script('JFIELD_MEDIA_DOWNLOAD_CHECK_LABEL');
Text::script('JFIELD_MEDIA_EMBED_CHECK_LABEL');
Text::script('JFIELD_MEDIA_WIDTH_LABEL');
Text::script('JFIELD_MEDIA_TITLE_LABEL');
Text::script('JFIELD_MEDIA_HEIGHT_LABEL');
Text::script('JFIELD_MEDIA_UNSUPPORTED');
Text::script('JFIELD_MEDIA_DOWNLOAD_FILE');
Text::script('JLIB_APPLICATION_ERROR_SERVER');
Text::script('JLIB_FORM_MEDIA_PREVIEW_EMPTY', true);

$modalHTML = HTMLHelper::_(
	'bootstrap.renderModal',
	'imageModal_' . $id,
	[
		'url'         => $url,
		'title'       => Text::_('JLIB_FORM_CHANGE_IMAGE'),
		'closeButton' => true,
		'height'      => '100%',
		'width'       => '100%',
		'modalWidth'  => '80',
		'bodyHeight'  => '60',
		'footer'      => '<button type="button" class="btn btn-success button-save-selected">' . Text::_('JSELECT') . '</button>'
			. '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . Text::_('JCANCEL') . '</button>',
	]
);

$wam->useStyle('webcomponent.field-media')
	->useScript('webcomponent.field-media');

if (count($doc->getScriptOptions('media-picker')) === 0) {
	$doc->addScriptOptions('media-picker', [
		'images'    => $imagesExt,
		'audios'    => $audiosExt,
		'videos'    => $videosExt,
		'documents' => $documentsExt,
	]);
}

?>

<joomla-field-media class="field-media-wrapper" type="image" <?php // @TODO add this attribute to the field in order to use it for all media types
																															?> base-path="<?php echo Uri::root(); ?>" root-folder="<?php echo ComponentHelper::getParams('com_media')->get('file_path', 'images'); ?>" url="<?php echo $url; ?>" modal-container=".modal" modal-width="100%" modal-height="400px" input=".field-media-input" button-select=".button-select" button-clear=".button-clear" button-save-selected=".button-save-selected" preview="static" preview-container=".field-media-preview" preview-width="<?php echo $previewWidth; ?>" preview-height="<?php echo $previewHeight; ?>" supported-extensions="<?php echo str_replace('"', '&quot;', json_encode(['images' => $imagesAllowedExt, 'audios' => $audiosAllowedExt, 'videos' => $videosAllowedExt, 'documents' => $documentsAllowedExt])); ?>">
	<?php echo $modalHTML; ?>
	<?php if ($showPreview) : ?>
		<div class="field-media-preview">
			<?php echo ' ' . $previewImgEmpty; ?>
			<?php echo ' ' . $previewImg; ?>
		</div>
	<?php endif; ?>
	<div class="input-group">
		<input type="text" name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>" readonly="readonly" <?php echo $attr; ?>>
		<?php if ($disabled != true) : ?>
			<button type="button" class="btn btn-success button-select"><?php echo Text::_('JLIB_FORM_BUTTON_SELECT'); ?></button>
			<button type="button" class="btn btn-danger button-clear"><span class="icon-times" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('JLIB_FORM_BUTTON_CLEAR'); ?></span></button>
		<?php endif; ?>
	</div>
</joomla-field-media>



