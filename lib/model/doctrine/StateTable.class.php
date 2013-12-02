<?php

/**
 * StateTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StateTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object StateTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('State');
    }


    public function getStateList()
    {
        return Doctrine_Core::getTable('State')
        ->createQuery('c')
        ->leftJoin("c.Translation t");
    }
}