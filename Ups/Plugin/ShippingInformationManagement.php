<?php

namespace Footdistrict\Ups\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;

class ShippingInformationManagement
{
    public $quoteRepository;

    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeSaveAddressInformation($subject, $cartId, $addressInformation)
    {

        $extAttributes = $addressInformation->getshippingAddress()->getExtensionAttributes();
        $address2=$extAttributes->getAccessPoint();

        $quote = $this->quoteRepository->getActive($cartId);
        
        $quote->setAccessPoint($address2);    
        $this->quoteRepository->save($quote);;
    }
}