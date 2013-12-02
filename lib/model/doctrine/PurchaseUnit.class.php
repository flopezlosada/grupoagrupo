<?php

/**
 * PurchaseUnit
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    grupos_consumo
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PurchaseUnit extends BasePurchaseUnit
{
    public function getCulture(){
        return sfContext::getInstance()->getUser()->getCulture();
    }

    public function getCultureTranslation(){
        return sfContext::getInstance()->getUser()->getFlash("cultureTranslation");
    }

    public function setCultureTranslation($cultureTranslation){
        $this->cultureTranslation=$cultureTranslation;
    }

}
