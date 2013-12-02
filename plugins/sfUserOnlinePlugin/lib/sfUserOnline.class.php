<?php

/**
 * Class that use memcache to store user status.
 * Is user online or offline or other.
 *
 * @author Yura Rodchyn <rodchyn@gmail.com>
 * @package rodchyn
 * @example sfUserOnline::isOnline('user_id') return boolean user status
 * @see http://go.rodchyn.com/sfUserOnlinePlugin
 *
 */

class sfUserOnline extends myUser
{
    protected $statusHolder = null;
    protected $userUniqueId = null;
    
    public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
    {
        // initialize parent
        parent::initialize($dispatcher, $storage, $options);

        $options = array_merge(array(
            'online_status_class' => 'onlineMemcacheStorage',
            'user_unique_method'  => 'getId'
        ), $options);
        
        $this->userUniqueId = call_user_func(array($this, $options['user_unique_method']));
        $this->statusHolder = new $options['online_status_class'];        
        $this->statusHolder->initialize($dispatcher, $storage, $options);
        $this->refreshStatus();
        
    }
    
    
    public function refreshStatus()
    {
        if($status = $this->getStatus()) {
            if (!$this->statusHolder->replace($this->userUniqueId, $status)) {
                $this->statusHolder->set($this->userUniqueId, $status);
                $this->dispatcher->notify(new sfEvent($this, 'user.change_status', array('status' => $status)));
            }
        } else {
            return false;
        }
    }
    public function setOffline()
    {
        $this->dispatcher->notify(new sfEvent($this, 'user.change_status', array('status' => 'Offline')));
        return $this->statusHolder->delete($this->userUniqueId);
    }
    public function isOnline()
    {
        return (bool)self::getStatus();
    }
    
    public function setStatus($status)
    {
        $this->dispatcher->notify(new sfEvent($this, 'user.change_status', array('status' => $status)));
        return $this->statusHolder->set($this->userUniqueId, $status);
    }
    
    public function getStatus()
    {
        return $this->statusHolder->get($this->userUniqueId);
    }
    
    public function getStatusForUser($userId)
    {
        return $this->statusHolder->get($this->userUniqueId);
    }
    
    public function getId()
    {
        throw new Exception("Replace this method to get user unique id");
    }
}
?>