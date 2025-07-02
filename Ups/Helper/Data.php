<?php

namespace Footdistrict\Ups\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;


/**
 * Catalog Inventory default helper
 */
class Data extends \Magento\CatalogInventory\Helper\Data
{


    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }


    public function getShippingMethodsIds() {
        return $this->scopeConfig->getValue(
            'ups_configuration/shipping_method/shipping_methods',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
    }
    public function getLocatorUrl(){
            return $this->_storeManager->getStore()->getUrl('rest/V1/ups/') . 'locator';
    }   
}
