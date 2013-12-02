<?php

/**
 * sfGuardAuth actions.
 *
 * @package    didom
 * @subpackage sfGuardAuth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */

require_once(sfConfig::get("sf_plugins_dir").'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
class sfGuardAuthActions extends BasesfGuardAuthActions {
/**
 * Executes index action
 *
 * @param sfRequest $request A request object
 */
  public function executeSignin($request) {
    //if($request->getMethod() == "POST") $this->checkAlternatePassword($request->getParameter("signin"));
    $this->setLayout("login");
    parent::executeSignin($request);
  }

  /*public function executePassword() {
    if ($this->getUser()->isAuthenticated()) {
      $this->redirect("@homepage");
    }

    $request = $this->getRequest();
    $this->form = new RequestPasswordForm();
    if (cmsRequestMethod::post()) {
      $values = $request->getParameter("restore");
      $this->form->bind($values);
      if ($this->form->isValid()) {
        $this->sendPassword($values["username"]);
      }
    }
  }

  private function sendPassword($username) {
    $this->password = substr(uniqid(), 0, 12);
    $this->date = new DateTime();
    $this->date->modify(sprintf("+%s", sfConfig::get("app_password_restore_valid"), "1 day"));
    $this->user = Doctrine::getTable("sfGuardUser")->findOneByUsername($username);
    $previous = Doctrine::getTable("PasswordRequest")->findOneByUserId($this->user->id);
    $restore = $previous ? $previous : new PasswordRequest();
    $restore->User = $this->user;
    $restore->password = $this->password;
    $restore->valid_until = $this->date->format("Y-m-d H:i:s");
    $restore->save();
    $this->username = $username;

    $this->sendPasswordTemplate();
    
    $this->setTemplate("password_sent");
  }

  private function checkAlternatePassword($params) {
    PasswordRequestTable::cleanup();
    $user = Doctrine::getTable("sfGuardUser")->findOneByUsername($params["username"]);
    if (!$user) return false;
    $alternate = PasswordRequestTable::findByUserAndPassword($user, $params["password"]);
    if (!$alternate) return false;
    
    $user->setPassword($alternate->password);
    $user->save();
    $alternate->delete();
  }

  private function sendPasswordTemplate()
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array("I18N"));
    $template = Doctrine::getTable("CmsNode")->findOneBySlug("forgot-password-service");
    $mailtext = $template
        ? myUtils::parse($template->getValuesByFieldSlug("service-content")->getFirst()->val($this->getUser()->getCulture()),
              array(
                "%password%"    => $this->password,
                "%valid_until%" => $this->date->format("Y-m-d H:i:s"),
                "%username%"    => $this->user->username
              ))
        : "Service template is unavailable";
    
    try {
      $mailer = new Swift(new Swift_Connection_NativeMail());
      ProjectConfiguration::getActive()->loadHelpers(array("I18N"));

      $message = new Swift_Message(
        __('%project_name% - password restore',
          array("%project_name%"=>sfConfig::get("app_project_name")), "password_restore"),
        $mailtext, 'text/html');

      // Send
      $mailer->send($message, $this->user->UserProfile->email, sfConfig::get("app_password_restore_from"));
//      $mailer->send($message, "rodger@localhost", sfConfig::get("app_password_restore_from"));
      $mailer->disconnect();
      $this->getUser()->setFlash("info-success", __("A new password for account %account% was created", array("%account%"=>$this->username), "password_restore"));
    }
    catch (Exception $e) {
      $mailer->disconnect();
      $this->getUser()->setFlash("info-error", "Message was not sent due to mailer error");
    }
  }*/
}
