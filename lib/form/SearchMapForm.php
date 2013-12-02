<?php
/*
 © Copyright 2012 diphda.net && Sodepaz
info@diphda.net


Este programa es software libre. Puede redistribuirlo y/o modificarlo bajo los términos de la Licencia
Pública General de GNU según es publicada por la Free Software Foundation, bien de la versión 3 de dicha
Licencia o bien (según su elección) de cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil, pero SIN NINGUNA GARANTÍA, incluso sin l
garantía MERCANTIL implícita o sin garantizar la CONVENIENCIA PARA UN PROPÓSITO PARTICULAR. Véase la
Licencia Pública General de GNU para más detalles.

Debería haber recibido una copia de la Licencia Pública General junto con este programa. Si no ha sido así,
escriba a la Free Software Foundation, Inc., en 675 Mass Ave, Cambridge, MA 02139, EEUU.

La licencia se encuentra en el archivo licencia.txt*/


class SearchMapForm extends BaseFormDoctrine
{
    public function setup()
    {
        $this->setWidgets(array(
                'state_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'), 'add_empty' => false)),
                'city_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
                'length'				=> new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
                'state_id'                 => new sfValidatorDoctrineChoice(array('model' => 'State', 'required' => false)),
                'city_id'                  => new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)),
                'length'   => new sfValidatorInteger(array('required' => false)),
        ));

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->widgetSchema->setNameFormat('search_consumer_group_map[%s]');
    }

    public function configure()
    {
        $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'),
                'add_empty' => 'Provincia ...', "table_method"=>"getStateList"));

        $this->widgetSchema->setLabel("state_id","Provincia");
         

        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'City',
                'depends'   => 'State',
                'table_method' => "getCityList",
                'ajax'		=> true,
                'add_empty' => 'Municipio ...'));
        $this->widgetSchema->setLabel("city_id","Municipio");
        $this->widgetSchema->setLabel("length","Distancia");
        $this->widgetSchema['length']->setAttribute("class","length");


    }
    public function getModelName()
    {
        return 'ConsumerGroup';
    }

     
}

class SearchConsumerMapForm extends BaseFormDoctrine
{
    public function setup()
    {
        $this->setWidgets(array(
                'state_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'), 'add_empty' => false)),
                'city_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
                'length'				=> new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
                'state_id'                 => new sfValidatorDoctrineChoice(array('model' => 'State', 'required' => false)),
                'city_id'                  => new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)),
                'length'   => new sfValidatorInteger(array('required' => false)),
        ));

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->widgetSchema->setNameFormat('search_consumer_map[%s]');
    }

    public function configure()
    {
        $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('State'),
                'add_empty' => 'Provincia ...', "table_method"=>"getStateList"));

        $this->widgetSchema->setLabel("state_id","Provincia");


        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'City',
                'depends'   => 'State',
                'table_method' => "getCityList",
                'ajax'		=> true,
                'add_empty' => 'Municipio ...'));
        $this->widgetSchema->setLabel("city_id","Municipio");

        $this->widgetSchema->setLabel("length","Distancia");
        $this->widgetSchema['length']->setAttribute("class","length");
    }
    public function getModelName()
    {
        return 'Consumer';
    }
}

class SearchProviderMapForm extends BaseFormDoctrine
{
    public function setup()
    {
        $this->setWidgets(array(
                'state_id'                 => new sfWidgetFormDoctrineChoice(array('model' => 'State', 'add_empty' => false)),
                'city_id'                 => new sfWidgetFormDoctrineChoice(array('model' => 'City', 'add_empty' => true)),
                'length'				=> new sfWidgetFormInputText(),
                'product_category_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductCategory'), 'add_empty' => false)),
                'product_subcategory_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProductSubcategory'), 'add_empty' => false)),
                'product_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'add_empty' => false)),
                'close_search'			=> new sfWidgetFormInputHidden()
        ));
        $this->widgetSchema->setNameFormat('search_provider_map[%s]');

        $this->setValidators(array(
                'product_category_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProductCategory'))),
                'product_subcategory_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProductSubcategory'), 'required' => false)),
                'product_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Product'), 'required' => false)),
                'state_id'                 => new sfValidatorDoctrineChoice(array('model' => 'State', 'required' => false)),
                'city_id'                  => new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)),
                'length'   => new sfValidatorInteger(array('required' => false)),
                'close_search'   => new sfValidatorInteger(array('required' => false)),

        ));
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        
    }

    public function configure()
    {
        $this->widgetSchema['product_subcategory_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'ProductSubcategory',
                'depends'   => 'ProductCategory',
                'ajax'		=> true,
                'cache'=> true,
                'add_empty' => 'Subcategoría ...'));

        $this->widgetSchema['product_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'Product',
                'depends'   => 'ProductSubcategory',
                //'table_method' => "getProductList",
                'ajax'		=> true,
                'add_empty' => 'Producto ...'));


        $this->widgetSchema['product_category_id']->setOption("add_empty","Categoría ...");
        $this->widgetSchema['product_category_id']->setOption("table_method","getCategoryListHome");
        $this->widgetSchema['product_subcategory_id']->setOption("table_method","getSubcategoryList");

        $this->widgetSchema['state_id'] =  new sfWidgetFormDoctrineChoice(array('model' => 'State',
                'add_empty' => 'Provincia ...', "table_method"=>"getStateList"));

        $this->widgetSchema->setLabel("state_id","Provincia");


        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'City',
                'depends'   => 'State',
                'table_method' => "getCityList",
                'ajax'		=> true,
                'add_empty' => 'Municipio ...'));
        $this->widgetSchema->setLabel("city_id","Municipio");

        $this->widgetSchema->setLabel("length","Distancia");
        $this->widgetSchema['length']->setAttribute("class","length");

        $this->widgetSchema->setLabel("product_category_id","Categoría");
        $this->widgetSchema->setLabel("product_subcategory_id","Subcategoría");
        $this->widgetSchema->setLabel("product_id","Producto");
        $this->setDefault("close_search",0);

         

    }
    public function getModelName()
    {
        return 'ProviderProduct';
    }
}

