<?php
/**
 * Facade which represents whole "who is online" API
 * @author radek.qo@seznam.cz
 * @version 0.9
 */
class sfWhoIsOnlineUserFacade {
    /**
     * Register user's IP address to database and locates his position.
     * You may implement your own getIp() method in myUser class
     * if you wish to use another algorithm for getting IP.
     *
     * Parameter name is get by getName() method (called on sfUser),
     * if not implemented it takes IP as name.
     *
     * @param sfUser $sfUser
     */
    public static function registerUser(sfUser $sfUser)
    {
        if(method_exists($sfUser,"getIp")) {
            $ip = $sfUser->getIp();
        } else {
            $ip = self::getIp();
        }

        $instance = sfWhoIsOnlineUserTable::getInstance()->find($ip);

        if($instance == null) {
            $instance = new sfWhoIsOnlineUser();
            $instance->ip = $ip;

            $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
            if(@$tags["known"] == "true") {
                $instance->fromTags($tags);
            } else {
                // Making an API call to Hostip:
                $xmlString = file_get_contents('http://api.hostip.info/?ip='.$ip);
                $xml = new SimpleXMLElement($xmlString);
                $instance->fromXml($xml);
            }
        }
        if ($sfUser->isAuthenticated())
        {                        
            $instance->is_user=true;
        }
        else
        {
            $instance->is_user=false;            
        }

        $instance->save();
    }
    /**
     * Get IP address of current user. You may implement your own getIp() method in myUser class
     * @return string IPAddress
     */
    private static function getIp()
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
        else $TheIp=$_SERVER['REMOTE_ADDR'];

        return trim($TheIp);
    }
    /**
     * Deletes old rows from database. Redirects to sfWhoIsOnlineUserTable
     * @param int $timeout
     */
    public static function clearTimeouts($timeout)
    {
        return sfWhoIsOnlineUserTable::clearTimeouts($timeout);
    }
}