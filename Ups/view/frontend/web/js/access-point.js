define([
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-service',
    'ko',
    'jquery'
], function(
    Component,
    quote,
    shippingService,
    ko,
    $
) {
    'use strict';

    return Component.extend({
        defaults: {
            locatorMethods : 'none',
            locationData: '',
            tracks: {
                locationData: true
            }
        },
        initialize: function(config) {
            this._super();   
            this.locatorMethods = window.checkoutConfig.footConfig.ups.locatorMethods?window.checkoutConfig.footConfig.ups.locatorMethods.split(","):'none';
            this.serviceUrl = window.checkoutConfig.footConfig.ups.serviceUrl;

            this.savedAddress = '';

            this.selectedShippingMethod = ko.computed(function () {

                var selectedMethod = quote.shippingMethod() ?
                    quote.shippingMethod()['carrier_code'] + '_' + quote.shippingMethod()['method_code'] :
                    null;
    
                return this.locatorMethods.indexOf(selectedMethod) !== -1;
                 
            }, this);

            this.getAccessPoint = ko.computed(function () {

                var self = this;

                if(this.selectedShippingMethod())
                {
                    if(quote.shippingAddress())
                    {
                        if(
                            quote.shippingAddress().region != undefined && 
                            quote.shippingAddress().city != undefined &&
                            quote.shippingAddress().street[0] != undefined &&
                            quote.shippingAddress().postcode != undefined &&
                            quote.shippingAddress().countryId != undefined
                        )
                        {
                            var address = {
                                'state' : quote.shippingAddress().region,
                                'city' : quote.shippingAddress().city,
                                'addressLine' : quote.shippingAddress().street[0],
                                'postCode' : quote.shippingAddress().postcode,
                                'countryCode' : quote.shippingAddress().countryId
                            }
    
                            var stringAddress = JSON.stringify(address);
    
                            if(stringAddress != this.savedAddress)
                            {
                                shippingService.isLoading(true);
                                $.ajax({
                                    type: 'POST',
                                    url: this.serviceUrl,
                                    contentType: "application/json",
                                    data: stringAddress,
                                    dataType: 'json',
                                    
                                    success: function(resp, textStatus, jqXHR) {
                                        if(textStatus == "success"){
                                            var response = JSON.parse(resp);
                                            var data = [];
    
                                            if(response.status == 'ok')
                                            {
                                                response.locations.forEach(function (location) {
                                                    data.push({
                                                        'name': location.name,
                                                        'street': location.address,
                                                        'value': location.value
                                                    });
                                                });
                                                self.savedAddress = stringAddress;
                                            }
                                            else
                                            {
                                                data ='error';
                                            }  
                                            self.locationData = data;                              
                                        }
                                    },
                                    complete: function(){
                                        shippingService.isLoading(false);
                                    }
                                    
                                });
                            }
                        }
                        else{
                            self.locationData = 'error';
                        }                        
                    }
                }
    
                return null;
            }, this); 
            
        }
    });
});
