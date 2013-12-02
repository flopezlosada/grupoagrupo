<?php

/**
 * VenueTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VenueTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object VenueTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Venue');
    }

    public function applyNameFilter($query, $value)
    {
        $query->leftJoin($query->getRootAlias() . '.Translation t')
        ->addWhere('t.name like \'%' . $value['text'] . '%\'');
    }
}