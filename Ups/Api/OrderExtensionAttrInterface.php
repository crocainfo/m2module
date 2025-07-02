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
interface OrderExtensionAttrInterface
{
    const ID = 'ID';
    const NAME = 'NAME';
    const ADDRESS = 'ADDRESS';


    /**
     * Get object id
     *
     * @return string
     */
    public function getId();

    /**
     * Set object id
     *
     * @param string $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get object value
     *
     * @return string
     */
    public function getName();

    /**
     * Set object name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get object address
     *
     * @return \Footdistrict\Ups\Api\AddressInterface
     */
    public function getAddress();

    /**
     * Set object address
     *
     * @param array $address
     * @return $this
     */
    public function setAddress($Adress);
}
