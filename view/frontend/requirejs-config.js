var config = {
    map: {
        '*': {
            installment: 'Backendorf_Installment/js/installment'
        }
    },
    config: {
        mixins: {
            'Magento_Catalog/js/price-box': {
                'Backendorf_Installment/js/price-box-mixin': true
            }
        }
    }
};
