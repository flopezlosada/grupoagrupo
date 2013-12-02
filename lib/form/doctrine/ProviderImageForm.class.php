<?php

/**
 * ProviderImage form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProviderImageForm extends BaseProviderImageForm
{
    public function configure()
    {
        unset($this['position']);
         unset($this['slug']);
        unset($this["created_at"], $this["updated_at"]);
        $this->widgetSchema['provider_id']=new sfWidgetFormInputHidden();
        $class=sfContext::getInstance()->getUser()->getProfile()->InternalClass->class;
        $this->setDefault("provider_id",sfContext::getInstance()->getUser()->getGuardUser()->$class->getId());
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
        array(
		'config' => sfConfig::get('app_tiny_mce_simple')));
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

    }

    protected function doSave ( $con = null )
    {
        $upload = $this->getValue('image');
        $delete = $this->getValue('image_delete');

        if ( $upload )
        {

            $filename = sha1($upload->getOriginalName().microtime().rand()).$upload->getExtension($upload->getOriginalExtension());

            $thumbnailImagen = new sfThumbnail(590, 500, true, false, 75, 'sfGDAdapter');

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
            $thumbnail = new sfThumbnail(90, 90, true, false, 75, 'sfGDAdapter');
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