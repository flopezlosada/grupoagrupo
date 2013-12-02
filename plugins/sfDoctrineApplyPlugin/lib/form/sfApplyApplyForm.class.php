<?php

class sfApplyApplyForm extends sfGuardUserProfileForm
{
    private $validate = null;

    public function configure()
    {

        parent::configure();

        // We're making a new user or editing the user who is
        // logged in. In neither case is it appropriate for
        // the user to get to pick an existing userid. The user
        // also doesn't get to modify the validate field which
        // is part of how their account is verified by email.

        unset($this['user_id'], $this['validate']);

        // Add username and password fields which we'll manage
        // on our own. Before you ask, I experimented with separately
        // emitting, merging or embedding a form subclassed from
        // sfGuardUser. It was vastly more work in every instance.
        // You have to clobber all of the other fields (you can
        // automate that, but still). If you use embedForm you realize
        // you've got a nested form that looks like a
        // nested form and an end user looking at that and
        // saying "why?" If you use mergeForm you can't save(). And if
        // you output the forms consecutively you have to manage your
        // own transactions. Adding two fields to the profile form
        // is definitely simpler.

        $this->setWidget('username', new sfWidgetFormInput(
                array(), array('maxlength' => 16)
        ));

        $this->widgetSchema->moveField('username', sfWidgetFormSchema::FIRST);

        $this->setWidget('password', new sfWidgetFormInputPassword(
                array(), array('maxlength' => 128)
        ));

        $this->widgetSchema->moveField('password', sfWidgetFormSchema::AFTER, 'username');

        $this->setWidget('password2', new sfWidgetFormInputPassword(
                array(), array('maxlength' => 128)
        ));

        $this->widgetSchema->moveField('password2', sfWidgetFormSchema::AFTER, 'password');

        //$this->widgetSchema->setLabels(array('password2' => 'Confirm Password'));

        $email = $this->getWidget('email');
        $class = get_class($email);
        $this->setWidget('email2', new $class(
                array(), array('maxlength' => $email->getAttribute('maxlength'))
        ));

        $this->widgetSchema->moveField('email2', sfWidgetFormSchema::AFTER, 'email');

         

        $this->widgetSchema->setNameFormat('sfApplyApply[%s]');
        $this->widgetSchema->setFormFormatterName('list');

        // We have the right to an opinion on these fields because we
        // implement at least part of their behavior. Validators for the
        // rest of the user profile come from the schema and from the
        // developer's form subclass

        $this->setValidator('username',
                new sfValidatorAnd(array(
                        new sfValidatorString(array(
                                'required' => true,
                                'trim' => true,
                                'min_length' => 4,
                                'max_length' => 16
                        )),
                        // Usernames should be safe to output without escaping and generally username-like.
                        new sfValidatorRegex(array(
                                'pattern' => '/^\w+$/'
                        ), array('invalid' => 'Los nombres de usuaria/o sólo deben contener letras, números y guiones bajos.')),
                        new sfValidatorDoctrineUnique(array(
                        'model' => 'sfGuardUser',
                        'column' => 'username'
                                ), array('invalid' => 'Ya hay una/un usuaria/o con este nombre. Elige otro.'))
                ))
        );

        // Passwords are never printed - ever - except in the context of Symfony form validation which has built-in escaping.
        // So we don't need a regex here to limit what is allowed

        // Don't print passwords when complaining about inadequate length
        $this->setValidator('password', new sfValidatorString(array(
                'required' => true,
                'trim' => true,
                'min_length' => 6,
                'max_length' => 128
        ), array(
                'min_length' => 'La contraseaña es muy corta. Debe contener un mínimo de %min_length% caracteres.')));

        $this->setValidator('password2', new sfValidatorString(array(
                'required' => true,
                'trim' => true,
                'min_length' => 6,
                'max_length' => 128
        ), array(
                'min_length' => 'La contraseña es muy corta. Debe contener un mínimo de %min_length% caracteres.')));

        // Be aware that sfValidatorEmail doesn't guarantee a string that is preescaped for HTML purposes.
        // If you choose to echo the user's email address somewhere, make sure you escape entities.
        // <, > and & are rare but not forbidden due to the "quoted string in the local part" form of email address
        // (read the RFC if you don't believe me...).

        $this->setValidator('email', new sfValidatorAnd(array(
                new sfValidatorEmail(array('required' => true, 'trim' => true)),
                new sfValidatorString(array('required' => true, 'max_length' => 80)),
                new sfValidatorDoctrineUnique(array(
                        'model' => 'sfGuardUserProfile',
                        'column' => 'email'
                ), array('invalid' => 'Una cuenta con esta dirección de correo electrónico ya existe. Si has olvidado tu contraseña, pincha en "Cancelar" y después "¿Has olvidado tu contraseña?"'))
        )));

        $this->setValidator('email2', new sfValidatorEmail(array(
                'required' => true,
                'trim' => true
        )));

        // Disallow <, >, & and | in full names. We forbid | because
        // it is part of our preferred microformat for lists of disambiguated
        // full names in sfGuard apps: Full Name (username) | Full Name (username) | Full Name (username)
        /*$this->setValidator('fullname', new sfValidatorAnd(array(
                new sfValidatorString(array(
                        'required' => false,
                        'trim' => true,
                        'min_length' => 6,
                        'max_length' => 128)),
                new sfValidatorRegex(array(
                        'pattern' => '/^[^<>&\|]+$/',
                ), array('invalid' => 'Full names may not contain &lt;, &gt;, | or &amp;.'))
        )));*/

        $schema = $this->validatorSchema;

        // Hey Fabien, adding more postvalidators is kinda verbose!


         
        $this->useFields(array("internal_class_id","username", "password", "password2","email", "email2", "profile_group"));

        $this->widgetSchema["profile_group"]=new sfWidgetFormInputHidden();
        $this->setDefault("profile_group",0);

        $this->widgetSchema["internal_class_id"]->setLabel("Indica tu actividad");
        $this->widgetSchema["internal_class_id"]->addOption("table_method","getPublicClass");

        $this->widgetSchema->setLabels(array(
                'username' => 'Nombre de usuaria/o',
                'email' => 'Correo electrónico',
                'email2' => 'Confirma tu correo electrónico',
                'password' => 'Contraseña',
                'password2' => 'Confirma tu contraseña',

        ));
        $this->validatorSchema["username"]->setMessage("required","Indica un nombre de usuaria/o");
        $this->validatorSchema["email"]->setMessage("required","Indica una dirección de correo electrónico");
        $this->validatorSchema["email2"]->setMessage("required","Confirma tu correo electrónico");
        $this->validatorSchema["password"]->setMessage("required","Indica una contraseña");
        $this->validatorSchema["password2"]->setMessage("required","Confirma tu contraseña");

        $postValidator = $schema->getPostValidator();

        $postValidators = array(
                new sfValidatorSchemaCompare(
                        'password',
                        sfValidatorSchemaCompare::EQUAL,
                        'password2',
                        array(),
                        array('invalid' => 'Las contraseñas no coinciden.')
                ),
                new sfValidatorSchemaCompare(
                        'email',
                        sfValidatorSchemaCompare::EQUAL,
                        'email2',
                        array(),
                        array('invalid' => 'Las direcciones de correo electrónicas no coinciden.')
                )
        );

        if ($postValidator)
        {
            $postValidators[] = $postValidator;
        }
        $this->validatorSchema->setPostValidator(new sfValidatorAnd($postValidators));
         
        /* $this->validatorSchema["email"]->setMessage("invalid","Indica una dirección de correo electrónico correcta");
         $this->validatorSchema["email2"]->setMessage("invalid","Indica una dirección de correo electrónico correcta");*/
        
        
        /*
         * tooltips
         */
        $this->widgetSchema["internal_class_id"]->setAttribute("title","<p>Selecciona el tipo de actividad con el que quieres registrarte en la página</p>
                <ul><li><strong>Productora/or:</strong> Cuando los productos que vendes son de tu producción</li>
                <li><strong>Distribuidora/or:</strong> Cuando los productos en venta los han producido otras personas</li>
                <li><strong>Productora/or y Distribuidora/or:</strong> En el caso de que vendas productos de producción propia y de terceros.</li>
                <li><strong>Consumidora/or:</strong> Si vas a comprar productos</li>
                <li><strong>Grupo de Consumo:</strong> Si ya sois un grupo</li></ul>");
        $this->widgetSchema["username"]->setAttribute("title","Puedes usar letras, números y guiones. No son válidos los espacios");
        $this->widgetSchema["password"]->setAttribute("title","<strong>Seguridad de la contraseña:</strong> Usa ocho caracteres como mínimo.
                <br/>Puedes usar letras, números y guiones. No son válidos los espacios");
        //$this->widgetSchema["password2"]->setAttribute("title","Puedes usar letras, números y guiones. No son válidos los espacios");
        $this->widgetSchema["email"]->setAttribute("title","Indica una dirección de correo electrónico válida.<br />Servirá para confirmar el alta de tu cuenta y recibirás los avisos correspondientes.<br />También, si lo deseas, podrás recibir información de Grupo A Grupo.");
        
    }

    public function setValidate($validate)
    {
        $this->validate = $validate;
    }

    public function doSave($con = null)
    {
        $user = new sfGuardUser();
        $user->setUsername($this->getValue('username'));
        $user->setPassword($this->getValue('password'));
        $user->setEmailAddress($this->getValue('email'));
        // They must confirm their account first
        $user->setIsActive(false);
        $user->save();
         
        if ($this->getValue("internal_class_id")==1)
        {
            $name="producer";
        } elseif ($this->getValue("internal_class_id")==2)
        {
            $name="distributor";
        }
        elseif ($this->getValue("internal_class_id")==3)
        {
            $name="consumer";
        }
        elseif ($this->getValue("internal_class_id")==6)
        {
            $name="consumer";
        }
        elseif ($this->getValue("internal_class_id")==7)
        {
            /*
             * como este es distribuidor y productor a un tiempo, 
             * hay que añadirle 2 permisos, por eso lo pongo así.
             */
            $user->addPermissionByName("distributor");
            $user->addGroupByName("Distributors");
            $name="producer";
        }


        $user->addPermissionByName($name);
        $user->addGroupByName(ucfirst($name)."s");//en plural y la primera en mayúscula
        $this->userId = $user->getId();

        return parent::doSave($con);
    }

    /*
     * si se da de alta como grupo de consumo, le cambio la clase interna
    */
    public function doBind(array $values)
    {
        if ($values["internal_class_id"]==6)
        {
            $values["internal_class_id"]=3;
            $values["profile_group"]=1;
        }

        parent::doBind($values);
    }


    public function updateObject($values = null)
    {
        $object = parent::updateObject($values);
        $object->setUserId($this->userId);
        $object->setValidate($this->validate);

        // Don't break subclasses!
        return $object;
    }

    /*
     * esta función la creo para el formulario inviteForm
    * Cuando hago el doSave() en el inviteForm, debo llamar al doSave() del sfGuardUserProfileForm
    * pero si llamo al parent::doSave() lo que hago es llamar al de esta clase que no me interesa
    */

    public function parentDoSave($con=null)
    {
        return parent::doSave($con);
    }
}

