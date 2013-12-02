<?php

/**
 * Product form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductForm extends BaseProductForm
{
    public function configure()
    {
        unset($this['position']);
        unset($this['product_list_list']);
        unset($this["created_at"], $this["updated_at"]);

        $cultureEmbed=array(sfContext::getInstance()->getUser()->getCulture());
        if($this->getObject()->getCultureTranslation())
        {
            $cultureEmbed[]=$this->getObject()->getCultureTranslation();
        }

        $this->widgetSchema['product_subcategory_id'] = new sfWidgetFormDoctrineDependentSelect(array(
             'model'     => 'ProductSubcategory',
             'depends'   => 'ProductCategory',
             'ajax'		=> true,
             'add_empty' => 'Selecciona Subcategoría'));

        $this->widgetSchema['product_category_id']->addOption("add_empty","Selecciona Categoría");
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sf_admin');

        $this->embedI18n($cultureEmbed);

        $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
    	'file_src' => '/images/'.basename(sfConfig::get('sf_upload_dir')).'/'
    	.basename(sfConfig::get('sf_product_dir')).'/'
    	.basename(sfConfig::get('sf_product_thumbnail_dir')).'/'.$this->getObject()->getImage(),
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
	//$this->widgetSchema->setHelps(array("image"=>"Tamaño obligatorio de imagen: 1266 x 4191266/419 px"));
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

            $thumbnailImagen = new sfThumbnail(350, 350, true, false, 75, 'sfGDAdapter');

            $filepath = sfConfig::get('sf_product_dir').'/'.$filename;

            $upload->save(sfConfig::get('sf_product_dir').'/'.$filename);
            $thumbnailImagen->loadFile($filepath);
            $thumbnailImagen->save($filepath);
            $thumbnailpath = sfConfig::get('sf_product_thumbnail_dir').'/'.$filename;
            $oldfilepath = sfConfig::get('sf_product_dir').'/'.$this->getObject()->getImage();
             
            if (file_exists($oldfilepath) )
            {

                @unlink($oldfilepath);
            }
            $oldthumbnailpath = sfConfig::get('sf_product_thumbnail_dir').'/'.$this->getObject()->getImage();

            if ( file_exists($oldthumbnailpath) )
            {
                @unlink($oldthumbnailpath);
            }
            $thumbnail = new sfThumbnail(100, 66, true, false, 75, 'sfGDAdapter');
            $thumbnail->loadFile($filepath);
            $thumbnail->save($thumbnailpath);
            //$upload->save($filepath);
        }


        else if ( $delete )
        {

            $filename = $this->getObject()->getImage();
            $filepath = sfConfig::get('sf_product_dir').'/'.$filename;
            @unlink($filepath);
            $thumbnailpath = sfConfig::get('sf_product_thumbnail_dir').'/'.$filename;
            @unlink($thumbnailpath);
            $this->getObject()->setImage(null);
        }

        return parent::doSave($con);
    }

    public function updateObject($values = null)
    {
        $object = parent::updateObject($values);
        $object->setImage(str_replace(sfConfig::get('sf_product_dir').'/', '', $object->getImage()));
        return $object;
    }
}
