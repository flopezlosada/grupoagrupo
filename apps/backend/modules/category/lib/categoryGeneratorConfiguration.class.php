<?php

/**
 * category module configuration.
 *
 * @package    webs_proyectos
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryGeneratorConfiguration extends BaseCategoryGeneratorConfiguration
{
    public function getModel()
    {
        return 'Category';
    }

}
