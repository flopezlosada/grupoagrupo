<?php
/**
 * sfWhoIsOnlineFilter
 * This filter handles user IP storing funcionality
 * @author radek.qo
 */
class sfWhoIsOnlineFilter extends sfFilter {
    /**
     * Executes filter
     * @param sfFilterChain $filterChain
     */
    public function execute($filterChain)
    {
        
        if ($this->isFirstCall())
        {
            sfWhoIsOnlineUserFacade::registerUser($this->getContext()->getUser());
            sfWhoIsOnlineUserFacade::clearTimeouts(sfConfig::get("app_sfWhoIsOnline_timeout",60*5));
        }
        $filterChain->execute();
    }
}