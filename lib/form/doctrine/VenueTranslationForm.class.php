<?php

/**
 * VenueTranslation form.
 *
 * @package    palestina
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VenueTranslationForm extends BaseVenueTranslationForm
{
    public function configure()
    {
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');
        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
        array(
		'config' => sfConfig::get('app_tiny_mce_simple')
        ));
    }
}
