<?php
class sfWhoIsOnlineComponents extends sfComponents {
	public function executeOnline()
	{
		$this->online = sfWhoIsOnlineUserTable::getUserCount();
		$this->count_guest=sfWhoIsOnlineUserTable::getGuestUsersCount();
		$this->count_logged=sfWhoIsOnlineUserTable::getLoggedUsersCount();
	}
	public function executeCodes()
	{
		$this->codes = sfWhoIsOnlineUserTable::getCountryCodes();
	}
	public function executeUsers()
	{
		$this->users = sfWhoIsOnlineUserTable::getUsers();
	}
	public function executeCombined()
	{
		//if you dont have included jQuery uncomment this line
		//$this->getResponse()->addJavascript("http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js");
		$this->online = sfWhoIsOnlineUserTable::getUserCount();
		$this->guest =sfWhoIsOnlineUserTable::getGuestUsers();
		$this->logged =sfWhoIsOnlineUserTable::getLoggedUsers();
		$this->count_guest=sfWhoIsOnlineUserTable::getGuestUsersCount();
		$this->count_logged=sfWhoIsOnlineUserTable::getLoggedUsersCount();
	}
}