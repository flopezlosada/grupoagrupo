<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardFormSignin extends BasesfGuardFormSignin
{
    /**
     * @see sfForm
     */
    public function configure()
    {
        $this->widgetSchema['username']->setLabel('Usuaria/o');
        $this->widgetSchema['password']->setLabel('Contraseña');
        $this->widgetSchema['remember']->setLabel('No cerrar sesión');
        $this->widgetSchema['remember']->setAttribute("class","checkbox");
        
        $this->validatorSchema["username"]->setMessage("required","Introduce un nombre de usuaria/o");
        $this->validatorSchema["password"]->setMessage("required","Introduce la contraseña");
        
        $this->validatorSchema->setMessage("invalid","El nombre de usuaria/o o la contraseña son inválidas");
    }
}
