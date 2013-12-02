<?php

class onlineMemcacheStorage extends onlineStorage
{
    private $resource = null;
    private $lifetime = null;
    private $prefix   = null;
    
    public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
    {        
        $options = array_merge(array(
            'memcache_host'   => '127.0.0.1',
            'memcache_port'   => '11211',
            'status_lifetime' => '600', // ten minutes
            'memcache_prefix' => 'ustatus_' // memcache prefix
        ), $options);
        
        $this->prefix   = $options['memcache_prefix'];
        $this->lifetime = $options['status_lifetime'];
        
        if (!class_exists('Memcache')) {
            throw new Exception("No memcache extension loaded");
        }
        
        $this->resource = new Memcache();
        if(!$this->resource->connect($options['memcache_host'], $options['memcache_port'])) {
            throw new Exception("Can't connect to memcache server");
        }
        
    }
    
    public function set($name, $value)
    {
        $this->resource->set($this->getNameWithPrefix($name), $value, false, $this->lifetime);
    }
  
    public function get($name)
    {
        return $this->resource->get($this->getNameWithPrefix($name));
    }
    
    public function has($name)
    {
        return (bool)$this->resource->get($this->getNameWithPrefix($name));
    }
    
    public function delete($name)
    {
        return $this->resource->delete($this->getNameWithPrefix($name));
    }
    
    public function replace($name, $value)
    {
        $this->resource->replace($this->getNameWithPrefix($name), $value, false, $this->lifetime);
    }
    
    private function getNameWithPrefix($name)
    {
        return $this->prefix . $name;
    }
}