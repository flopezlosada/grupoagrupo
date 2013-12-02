<?php

abstract class onlineStorage
{

  /**
   * Initializes this Storage instance.
   *
   * @param sfContext A sfContext instance
   * @param array   An associative array of initialization parameters
   *
   * @return boolean true, if initialization completes successfully, otherwise false
   *
   * @throws <b>sfInitializationException</b> If an error occurs while initializing this sfStorage
   */
  abstract function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array());
   
  abstract function set($name, $value);
  
  abstract function get($name);
  
  abstract function has($name);
  
  abstract function delete($name);
  
  abstract function replace($name, $value);
  
}