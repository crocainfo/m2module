var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Footdistrict_Ups/js/action/set-shipping-information': true
            } ,      
            'Magento_Checkout/js/view/shipping': {
                'Footdistrict_Ups/js/view/shipping': true
            }    
        }
    }
};


