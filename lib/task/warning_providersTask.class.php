<?php

class warning_providersTask extends sfBaseTask
{
    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        $this->addOptions(array(
                new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name',"frontend"),
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace        = 'warnings';
        $this->name             = 'warning_providers';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [warning_providers|INFO] task does things.
Call it with:

  [php symfony warning_providers|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        // add your code here

        $this->configuration->loadHelpers(array('I18N','Partial','Debug'));
        $context = sfContext::createInstance($this->configuration);

        $query=Doctrine::getTable("Provider")->findAll();

        foreach ($query as $provider)
        {
            if (!$provider->hasCatalogue())
            {
                //sfContext::getInstance()->getLogger()->info($provider->name);
                $message=$this->getMailer()->compose(sfConfig::get("app_default_mailfrom"),
                        $provider->email,__("http://grupoagrupo.net le avisa: Su catálogo no está activo"),
                        "Para aparecer en las búsquedas debe dar de alta sus productos. En caso contrario no saldrá en los resultados de búsqueda.");
                // generate HTML part
                $context->getRequest()->setRequestFormat('html');
                $html  = get_partial('provider/mail_warning_catalogue_html', array('provider' => $provider));
                $message->setBody($html, 'text/html');

                // generate plain text part
                $context->getRequest()->setRequestFormat('txt');
                $plain = get_partial('provider/mail_warning_catalogue_txt', array('provider' => $provider));
                $message->addPart($plain, 'text/plain');

                // send the message
                //sfContext::getInstance()->getLogger()->info($message);
                $this->getMailer()->send($message);
            }
        }
    }
}
