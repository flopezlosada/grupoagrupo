<?php

/**
 * sfSimpleForumCategory form.
 *
 * @package    grupos_consumo
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfSimpleForumCategoryForm extends PluginsfSimpleForumCategoryForm
{
    public function configure()
    {
        $this->validatorSchema["name"]->setOption("required",true);
        $this->validatorSchema["description"]->setOption("required",true);
    }
}
