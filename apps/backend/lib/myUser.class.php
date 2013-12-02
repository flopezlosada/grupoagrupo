<?php

class myUser extends sfGuardSecurityUser
{
  public function getAllowPublishStates()
  {
    
    return $public_states=array(1,2,3,4,5,6,7,8,9);  
  }
}
