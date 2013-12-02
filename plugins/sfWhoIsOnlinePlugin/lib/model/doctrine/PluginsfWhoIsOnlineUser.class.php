<?php

/**
 * PluginsfWhoIsOnlineUser
 *
 * @author     radek.qo@seznam.cz
 */
abstract class PluginsfWhoIsOnlineUser extends BasesfWhoIsOnlineUser
{
	/**
	 * Populates location variables from array got Geobyte IPLocator service
	 * @param unknown_type $tags
	 */
	public function fromTags($tags)
	{
		$this->city = $tags["city"];
		$this->country = $tags["country"];
		$this->countrycode = $tags["iso2"];
	}
	/**
	 * Populates location variables from XML got by HostIP
	 * @param SimpleXmlElement $xml
	 */
	public function fromXml(SimpleXmlElement $xml)
	{
		$city = $xml->xpath('//gml:name');
		$city = $city[1]."";

		$countryName = $xml->xpath('//countryName');
		$countryName = $countryName[0]."";
		$countryName = str_replace('(Unknown Country?)','UNKNOWN',$countryName);

		$countryAbbrev = $xml->xpath('//countryAbbrev');
		$countryAbbrev = $countryAbbrev[0]."";

		$this->city = $city;
		$this->country = $countryName;
		$this->countrycode = $countryAbbrev;
	}
	/**
	 * Overrides parents save method. It saves current timestamp.
	 */
	public function save(Doctrine_Connection $conn = null)
	{
		$b = @get_browser(null,true);
		if($b) {
			$browser = $b["browser"];
		} else {
			$browser = "unknown";
		}
		$this->browser = $browser;
		$this->ts = time();
		$this->page = sfContext::getInstance()->getRequest()->getUri();
		return parent::save($conn);
	}
}