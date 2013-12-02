<?php

/**
 * news module configuration.
 *
 * @package    webs_proyectos
 * @subpackage news
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsGeneratorConfiguration extends BaseNewsGeneratorConfiguration
{
    public function getModel()
    {
        return 'News';
    }
}
