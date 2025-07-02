<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Footdistrict\Ups\Model;

use Footdistrict\Ups\Api\AddressInterface;

/**
 * Payment additional info class.
 */
class Address implements AddressInterface
{
    /**
     * @var string
     */
    private $addressline;

    /**
     * @var string
     */
    private $city;

        /**
     * @var string
     */
    private $postalCode;

        /**
     * @var string
     */
    private $countryCode;

       /**
     * Get object id
     *
     * @return string
     */
    public function getAdressLine(){
        return $this->addressline;
    }

    /**
     * Set object id
     *
     * @param string $id
     * @return $this
     */
    public function setAdressLine($addressline){
        $this->addressline = $addressline;
        return $addressline;
    }

    /**
     * Get object value
     *
     * @return string
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * Set object name
     *
     * @param string $name
     * @return $this
     */
    public function setCity($city){
        $this->city = $city;
        return $city;
    }

    /**
     * Get object address
     *
     * @return string
     */
    public function getPostalCode(){
        return $this->postalCode;
    }

    /**
     * Set object address
     *
     * @param string $address
     * @return $this
     */
    public function setPostalCode($postalCode){
        $this->postalCode = $postalCode;
        return $postalCode;
    }

        /**
     * Get object address
     *
     * @return string
     */
    public function getCountryCode(){
        return $this->countryCode;
    }

    /**
     * Set object address
     *
     * @param string $address
     * @return $this
     */
    public function setCountryCode($countryCode){
        $this->countryCode = $countryCode;
        return $countryCode;
    }

}
