<?php

/**
 * news module helper.
 *
 * @package    webs_proyectos
 * @subpackage news
 * @author     Your name here
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsGeneratorHelper extends BaseNewsGeneratorHelper
{
    public function linkToCategory($object, $params)
    {
        if ($object->isNew())
        {
            return '';
        }

        return '<li class="sf_admin_action_go">'.link_to(__($params['label'], array(), 'sf_admin'), 'category/edit?id='.$object->Category->id).'</li>';
    }
}
