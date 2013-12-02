<?php

class myUser extends sfGuardSecurityUser
{
    public function getInternalUser()
    {
        if ($this->isAuthenticated()){
            $this->profile=$this->getGuardUser()->Profile;
            $this->internal_class=$this->profile->InternalClass->class;

            return $this->internal_user=$this->getGuardUser()->{$this->internal_class};
        }

        return false;
    }

    public function getInternalClassName()
    {
        if ($this->isAuthenticated()){
            $this->profile=$this->getGuardUser()->Profile;

            return $this->internal_class=$this->profile->InternalClass->class;
        }

        return false;
    }
    

    public function getInternalClass()
    {
        if ($this->isAuthenticated()){
            $this->profile=$this->getGuardUser()->Profile;

            return $this->internal_class=$this->profile->InternalClass;
        }

        return false;
    }

    /*
     * Devuelve los estados a los que puede acceder según el tipo de usuario
     */
    public function getAllowPublishStates()
    {
        $public_states=array();

        $internal_class=$this->getInternalClassName();

        switch ($internal_class) {
            /*
             * el proveedor podrá elegir si lo que publica o sale en portada (2) o
             * en su perfil (9)
             */
            case "Provider":
                $public_states=array(2);
                break;

                /*
                 * todo lo que publica un consumidor sin grupo sale en portada. Probablemente necesite moderación.
                 */
            case "Consumer":
                $public_states=array(2);
                break;            
        }

        if ($internal_class=="Consumer")
        {
            $user=$this->getInternalUser();
            /*
             * si tiene grupo de consumo, puede elegir mostrarlo a su grupo de consumo. 
             */
            if ($user->consumer_group_id!=null&&$user->consumer_state_id==2) //si forma parte de un grupo
            {
                $public_states=array_merge($public_states, array(7));
            } else {
                //$public_states=array_merge($public_states, array(6));
            }
        }
        //El estado 1 es para todos
        $public_states=array_merge($public_states, array(1));
        
        return $public_states;
    }
    
    public function getUtils($type)
    {
        return Doctrine::getTable(ucfirst($type))->createQuery()->where("user_id=?",$this->getGuardUser()->id)->orderBy("created_at DESC")->limit(5)->execute();
    }
    
}
