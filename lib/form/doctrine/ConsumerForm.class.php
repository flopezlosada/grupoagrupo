<?php

/**
 * Consumer form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ConsumerForm extends BaseConsumerForm
{
    public function configure()
    {
        unset($this['place_id'], $this['created_at'],$this['updated_at']);
        $this->widgetSchema["distance"]=new sfWidgetFormInputHidden();
        $this->setDefault("distance",100);

        $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'),
                'add_empty' => 'Selecciona Provincia', "table_method"=>"getStateList"));



        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'City',
                'depends'   => 'State',
                'table_method' => "getCityList",
                'ajax'		=> true,
                'add_empty' => 'Selecciona Municipio'));

        $this->widgetSchema->setFormFormatterName('list');

        $this->widgetSchema->setLabel("name","Nombre");
        $this->widgetSchema->setLabel("distance","Distancia de relación");
        $this->widgetSchema->setLabel("surname","Apellidos");
        $this->widgetSchema->setLabel("address","Dirección");
        $this->widgetSchema->setLabel("state_id","Provincia");
        $this->widgetSchema->setLabel("city_id","Municipio");
        $this->widgetSchema->setLabel("cp","Código Postal");
        $this->widgetSchema->setLabel("phone","Teléfono fijo");
        $this->widgetSchema->setLabel("celular","Teléfono Móvil");
        $this->widgetSchema->setLabel("web","Página web");



        if ($this->isNew())
        {
            $this->widgetSchema["publish_state_id"]=new sfWidgetFormInputHidden();
            $this->setDefault("publish_state_id",2);
        }
        else
        {
            $this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromUser");
        }
        $this->widgetSchema->setLabel("publish_state_id","Acceso a tus datos");
        $this->widgetSchema->setHelp("publish_state_id",'Indica quién podrá ver tus datos como nombre, municipio, provincia, web y podrá contactarte. <br/>Los demás datos dirección, teléfono, móvil, email ... son privados en cualquier caso.');

        //$this->widgetSchema["information"]=new sfWidgetFormInputCheckbox();
        $this->widgetSchema->setLabel("information","¿Quieres que te informemos de las novedades de grupoagrupo.net en tu email?");
        $this->widgetSchema->setHelp("information",'Si pinchas esta casilla recibirás entre 1 y 4 emails al mes');
        $this->widgetSchema->setHelp("image",'Puedes colocar una foto para identificarte');

        $this->widgetSchema["name"]->setAttribute("class","required");
        $this->widgetSchema["web"]->setAttribute("class","url");
        $this->widgetSchema["city_id"]->setAttribute("class","required");
        $this->widgetSchema["state_id"]->setAttribute("class","required");
        $this->widgetSchema["distance"]->setAttribute("class","required");

         
        $this->widgetSchema->setHelp("web",'Debe comenzar con http://<br>Por ejemplo http://grupoagrupo.net');
        $this->widgetSchema->setHelp("distance",'Indica la distancia máxima en km para encontrar gente afín');

        $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
                'file_src' => '/images/'.basename(sfConfig::get('sf_upload_dir')).'/'
                .basename(sfConfig::get('sf_provider_dir')).'/'
                .basename(sfConfig::get('sf_provider_thumbnail_dir')).'/'.$this->getObject()->getImage(),
                'is_image' => true,
                'edit_mode' => strlen($this->getObject()->getImage()) > 0,
                'template'  => '
                <div id=remove>
                %file%
                %delete% %delete_label%
                %input%
                </div>
                '
        ));
        $this->widgetSchema['image_delete']=new sfWidgetFormInputCheckbox();
        $this->widgetSchema->setLabels(array("image"=>"Imagen"));
        //$this->widgetSchema->setHelps(array("image"=>"Tamaño obligatorio de imagen: 1266 x 4191266/419 px"));
        $this->validatorSchema['image'] = new sfValidatorFile(array(
                'required' => false,
                'mime_types' => 'web_images'
        ));
        $this->widgetSchema['image_delete']=new sfWidgetFormInputCheckbox();
        $this->validatorSchema['image_delete'] = new sfValidatorPass();
        $this->widgetSchema["image"]->setOption('delete_label',"Borrar la imagen actual");

    }

    protected function doSave ( $con = null )
    {
        $upload = $this->getValue('image');
        $delete = $this->getValue('image_delete');

        if ( $upload )
        {

            $filename = sha1($upload->getOriginalName().microtime().rand()).$upload->getExtension($upload->getOriginalExtension());

            $thumbnailImagen = new sfThumbnail(350, 350, true, false, 75, 'sfGDAdapter');

            $filepath = sfConfig::get('sf_provider_dir').'/'.$filename;

            $upload->save(sfConfig::get('sf_provider_dir').'/'.$filename);
            $thumbnailImagen->loadFile($filepath);
            $thumbnailImagen->save($filepath);
            $thumbnailpath = sfConfig::get('sf_provider_thumbnail_dir').'/'.$filename;
            $oldfilepath = sfConfig::get('sf_provider_dir').'/'.$this->getObject()->getImage();
             
            if (file_exists($oldfilepath) )
            {

                @unlink($oldfilepath);
            }
            $oldthumbnailpath = sfConfig::get('sf_provider_thumbnail_dir').'/'.$this->getObject()->getImage();

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
            $filepath = sfConfig::get('sf_provider_dir').'/'.$filename;
            @unlink($filepath);
            $thumbnailpath = sfConfig::get('sf_provider_thumbnail_dir').'/'.$filename;
            @unlink($thumbnailpath);
            $this->getObject()->setImage(null);
        }

        return parent::doSave($con);
    }

    public function updateObject($values = null)
    {
        $object = parent::updateObject($values);
        $object->setImage(str_replace(sfConfig::get('sf_provider_dir').'/', '', $object->getImage()));
        return $object;
    }
}


class ConsumerRegisterForm extends ConsumerForm
{
    public function configure()
    {
        $this->widgetSchema['email']= new sfWidgetFormInputHidden();
        $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();
        $this->setDefault("email",sfContext::getInstance()->getUser()->getGuardUser()->getEmailAddress());
        $this->setDefault("user_id",sfContext::getInstance()->getUser()->getGuardUser()->getId());

        $this->widgetSchema['consumer_state_id']= new sfWidgetFormInputHidden();
        $this->setDefault("consumer_state_id",1);

        if (!$this->isNew())
        {
            $this->widgetSchema['consumer_group_id']= new sfWidgetFormInputHidden();
            $this->setDefault("consumer_group_id",$this->getObject()->consumer_group_id);
        }
         


        if ($this->isNew()){
            $this->widgetSchema["data_protection"]=new sfWidgetFormInputCheckbox();
            $this->widgetSchema->setLabel("data_protection","¿Aceptas nuestra política de protección de datos?");
            sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
            sfContext::getInstance()->getConfiguration()->loadHelpers('Tag');
            $this->widgetSchema->setHelp("data_protection",link_to("Ver política de protección de datos","@privacity?id=4"));
            $this->validatorSchema["data_protection"]=new sfValidatorPass();
            $this->widgetSchema["data_protection"]->setAttribute("class","required");
            if (sfContext::getInstance()->getRequest()->hasParameter("invited_for_consumer_group_id"))
            {
                $this->widgetSchema['consumer_group_id']= new sfWidgetFormInputHidden();
                $this->setDefault("consumer_group_id",sfContext::getInstance()->getRequest()->getParameter("invited_for_consumer_group_id"));
                $this->setDefault("consumer_state_id",2);
            }
        }

        parent::configure();
    }
}