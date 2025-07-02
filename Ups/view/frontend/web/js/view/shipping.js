define([
    'jquery',
    'underscore',
    'Magento_Ui/js/form/form',
    'ko',
    'Magento_Customer/js/model/customer',
    'Magento_Customer/js/model/address-list',
    'Magento_Checkout/js/model/address-converter',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/action/create-shipping-address',
    'Magento_Checkout/js/action/select-shipping-address',
    'Magento_Checkout/js/model/shipping-rates-validator',
    'Magento_Checkout/js/model/shipping-address/form-popup-state',
    'Magento_Checkout/js/model/shipping-service',
    'Magento_Checkout/js/action/select-shipping-method',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'Magento_Checkout/js/action/set-shipping-information',
    'Magento_Checkout/js/model/step-navigator',
    'Magento_Ui/js/modal/modal',
    'Magento_Checkout/js/model/checkout-data-resolver',
    'Magento_Checkout/js/checkout-data',
    'uiRegistry',
    'mage/translate',
    'Magento_Checkout/js/model/shipping-rate-service'

], function (
    $,
    _,
    Component,
    ko,
    customer,
    addressList,
    addressConverter,
    quote,
    createShippingAddress,
    selectShippingAddress,
    shippingRatesValidator,
    formPopUpState,
    shippingService,
    selectShippingMethodAction,
    rateRegistry,
    setShippingInformationAction,
    stepNavigator,
    modal,
    checkoutDataResolver,
    checkoutData,
    registry,
    $t
    ) {
    'use strict';

    return function (shipping) {
        return shipping.extend({
            validateShippingInformation: function () {
                var superResult = this._super(),
                messageContainer = registry.get('checkout.errors').messageContainer;
                if($('fieldset[data-index="access_point"]').is(":visible")){
                    if (!$('fieldset[data-index="access_point"] input[name="accessPoint"]').is(':checked')) {
                        this.errorValidationMessage(
                            $t('Select a pickup point to continue.')
                        );
                        return false;
                    }
                }


                if($('input[name="vat_id"]').attr('required') !== undefined){

                    if($('input[name="vat_id"]').val().length == 0){
                        messageContainer.addErrorMessage({
                            message: $t('Please specify a Tax/VAT in shipping address.')
                        });
                        return false;
                    }
                }



               return superResult;
            },
        });
    };
});
