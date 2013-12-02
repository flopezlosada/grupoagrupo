<?php

/**
 * ProviderProduct form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     info@diphda.net
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProviderProductForm extends BaseProviderProductForm
{
    public function configure()
    {
        unset($this['position']);

        unset($this["created_at"], $this["updated_at"], $this["is_highlight"]);
        $this->widgetSchema["provider_product_type_id"]=new sfWidgetFormInputHidden();
        $this->setDefault("provider_product_type_id", 1);
        /*$this->widgetSchema['seasson_start']= new sfWidgetFormChoice(array("choices"=>sfConfig::get("app_month_list")));
         $this->widgetSchema['seasson_end']= new sfWidgetFormChoice(array("choices"=>sfConfig::get("app_month_list")));*/
        $this->widgetSchema->setFormFormatterName('list');

        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(
                array(
                        'config' => sfConfig::get('app_tiny_mce_simple')));
        if ($this->isNew())
        {
            $this->widgetSchema['product_subcategory_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'ProductSubcategory',
                    'depends'   => 'ProductCategory',
                    'table_method' => "getSubcategoryList",
                    'ajax'		=> true,
                    'add_empty' => 'Subcategoría ...'));

            $this->widgetSchema['product_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Product',
                    'depends'   => 'ProductSubcategory',
                    //'table_method' => "getProductList",
                    'ajax'		=> true,
                    'add_empty' => 'Producto ...'));


            $this->widgetSchema['product_category_id']->setOption("add_empty","Categoría ...");
            $this->widgetSchema['product_category_id']->setOption("table_method","getCategoryList");

            /*
             * esta función sólo para los productores y distribuidores.
            * -----Es para que no introduzcan un producto repetido ya que esta función devuelve sólo los que no han introducido anteriormente---
            * Esto lo hemos cambiado, ahora sí que se pueden mostrar productos ya catalogados porque hay variedades de producto.
            */
            if ((sfContext::getInstance()->getUser()->hasCredential("producer")||sfContext::getInstance()->getUser()->hasCredential("distributor"))
                    && sfContext::getInstance()->getModuleName()=="product")
            {
                $this->widgetSchema['product_id']->setOption("table_method","getProductList");
            }
             
        }
        else {
            $this->widgetSchema['product_id'] = new sfWidgetFormInputTextObject(array("model"=>"Product"));
            $this->widgetSchema['product_category_id'] = new sfWidgetFormInputTextObject(array("model"=>"ProductCategory"));
            $this->widgetSchema['product_subcategory_id'] = new sfWidgetFormInputTextObject(array("model"=>"ProductSubcategory"));
        }

        $this->widgetSchema['provider_id']=new sfWidgetFormInputHidden();
        if (sfContext::getInstance()->getUser()->isAuthenticated()){
            $class=sfContext::getInstance()->getUser()->getProfile()->InternalClass->class;
            $this->setDefault("provider_id",sfContext::getInstance()->getUser()->getGuardUser()->$class->getId());
        }
        $this->widgetSchema['is_active']=new sfWidgetFormInputHidden();
        $this->setDefault("is_active",1);

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
                </div>
                '
        ));
        $this->widgetSchema->setLabels(array("image"=>"Imagen"));

        $this->validatorSchema['image'] = new sfValidatorFile(array(
                'required' => false,
                'mime_types' => 'web_images'
        ));
        $this->widgetSchema->setHelp("image",'Puedes colocar aquí una imagen de tu producto. Si no pones ninguna, aparecerá una por defecto.');

        if (sfContext::getInstance()->getUser()->hasCredential("distributor")){
            $this->widgetSchema->setLabel("country_id","País de procedencia del producto");
            $this->widgetSchema->setLabel("state_id","Provincia de procedencia del producto");
            $this->widgetSchema["country_id"]->setOption("table_method","getOrderedCountries");
            if (sfContext::getInstance()->getUser()->hasCredential("producer")){
                $this->widgetSchema->setLabel("provider_type_id","Indica tu actividad para este producto");
                $this->widgetSchema->setHelp("provider_type_id","Debes indicar si eres la/el productora/or o la/el distribuidora/or de este producto");
            }
            else {
                $this->widgetSchema["provider_type_id"]=new sfWidgetFormInputHidden();
                $this->setDefault("provider_type_id", 2);
            }
        }
        elseif (sfContext::getInstance()->getUser()->hasCredential("producer")){
            unset($this["country_id"]);
            unset($this["state_id"]);
            unset($this["provider_type_id"]);
        }

        $this->widgetSchema->setLabel("product_category_id","Categoría");
        $this->widgetSchema->setLabel("product_subcategory_id","Subcategoría");
        $this->widgetSchema->setLabel("product_id","Producto");
        $this->widgetSchema->setHelp("product_id",'');
        $this->widgetSchema->setLabel("short_description","Descripción corta");
        $this->widgetSchema->setHelp("short_description",'Debes indicar aquí una breve descripción de tu producto. Es la que aparecerá en el listado del catálogo');
        $this->widgetSchema->setLabel("content","Descripción");
        $this->widgetSchema->setHelp("content",'Puedes indicar aquí una descripción de tu producto. Si no colocas ninguna, se mostrará una por defecto.');
        $this->widgetSchema->setLabel("purchase_unit_id","Unidad de venta");
        $this->widgetSchema->setLabel("price","Precio");
        $this->widgetSchema->setHelp("price",'Precio final de la unidad de venta en euros (€). Impuestos incluidos');
        $this->widgetSchema->setLabel("price","Precio");
        $this->widgetSchema->setLabel("is_in_stock","¿Disponible?");
        $this->widgetSchema->setHelp("is_in_stock","Indica si el producto está disponible");

        /*$this->widgetSchema->setLabel("weight","Peso");
         $this->widgetSchema->setHelp("weight",'En kilogramos, con 3 decimales si es necesario');*/
        /*$this->widgetSchema->setLabel("seasson_start","Inicio de la época de venta");
         $this->widgetSchema->setLabel("seasson_end","Fin de la época de venta");*/
        $this->widgetSchema->setLabel("product_size_id","Talla");
        $this->widgetSchema->setHelp("product_size_id",'Sólo para ropa');
        /* $this->widgetSchema->setLabel("group_discount","Descuento para grupos de consumo");
         $this->widgetSchema->setHelp("group_discount",'Indica el descuento en tanto por ciento (%) para compras de grupos de consumo');*/
        $this->widgetSchema->setLabel("production_type_id","Tipo de producción");

        $this->widgetSchema['is_in_stock']->setAttribute('checked',1);
        $this->validatorSchema['purchase_unit_id']->addOption('required',true);
        $this->validatorSchema['production_type_id']->addOption('required',true);
    }

    protected function doSave ( $con = null )
    {
        $upload = $this->getValue('image');
        $delete = $this->getValue('image_delete');

        if ( $upload )
        {

            $filename = sha1($upload->getOriginalName().microtime().rand()).$upload->getExtension($upload->getOriginalExtension());

            $thumbnailImagen = new sfThumbnail(300, 300,false, false, 75, 'sfImageMagickAdapter', array('method' => 'shave_all'));

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
            $thumbnail = new sfThumbnail(100, 100,false, true, 75, 'sfImageMagickAdapter', array('method' => 'shave_all'));
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

class SearchProviderProductForm extends ProviderProductForm
{
    public function configure()
    {
        parent::configure();
        $this->useFields(array("product_category_id","product_subcategory_id","product_id"));
        unset($this["provider_id"]);
    }
}

class BasketForm extends ProviderProductForm
{
    public function configure()
    {
        parent::configure();
        unset($this['purchase_unit_id']);
        unset($this['production_type_id']);
        $this->setDefault("provider_product_type_id", 2);//para las cestas es 2
         $this->widgetSchema['product_id' ]=new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false,"table_method"=>"getProductBasket"));
        $this->widgetSchema['product_subcategory_id']=new  sfWidgetFormInputHidden();
        $this->setDefault("product_subcategory_id", 64);
        $this->widgetSchema['product_category_id']=new  sfWidgetFormInputHidden();
        $this->setDefault("product_category_id", 10);
        $this->widgetSchema->setHelp("image",'Puedes colocar aquí una imagen de tu cesta. Es muy recomendable');

        $this->widgetSchema->setLabel("short_description","Nombre");
        $this->widgetSchema->setHelp("short_description",'Debes indicar aquí un nombre para la cesta. Es el que aparecerá en el listado del catálogo');
        $this->widgetSchema->setLabel("content","Descripción");
        $this->widgetSchema->setHelp("content",'Puedes indicar aquí una descripción de tu producto. Si no colocas ninguna, se mostrará una por defecto.');
        $this->widgetSchema->setLabel("price","Precio");
        $this->widgetSchema->setHelp("price",'Precio final de la unidad de venta en euros (€). Impuestos incluidos');
        $this->widgetSchema->setLabel("price","Precio");
        $this->widgetSchema->setLabel("is_in_stock","¿Disponible?");
        $this->widgetSchema->setHelp("is_in_stock","Indica si la cesta está disponible");
    }
}
