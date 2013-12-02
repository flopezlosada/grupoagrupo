<?php

/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BasesfApplyActions.class.php');

class sfApplyActions extends BasesfApplyActions
{
    // See how this extends BasesfApplyActions? You can replace it with
    // your own version by adding a modules/sfApply/actions/actions.class.php
    // to your own application and extending BasesfApplyActions there as well.

    protected function mail($options)
    {
        $required = array('subject', 'parameters', 'email', 'html', 'text');
        foreach ($required as $option)
        {
            if (!isset($options[$option]))
            {
                throw new sfException("Required option $option not supplied to sfApply::mail");
            }
        }

        $mailer = $this->getMailer();
        $mensaje = Swift_Message::newInstance();
        $mensaje->setFrom(sfConfig::get('app_default_mailfrom'));
        $mensaje->setTo($options['email']);
        $mensaje->setSubject($options['subject']);
        $mensaje->setBody($this->getPartial($options['text'], $options['parameters']), 'text/plain');
        $mensaje->addPart($this->getPartial($options['html'], $options['parameters']), 'text/html');
        //print_r($mensaje->getTo());
        $this->getMailer()->send($mensaje);
    }

    protected function sendVerificationMail($profile)
    {
        $this->mail(array('subject' => sfConfig::get('app_sfApplyPlugin_apply_subject',
        sfContext::getInstance()->getI18N()->__("Please verify your account on %1%", array('%1%' => $this->getRequest()->getHost()))),
      'email' => $profile->getEmail(),
      'parameters' => array('validate' => $profile->getValidate()),
      'text' => 'sfApply/sendValidateNewText',
      'html' => 'sfApply/sendValidateNew'));
    }

    protected function getFromAddress()
    {
        $from = sfConfig::get('app_sfApplyPlugin_from', false);
        if (!$from)
        {
            throw new Exception('app_sfApplyPlugin_from is not set');
        }
        // i18n the full name
        return array('email' => $from['email']);
    }
}
