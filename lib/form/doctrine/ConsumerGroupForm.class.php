<?php

/**
 * ConsumerGroup form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ConsumerGroupForm extends BaseConsumerGroupForm
{
    public function configure()
    {
        unset($this['place_id'], $this['created_at'],$this['updated_at']);
        $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'),
       'add_empty' => 'Selecciona Provincia', "table_method"=>"getStateList"));
        $this->widgetSchema["distance"]=new sfWidgetFormInputHidden();
        $this->setDefault("distance",100);
        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
        array(
		'config' => sfConfig::get('app_tiny_mce_simple')));

        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
         'model'     => 'City',
         'depends'   => 'State',        
         'table_method' => "getCityList",         
         'ajax'		=> true,
         'add_empty' => 'Selecciona Municipio'));

        $this->widgetSchema->setFormFormatterName('list');
        $this->validatorSchema["web"]->setOption("required",false);

        $this->widgetSchema->setLabel("name","Nombre");
        $this->widgetSchema->setLabel("email","Correo electrónico del grupo");
        $this->widgetSchema->setLabel("content","Descripción del grupo");
        $this->widgetSchema->setLabel("distance","Distancia de relación");
        $this->widgetSchema->setLabel("address","Dirección");
        $this->widgetSchema->setLabel("state_id","Provincia");
        $this->widgetSchema->setLabel("city_id","Municipio");
        $this->widgetSchema->setLabel("cp","Código Postal");
        $this->widgetSchema->setLabel("web","Página web");
        $this->widgetSchema->setLabel("publish_state_id","Nivel de publicación");
        $this->widgetSchema->setHelp("publish_state_id",'Indica quién podrá ver los datos del grupo y podrá contactaros');
        $this->widgetSchema["publish_state_id"]->setOption("table_method","getPublishStatesFromGroup");
        $this->widgetSchema["web"]->setAttribute("class","url");
        $this->widgetSchema->setHelp("web",'Debe comenzar con http://<br>Por ejemplo http://grupoagrupo.net');
         

         

        $this->widgetSchema["name"]->setAttribute("class","required");
         
        $this->widgetSchema["city_id"]->setAttribute("class","required");
        $this->widgetSchema["state_id"]->setAttribute("class","required");
        //$this->widgetSchema["distance"]->setAttribute("class","required");

         
        $this->widgetSchema->setHelp("distance",'Indica la distancia máxima en km para encontrar gente afín');
        $this->widgetSchema->setHelp("email",'Si quieres indicar un correo electrónico para la comunicación con el grupo. Si no indicas ninguno, se tomará el email de la/el responsable
        del grupo para la comunicación con el grupo de consumo.');


        $this->validatorSchema["email"]->setOption("required",false);


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
			</div>'));
    	$this->widgetSchema->setLabels(array("image"=>"Imagen"));
    	//$this->widgetSchema->setHelps(array("image"=>"Tamaño obligatorio de imagen: 1266 x 4191266/419 px"));
    	$this->validatorSchema['image'] = new sfValidatorFile(array(
	      'required' => false,
	      'mime_types' => 'web_images'));
    	$this->widgetSchema->setHelp("image",'Puedes colocar una foto para identificaros');

    	$this->widgetSchema['image_delete']=new sfWidgetFormInputCheckbox();
    	$this->validatorSchema['image_delete'] = new sfValidatorPass();
    	$this->widgetSchema["image"]->setOption('delete_label',"Borrar la imagen actual");

    	$this->widgetSchema["segregated_orders"]=new sfWidgetFormInputCheckbox();
    	$this->widgetSchema->setLabel("segregated_orders","¿Realizáis pedidos segregados?");
    	$this->widgetSchema->setHelp("segregated_orders",'Se refiere a separar los pedidos por cada una/o de las/os consumidoras/es del grupo');
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

class ConsumerGroupRegisterForm extends ConsumerGroupForm
{
    public function configure()
    {

        unset($this["user_id"],$this['acepted_provider_consumer_group_list']);
        $this->widgetSchema['consumer_trust_id']= new sfWidgetFormInputHidden();

        $class=sfContext::getInstance()->getUser()->getProfile()->InternalClass->class;
        $this->setDefault("consumer_trust_id",sfContext::getInstance()->getUser()->getGuardUser()->$class->getId());

        $this->widgetSchema['consumer_group_state_id']= new sfWidgetFormInputHidden();
        $this->setDefault("consumer_group_state_id",1);


        if (!$this->isNew())
        {
            $this->widgetSchema['position']= new sfWidgetFormInputHidden();
            $this->setDefault("position",$this->getObject()->position);
        }

        parent::configure();
    }


}
