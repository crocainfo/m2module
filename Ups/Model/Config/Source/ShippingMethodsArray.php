<?php
namespace Footdistrict\Ups\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ShippingMethodsArray implements ArrayInterface
{

    protected $scopeConfig; 
    protected $shipconfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shipconfig
    )
    {
        $this->shipconfig = $shipconfig;
        $this->scopeConfig = $scopeConfig;
    }

    /*  
     * Option getter
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getShippingMethods();
    }

    public function getShippingMethods() {
        $activeCarriers = $this->shipconfig->getActiveCarriers();
    
        foreach($activeCarriers as $carrierCode => $carrierModel) {
           $options = [['value' => null, 'label' => "----- Select One Or more -----"]];
    
           if ($carrierMethods = $carrierModel->getAllowedMethods()) {
               foreach ($carrierMethods as $methodCode => $method) {
                    $code = $carrierCode . '_' . $methodCode;
                    $options[] = array('value' => $code, 'label' => $method);
               }
               $carrierTitle = $this->scopeConfig
                   ->getValue('carriers/'.$carrierCode.'/title');
            }
    
            $methods[] = array('value' => $options, 'label' => $carrierTitle);
        }
    
        return $methods;    
    }
    
}