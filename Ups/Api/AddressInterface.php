<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Footdistrict\Ups\Api;

/**
 * Interface \Magento\Framework\DataObject\KeyValueObjectInterface
 *
 */
interface AddressInterface
{
    const ADDRESSLINE = 'addressline';
    const CITY = 'city';
    const POSTALCODE = 'postalCode';
    const COUNTRYCODE = 'countryCode';



    /**
     * Get object id
     *
     * @return string
     */
    public function getAdressLine();

    /**
     * Set object id
     *
     * @param string $id
     * @return $this
     */
    public function setAdressLine($addressline);

    /**
     * Get object value
     *
     * @return string
     */
    public function getCity();

    /**
     * Set object name
     *
     * @param string $name
     * @return $this
     */
    public function setCity($city);

    /**
     * Get object address
     *
     * @return string
     */
    public function getPostalCode();

    /**
     * Set object address
     *
     * @param string $address
     * @return $this
     */
    public function setPostalCode($postalCode);

        /**
     * Get object address
     *
     * @return string
     */
    public function getCountryCode();

    /**
     * Set object address
     *
     * @param string $address
     * @return $this
     */
    public function setCountryCode($countryCode);
}
