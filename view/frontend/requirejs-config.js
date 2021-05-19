/*
 * requirejs-config | Backendorf
 *
 * @category  Backendorf
 * @package   requirejs-config.js
 *
 * @copyright Copyright (c) 2021 Backendorf - Magento Developer.
 *
 * @author    Davi Backendorf <davijacksonb@gmail.com>
 */
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
            },
        }
    }
};
