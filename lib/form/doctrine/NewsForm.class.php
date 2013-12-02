<?php

/**
 * News form.
 *
 * @package    webs_proyectos
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsForm extends BaseNewsForm
{
    public function configure()
    {
        $this->setDefault("category_id",sfContext::getInstance()->getRequest()->getParameter("category_id"));
        unset($this['position']);
        unset($this["created_at"], $this["updated_at"]);
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
                %input%<br />
                %delete% %delete_label%
                </div>'));
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

            $thumbnailImagen = new sfThumbnail(300, 300,false, false, 75, 'sfGDAdapter', array('method' => 'shave_all'));

            $filepath = sfConfig::get('sf_upload_dir').'/'.$filename;

            $upload->save(sfConfig::get('sf_upload_dir').'/'.$filename);
            $thumbnailImagen->loadFile($filepath);
            $thumbnailImagen->save($filepath);
            $thumbnailpath = sfConfig::get('sf_thumbnail_dir').'/'.$filename;
            $viewsizepath = sfConfig::get('sf_viewsize_dir').'/'.$filename;


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

            $oldviewsizepath = sfConfig::get('sf_viewsize_dir').'/'.$this->getObject()->getImage(); 
            if ( file_exists($oldviewsizepath) )
            {
                @unlink($oldviewsizepath);
            }

            $thumbnail = new sfThumbnail(100, 100,false, true, 75, 'sfGDAdapter', array('method' => 'shave_all'));
            $thumbnail->loadFile($filepath);
            $thumbnail->save($thumbnailpath);

            $viewSize = new sfThumbnail(200, 200,false, true, 75, 'sfGDAdapter', array('method' => 'shave_all'));
            $viewSize->loadFile($filepath);
            $viewSize->save($viewsizepath);

            //$upload->save($filepath);
        }


        else if ( $delete )
        {

            $filename = $this->getObject()->getImage();
            $filepath = sfConfig::get('sf_upload_dir').'/'.$filename;
            @unlink($filepath);
            $thumbnailpath = sfConfig::get('sf_thumbnail_dir').'/'.$filename;
            @unlink($thumbnailpath);
            $viewsizepath = sfConfig::get('sf_viewsize_dir').'/'.$filename;
            @unlink($viewsizepath);
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
