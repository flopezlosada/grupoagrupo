<?php

/**
 * File form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FileForm extends BaseFileForm
{
    public function configure()
    {

        unset($this['created_at'],$this['updated_at']);
        $cultureEmbed=array(sfContext::getInstance()->getUser()->getCulture());
        if($this->getObject()->getCultureTranslation())
        {
          $cultureEmbed[]=$this->getObject()->getCultureTranslation();
        }
        
        
        
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');
        
        $this->embedI18n($cultureEmbed);
        
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();        
        $this->setDefault("user_id",sfContext::getInstance()->getUser()->getGuardUser()->id);
        $this->widgetSchema->setLabels(array("file"=>"Archivo"));
        $this->validatorSchema['file'] = new sfValidatorFile(array(
	      	'required' => $this->isNew() ? true: false,
			'path'       => sfConfig::get('sf_documents_dir'),
	      	'mime_types' => sfConfig::get('app_allowed_mime_types_uploads')));
        
        
        $this->widgetSchema['file'] = new sfWidgetFormInputFileEditable(array(
    	'file_src' => '/images/'.basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_documents_dir')).'/'.$this->getObject()->getFile(),
	    'is_image' => false,
	    'edit_mode' => strlen($this->getObject()->getFile()) > 0,
	    'template'  => '<div id="remove">
				<a href="/images/'.basename(sfConfig::get('sf_upload_dir')).'/'.basename(sfConfig::get('sf_documents_dir')).'/'
				.$this->getObject()->getFile().'">
				<img src=/images/'.basename(sfConfig::get('sf_upload_dir')).'/'.basename(sfConfig::get('sf_documents_dir')).'/'
				.basename(sfConfig::get('sf_documents_thumbnail_dir'))."/".$this->getObject()->getPrevFile().' alt="'.$this->getObject()->getName().'"></a>
				%input%</div><div class="clear"></div>'));
				$this->validatorSchema["file"]->setMessage("mime_types","Only accept pdf files");
				
				$this->widgetSchema->setLabel("published","Publicar");
				$this->widgetSchema->setHelp("published","Marca esta casilla para que se publique el archivo.");
				$this->widgetSchema->setLabel("publish_state_id","Nivel de publicación");
				$this->widgetSchema->setLabel("file","Archivo");
				$this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromUser");
    }
}

class FileConsumerGroupForm extends FileForm
{
    public function configure()
    {
        $this->widgetSchema['consumer_group_id']= new sfWidgetFormInputHidden();
        $this->setDefault("consumer_group_id",sfContext::getInstance()->getUser()->getInternalUser()->ConsumerGroup->id);
        $this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromUser");
        $this->setDefault("publish_state_id",7);//es para un grupo de consumo.
        parent::configure();
    }

    public function doSave($con=null)
    {
        if ($this->getValue('publish_state_id')!=7)
        {            
             $this->values["consumer_group_id"]=null;
        }
        parent::doSave($con);
    }
}
