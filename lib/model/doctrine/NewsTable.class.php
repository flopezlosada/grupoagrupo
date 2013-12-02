<?php

class NewsTable extends Doctrine_Table
{
    
    public static function getNewList($limit, $order){
        $query=Doctrine::getTable("News")
        ->createQuery("a")
        ->orderBy($order)
        ->limit($limit)
        ->execute();
        
        return $query;
    }
}
