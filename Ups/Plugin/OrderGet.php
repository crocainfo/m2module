<?php		
		
namespace Footdistrict\Ups\Plugin;

use Exception;

class OrderGet		
{		
    protected $orderCollection;
    protected $dataObject;


    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollection,
        \Footdistrict\Ups\Model\OrderExtensionAttr $dataObject
    ) {
        $this->orderCollection = $orderCollection;
        $this->dataObject = $dataObject;

    }

		
    public function afterGet(		
	\Magento\Sales\Api\OrderRepositoryInterface $subject,	
	\Magento\Sales\Api\Data\OrderInterface $resultOrder	
    ) {				
        
        $decodedAttr = json_decode((string) $resultOrder->getAccessPoint(), true);
        
        if($decodedAttr)
        {
            $dataObject = $this->dataObject;
            $dataObject->setID($decodedAttr["id"]);
            $dataObject->setName($decodedAttr["name"]);
            $dataObject->setAddress($decodedAttr["address"]);
            $extensionAttributes = $resultOrder->getExtensionAttributes();	
    
            $extensionAttributes->setAccessPointApi($dataObject);
            $resultOrder->setExtensionAttributes($extensionAttributes);
        }

            
        return $resultOrder;	
    }				
}