<?php

/**
 * Announcement form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AnnouncementForm extends BaseAnnouncementForm
{
    public function configure()
    {
        unset($this['created_at'],$this['updated_at']);
        unset($this['position']);
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();
        $this->setDefault("user_id",sfContext::getInstance()->getUser()->getGuardUser()->id);

        $cultureEmbed=array(sfContext::getInstance()->getUser()->getCulture());
        if($this->getObject()->getCultureTranslation())
        {
            $cultureEmbed[]=$this->getObject()->getCultureTranslation();
        }



        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');

        $this->embedI18n($cultureEmbed);

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
			</div>
	'
	));
	$this->widgetSchema->setLabels(array("image"=>"Imagen"));
	$this->validatorSchema['image'] = new sfValidatorFile(array(
	      'required' => false,
	      'mime_types' => 'web_images'
	      ));
	      $this->validatorSchema['image_delete'] = new sfValidatorPass();
	      $this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromUser");
	      $this->widgetSchema->setLabel("published","Publicar");
	      $this->widgetSchema->setHelp("published","Marca esta casilla para que se publique el anuncio.");

    }

    protected function doSave ( $con = null )
    {
        $upload = $this->getValue('image');
        $delete = $this->getValue('image_delete');

        if ( $upload )
        {

            $filename = sha1($upload->getOriginalName().microtime().rand()).$upload->getExtension($upload->getOriginalExtension());

            $thumbnailImagen = new sfThumbnail(350, 300, true, false, 75, 'sfGDAdapter');

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
            $thumbnail = new sfThumbnail(90, 60, true, false, 75, 'sfGDAdapter');
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


class AnnouncementConsumerGroupForm extends AnnouncementForm
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