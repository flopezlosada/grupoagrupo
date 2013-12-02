<?php

/**
 * faq module configuration.
 *
 * @package    grupos_consumo
 * @subpackage faq
 * @author     Your name here
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class faqGeneratorConfiguration extends BaseFaqGeneratorConfiguration
{
    public function getModel()
    {
        return 'Faq';
    }
}
