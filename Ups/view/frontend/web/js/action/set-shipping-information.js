define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {

            var shippingAddress = quote.shippingAddress();
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            var access_point_value = $( 'input[name="accessPoint"]:checked' ).val();
            if(access_point_value){
                access_point_value = access_point_value.replaceAll("'", '"');
            }
            
            shippingAddress['extension_attributes']['access_point'] = access_point_value;

            return originalAction();
        });
    };
});
