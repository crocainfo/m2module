<?php

namespace Footdistrict\Ups\Block;

class LayoutProcessor implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
{
    public function process($jsLayout)
    {
        $jsLayout['components']['checkout']['children']
        ['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['vat_id']['validation']['required-entry']= true;

        $jsLayout['components']['checkout']['children']
        ['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['region_id']['config']['component'] = "Footdistrict_Checkout/js/form/element/region-mixin";

        return $jsLayout;
    }
}