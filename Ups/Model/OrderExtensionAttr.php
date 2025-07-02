<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Footdistrict\Ups\Model;

use Footdistrict\Ups\Api\OrderExtensionAttrInterface;

/**
 * Payment additional info class.
 */
class OrderExtensionAttr implements OrderExtensionAttrInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

        /**
     * @var \Footdistrict\Ups\Api\AddressInterface
     */
    private $address;

    public function __construct(
        \Footdistrict\Ups\Model\Address $address
    ) {
        $this->address = $address;
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }
        /**
     * @inheritdoc
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        $this->id = $id;
        return $id;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;
        return $name;
    }

    /**
     * @inheritdoc
     */
    public function setAddress($address)
    {

        $this->address->setAdressLine($address['addressline']);
        $this->address->setCity($address['city']);
        $this->address->setPostalCode($address['postalCode']);
        $this->address->setCountryCode($address['countryCode']);

        return $address;
    }
}
