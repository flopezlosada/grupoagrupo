<?php

/**
 * Provider form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProviderForm extends BaseProviderForm
{
    public function configure()
    {
        unset($this['place_id'], $this['created_at'],$this['updated_at']);
        unset($this["product_list"],$this["acepted_provider_consumer_group_list"]);
        $this->widgetSchema->setFormFormatterName('list');
        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
                array(
                        'config' => sfConfig::get('app_tiny_mce_simple')));
        $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'),
                'add_empty' => 'Selecciona Provincia', "table_method"=>"getStateList"));

        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'City',
                'depends'   => 'State',
                'table_method' => "getCityList",
                'ajax'		=> true,
                'add_empty' => 'Selecciona Municipio'));

        $this->widgetSchema->setHelp("web",'Debe comenzar con http://<br>Por ejemplo http://grupoagrupo.net');
        $this->validatorSchema['web'] = new sfValidatorUrl(array("required"=>false));

        $this->widgetSchema->setLabel("content","Descripción de la actividad");
        $this->widgetSchema->setLabel("address","Dirección");
        $this->widgetSchema->setLabel("state_id","Provincia");
        $this->widgetSchema->setLabel("city_id","Municipio");
        $this->widgetSchema->setLabel("cp","Código Postal");
        $this->widgetSchema->setLabel("phone","Teléfono fijo");
        $this->widgetSchema->setLabel("celular","Teléfono Móvil");
        $this->widgetSchema->setLabel("web","Página web");
        $this->widgetSchema->setLabel("payment_method_list","Métodos de pago aceptados");
        $this->widgetSchema->setLabel("shipping_mode_list","Formas de envío posibles");


        $this->widgetSchema["shipping_mode_list"]->setOption("expanded",true);
        $this->widgetSchema["payment_method_list"]->setOption("expanded",true);

         

        $this->widgetSchema["segregated_orders"]=new sfWidgetFormInputCheckbox();
        $this->widgetSchema->setLabel("segregated_orders","¿Aceptas pedidos segregados?");
        $this->widgetSchema->setHelp("segregated_orders",'Se refiere a separar los pedidos por cada una/o de las/os consumidoras/es del grupo');

        $this->widgetSchema->setLabel("publish_state_id","Nivel de publicación");
        $this->widgetSchema->setHelp("publish_state_id",'Indica quién podrá ver tus datos como teléfono, móvil, email y podrá contactarte');

        if (sfContext::getInstance()->getUser()->hasCredential("producer")||sfContext::getInstance()->getUser()->hasCredential("distributor"))
        {
            //$this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromUser");
            $this->widgetSchema["publish_state_id"]=new sfWidgetFormInputHidden();
            $this->setDefault("publish_state_id",2);
        }

        $this->widgetSchema["information"]=new sfWidgetFormInputCheckbox();
        $this->widgetSchema->setLabel("information","¿Quieres recibir información?");
        $this->widgetSchema->setHelp("information",'Si pinchas esta casilla te mantendremos informada/o de las novedades de Grupo a Grupo');


        $this->widgetSchema["name"]->setAttribute("class","required");
        $this->widgetSchema["web"]->setAttribute("class","url");
        $this->widgetSchema["city_id"]->setAttribute("class","required");
        $this->widgetSchema["state_id"]->setAttribute("class","required");
         
        if ($this->isNew()){
            $this->widgetSchema["data_protection"]=new sfWidgetFormInputCheckbox();
            $this->widgetSchema->setLabel("data_protection","¿Aceptas nuestra política de protección de datos?");
            sfContext::getInstance()->getConfiguration()->loadHelpers('Url');
            sfContext::getInstance()->getConfiguration()->loadHelpers('Tag');
            $this->widgetSchema->setHelp("data_protection",link_to("Ver política de protección de datos","static/privacity"));
            $this->validatorSchema["data_protection"]=new sfValidatorPass();
            $this->widgetSchema["data_protection"]->setAttribute("class","required");
        }

        $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
                'file_src' => '/images/'.basename(sfConfig::get('sf_upload_dir')).'/'
                .basename(sfConfig::get('sf_provider_dir')).'/'
                .basename(sfConfig::get('sf_provider_thumbnail_dir')).'/'.$this->getObject()->getImage(),
                'is_image' => true,
                'edit_mode' => strlen($this->getObject()->getImage()) > 0,
                'template'  => '
                <div id=remove>
                %file%
                %input%
                </div>
                '
        ));
        $this->widgetSchema->setLabels(array("image"=>"Imagen"));
        //$this->widgetSchema->setHelps(array("image"=>"Tamaño obligatorio de imagen: 1266 x 4191266/419 px"));
        $this->validatorSchema['image'] = new sfValidatorFile(array(
                'required' => false,
                'mime_types' => 'web_images'
        ));
         


         
        $this->widgetSchema->setLabel("name","Nombre Comercial");
        $this->widgetSchema->setLabel("surname","Apellidos de la persona de contacto");
        $this->widgetSchema->setLabel("contact","Nombre de la persona de contacto");
        $this->widgetSchema->setHelp("image",'Puedes colocar aquí tu logotipo o una foto para identificarte');
         
        /*$this->widgetSchema['place_id'] = new sfWidgetFormDoctrineDependentSelect(array(
         'model'     => 'Place',
                'depends'   => 'City',
                'add_empty' => 'Selecciona Localidad'));*/

        $this->validatorSchema["payment_method_list"]->setOption("required",true);
        $this->validatorSchema["shipping_mode_list"]->setOption("required",true);
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


class ProviderRegisterForm extends ProviderForm
{
    public function configure()
    {
        unset($this["product_list"],$this["acepted_provider_consumer_group_list"]);
        $this->widgetSchema['email']= new sfWidgetFormInputHidden();
        $this->widgetSchema['provider_state_id']= new sfWidgetFormInputHidden();
        $this->widgetSchema['provider_type_id']= new sfWidgetFormInputHidden();
        $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();
        $this->setDefault("email",sfContext::getInstance()->getUser()->getGuardUser()->getEmailAddress());
        $this->setDefault("user_id",sfContext::getInstance()->getUser()->getGuardUser()->getId());
        $this->setDefault("provider_state_id",1);
        if (sfContext::getInstance()->getUser()->hasCredential("producer")){
            $this->setDefault("provider_type_id",1);
        } else if (sfContext::getInstance()->getUser()->hasCredential("distributor")){
            $this->setDefault("provider_type_id",2);
        }

        parent::configure();
    }
}