<?php

namespace Footdistrict\Ups\Model;

use Footdistrict\Ups\Helper\Data as Helper;
use Magento\Checkout\Model\ConfigProviderInterface;

class DefaultConfigProvider implements ConfigProviderInterface
{
    /**
     * @var Helper
     */
    private $_helper;

    
    public function __construct(
        Helper $helper
    ) {
        $this->_helper = $helper;
    }

    /**
     * {@inheritdoc}
     * @throws LocalizedException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function getConfig()
    {
        $output = [
            'footConfig' => ['ups' => [
                    'locatorMethods' => $this->_helper->getShippingMethodsIds(),
                    'serviceUrl' => $this->_helper->getLocatorUrl()
                ]
            ]
        ];

        return $output;
    }
   }
