<?php

/**
 * PublishStateTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PublishStateTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PublishStateTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PublishState');
    }

    public function getPublishStatesFromUser()
    {
        $states=sfContext::getInstance()->getUser()->getAllowPublishStates();
        if (sfContext::getInstance()->getModuleName()=="consumer_group"&&sfContext::getInstance()->getUser()->getInternalClassName()=="Consumer")
        {
            if(sfContext::getInstance()->getUser()->getInternalUser()->belongConsumerGroup()){
                $states[]=7;
            }
        }
        return $this->createQuery("a")->whereIn("id",$states)->orderBy("id DESC");
    }
    
    public function getPublishStatesFromGroup()
    {
       
        return $this->createQuery("a")->whereIn("id",array(8,7,2))->orderBy("id DESC");
    }
    
}