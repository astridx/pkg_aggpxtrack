<?php
/**
 * @package     Joomla.Site
 * @subpackage  pkg_aggpxtrack
 *
 * @copyright   Copyright (C) Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormHelper;

/**
 * Fields Aggpxtrack Plugin
 *
 * @since  3.7.0
 */
class PlgFieldsAggpxtrack extends \Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin
{
    /**
     * Constructor
     *
     * @param   object  &$subject  The object to observe
     * @param   array   $config    An array that holds the plugin configuration
     *
     * @since   1.5
     */
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

        FormHelper::addFieldPath(__DIR__ . '/field');
    }
}