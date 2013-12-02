<?php

/**
 * Event form.
 *
 * @package    palestina
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventForm extends BaseEventForm
{
    public function configure()
    {
        unset($this['position']);
        unset($this["created_at"], $this["updated_at"]);
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();
        $this->setDefault("user_id",sfContext::getInstance()->getUser()->getGuardUser()->id);
        $cultureEmbed=array(sfContext::getInstance()->getUser()->getCulture());
        if($this->getObject()->getCultureTranslation())
        {
            $cultureEmbed[]=$this->getObject()->getCultureTranslation();
        }

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');
        $this->widgetSchema["event_category_id"]->setOption("add_empty",true);
        $this->embedI18n($cultureEmbed);

        //$this->widgetSchema['date']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es"));
        //$this->widgetSchema['end_date']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es"));
        //$this->widgetSchema['recurrence_end']= new sfWidgetFormDateJQueryUI(array("change_month" => true, "change_year" => true,"culture"=>"es"));

        $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
    	'file_src' => '/images/'.basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_thumbnail_dir')).'/'.$this->getObject()->getImage(),
	    'is_image' => true,
	    'edit_mode' => strlen($this->getObject()->getImage()) > 0,
	    'template'  => '
			<div id=remove>
				%file%
				%input%
				%delete% %delete_label%
			</div>'));
    	$this->widgetSchema->setLabels(array("image"=>"Imagen"));
    	$this->validatorSchema['image'] = new sfValidatorFile(array(
	      'required' => false,
	      'mime_types' => 'web_images'
	      ));
	      //$this->validatorSchema['image_delete'] = new sfValidatorPass();
	      $this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromUser");
	      $this->widgetSchema->setLabel("publish_state_id","¿A quién va dirigido?");
	      
	      $this->widgetSchema->setLabel("event_category_id","Categoría");
	      $this->widgetSchema->setLabel("start_date","Fecha y hora de inicio");
	      $this->widgetSchema->setHelp("start_date","Indica la fecha y hora de inicio del evento.");
	      $this->widgetSchema->setLabel("end_date","Fecha y hora de finalización");
	      $this->widgetSchema->setHelp("end_date","Indica la fecha y hora de finalización del evento.");
	      $this->widgetSchema->setLabel("published","Publicar");
	      $this->widgetSchema->setHelp("published","Marca esta casilla para que se publique el evento.");	      
    }

    protected function doSave ( $con = null )
    {
        $upload = $this->getValue('image');
        $delete = $this->getValue('image_delete');

        if ( $upload )
        {

            $filename = sha1($upload->getOriginalName().microtime().rand()).$upload->getExtension($upload->getOriginalExtension());

            $thumbnailImagen = new sfThumbnail(320, 320, true, false, 75, 'sfGDAdapter');

            $filepath = sfConfig::get('sf_upload_dir').'/'.$filename;

            $upload->save(sfConfig::get('sf_upload_dir').'/'.$filename);
            $thumbnailImagen->loadFile($filepath);
            $thumbnailImagen->save($filepath);
            $thumbnailpath = sfConfig::get('sf_thumbnail_dir').'/'.$filename;



            $oldfilepath = sfConfig::get('sf_upload_dir').'/'.$this->getObject()->getImage();
            if (file_exists($oldfilepath) )
            {

                @unlink($oldfilepath);
            }

            $oldthumbnailpath = sfConfig::get('sf_thumbnail_dir').'/'.$this->getObject()->getImage();
            if ( file_exists($oldthumbnailpath) )
            {
                @unlink($oldthumbnailpath);
            }



            $thumbnail = new sfThumbnail(100, 100, true, false, 75, 'sfGDAdapter');
            $thumbnail->loadFile($filepath);
            $thumbnail->save($thumbnailpath);



            //$upload->save($filepath);
        }


        else if ( $delete )
        {

            $filename = $this->getObject()->getImage();
            $filepath = sfConfig::get('sf_upload_dir').'/'.$filename;
            @unlink($filepath);
            $thumbnailpath = sfConfig::get('sf_thumbnail_dir').'/'.$filename;
            @unlink($thumbnailpath);
            $this->getObject()->setImage(null);
        }
        return parent::doSave($con);
    }

    public function updateObject($values = null)
    {
        $object = parent::updateObject($values);
        $object->setImage(str_replace(sfConfig::get('sf_upload_dir').'/', '', $object->getImage()));
        return $object;
    }
}


class EventConsumerGroupForm extends EventForm
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