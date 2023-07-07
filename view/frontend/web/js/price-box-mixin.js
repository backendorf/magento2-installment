define([
    'jquery',
    'Magento_Catalog/js/price-utils',
    'underscore',
    'mage/template',
    'jquery/ui'
], function ($, utils, _, mageTemplate) {
    'use strict';

    return function (widget) {
        $.widget('mage.priceBox', widget,
            {
                reloadPrice: function reDrawPrices() {
                    let priceFormat = (this.options.priceConfig && this.options.priceConfig.priceFormat) || {},
                        priceTemplate = mageTemplate(this.options.priceTemplate);

                    _.each(this.cache.displayPrices, function (price, priceCode) {
                        price.final = _.reduce(price.adjustments, function (memo, amount) {
                            return memo + amount;
                        }, price.amount);

                        price.formatted = utils.formatPrice(price.final, priceFormat);

                        $('[data-price-type="' + priceCode + '"]', this.element).html(priceTemplate({
                            data: price
                        }));

                        if (priceCode === 'finalPrice') {
                            let element = this.element;
                            $('body').trigger('afterReloadPrice', {price, element});
                        }
                    }, this);
                }
            });
        return $.mage.priceBox;
    }
});
