<?php

/**
 * category module helper.
 *
 * @package    webs_proyectos
 * @subpackage category
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class categoryGeneratorHelper extends BaseCategoryGeneratorHelper
{
    public function linkToNewNews($object, $params)
    {
        if ($object->isNew())
        {
            return '';
        }

        return '<li class="sf_admin_action_new">'.link_to(__($params['label'], array(), 'sf_admin'), 'news/new?category_id='.$object->id).'</li>';
    }
}
