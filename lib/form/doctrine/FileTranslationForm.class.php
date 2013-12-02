<?php

/**
 * FileTranslation form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FileTranslationForm extends BaseFileTranslationForm
{
  public function configure()
  {
    $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(array('config' => sfConfig::get('app_tiny_mce_simple')));
    $this->widgetSchema->setLabel("content","Descripción");
    $this->widgetSchema->setLabel("name","Nombre");
  }
}
