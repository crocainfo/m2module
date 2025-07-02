<?php

namespace Footdistrict\Ups\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;


class OrderEmailTemplateVar implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        $transport = $observer->getEvent()->getData('transportObject');
        $order = $transport->getData('order');
        $accessPoint = $order->getAccessPoint();
        $transport->addData([
            'formattedAccessPoint' => $this->formattedAccessPoint($accessPoint)
        ]);


        return $this;
    }

    public function formattedAccessPoint($accessPoint){
        if($accessPoint === null){
            return null;
            
        }else{
            $apArr = json_decode((string)$accessPoint, true);
        
            $formattedAp =  ucwords(strtolower($apArr["name"]))
                            . "<br>" . ucwords(strtolower($apArr["address"]["addressline"]))
                            . "<br>" . ucwords(strtolower($apArr["address"]["city"]));
    
            return $formattedAp;
        }

    }
}