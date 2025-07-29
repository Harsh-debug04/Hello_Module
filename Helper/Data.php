<?php
namespace AgriCart\Hello\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_HELLO = 'hello/general/';

    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_HELLO . 'enable',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getGreetingText($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_HELLO . 'greeting_text',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}