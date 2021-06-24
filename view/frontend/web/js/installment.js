/*
 * installment | Backendorf
 *
 * @category  Backendorf
 * @package   installment.js
 *
 * @copyright Copyright (c) 2020 Backendorf - Magento Developer.
 *
 * @author    Davi Backendorf <davijacksonb@gmail.com>
 */

define([
    "jquery",
    'Magento_Catalog/js/price-utils',
    'mage/translate',
    'Magento_Customer/js/customer-data'
], function ($, priceUtils, $t, customerData) {
    'use strict';
    $.widget('mage.installment', {
        'options': {
            'discounts': [],
            'interest_type': null,
            'minimum_installment_value': null,
            'maximum_quantity_installments': null,
            'interest': null,
            'best_installment_in_cart': null,
            'currency_symbol': '',
            'show_first_installment': false,
            'templates': {
                'in_cart_template': null,
                'discount_template': null,
                'catalog_category_view': null,
                'catalog_product_view': null,
                'catalogsearch_result_index': null,
                'all_installment_template': null,
                'text_with_interest': null,
                'text_free_interest': null
            }
        },
        _create: function () {
            let widget = this;
            console.info(widget.options);
            localStorage.setItem('all_product_prices', JSON.stringify([]));

            if (this.options.enabled) {
                try {
                    $('.price-box.price-final_price').each(function (i, element) {
                        widget.renderPrices(element);
                        if ($(element).parents('.product-info-price').length > 0) {
                            widget.updateAllInstallments(element);
                        }

                        $('body').on('afterReloadPrice', function (e, data) {
                            if (!$(data.element).hasClass('price-tier_price')) {
                                let lowestPrice = widget.getLowestPrice({
                                    product_id: $(data.element).attr('data-product-id'),
                                    price: data.price.final
                                });
                                widget.renderPrices(data.element, {amount: lowestPrice.price});

                                if ($(data.element).parents('.product-info-price').length > 0) {
                                    widget.updateAllInstallments(data.element, {amount: lowestPrice.price});
                                }
                            }
                        });
                    });

                    if (this.options.best_installment_in_cart && $('#cart-totals').length > 0 && window.checkoutConfig.quoteData) {
                        widget.initPricesInCart();

                        customerData.get('cart').subscribe(function () {
                            widget.initPricesInCart();
                        });
                    }
                } catch (e) {
                    console.info(e);
                }
            }
        },
        getLowestPrice: function (price) {
            let prices = JSON.parse(localStorage.getItem('all_product_prices'));

            prices.push({
                product_id: price.product_id,
                price: price.price
            })

            let lowest = {
                product_id: price.product_id,
                price: price.price
            };

            for (let i in prices) {
                if (prices[i].product_id === price.product_id && prices[i].price < lowest.price) {
                    lowest = prices[i];
                }
            }

            localStorage.setItem('all_product_prices', JSON.stringify(prices));
            return lowest;
        },
        initPricesInCart: function () {
            $('#cart-totals .backendorf-installment').remove();
            let price = this.getSubtotal();
            let installments = this.getInstallments(price);
            if (installments) {
                let bestInstallment = this.getBestInstallment(installments);
                const template = this.options.templates.in_cart_template;

                let html = template.replace('{{qty}}', bestInstallment.installments_qty)
                    .replace('{{value}}', bestInstallment.installment_value)
                    .replace('{{interest}}', (this.renderInterest(bestInstallment)))
                $('#cart-totals').append('<div class="backendorf-installment">' + html + '</div>');
            }
        },
        /**
         *
         * @param productPrice
         * @returns {{}}
         */
        getInstallments: function (productPrice) {
            let widget = this;
            const type_interest = this.options.interest_type;
            const info_interest = this.options.interest;
            const min_installment = this.options.minimum_installment_value;
            const max_installment = this.options.maximum_quantity_installments;

            let json_installments = {};
            if (this.options.show_first_installment) {
                json_installments[1] = {
                    'installments_qty': 1,
                    'installment_value': widget.formatPrice(productPrice),
                    'total_installment': widget.formatPrice(productPrice),
                    'total_interest': 0,
                    'has_interest': 0
                };
            } else {
                if ((productPrice < min_installment) || ((productPrice / 2) < min_installment)) {
                    console.info('Installment not available for this product. Very low price:' + this.formatPrice(productPrice));
                    return null;
                }
            }

            let max_div = (productPrice / min_installment);
            max_div = parseInt(max_div);

            if (max_div > max_installment) {
                max_div = max_installment;
            } else {
                if (max_div > 12) {
                    max_div = 12;
                }
            }

            let limit = max_div;
            for (let installment_number in info_interest) {
                installment_number = parseInt(installment_number);
                if (installment_number <= max_div) {
                    let rate = info_interest[installment_number] / 100;
                    let amount = 0;
                    let installment_value = 0;

                    if (rate > 0) {
                        if (type_interest === "compound") {
                            amount = productPrice * Math.pow((1 + rate), installment_number);
                            installment_value = amount / installment_number;
                        } else {
                            amount = productPrice + (productPrice * rate * installment_number);
                            installment_value = (productPrice * (1 + rate * installment_number)) / installment_number;
                        }

                        let total_interest = amount - productPrice;

                        if (installment_value > 5 && installment_value > min_installment) {
                            json_installments[installment_number] = {
                                'installments_qty': installment_number,
                                'installment_value': widget.formatPrice(installment_value),
                                'total_interest': widget.formatPrice(total_interest),
                                'amount': widget.formatPrice(amount),
                                'has_interest': true,
                                'rate': info_interest[installment_number] + "%"
                            };
                        }
                    } else {
                        if (productPrice > 0 && installment_number > 0) {
                            json_installments[installment_number] = {
                                'installments_qty': installment_number,
                                'installment_value': widget.formatPrice((productPrice / installment_number)),
                                'total_interest': widget.formatPrice(0),
                                'amount': widget.formatPrice(productPrice),
                                'has_interest': false,
                                'rate': info_interest[installment_number] + "%"
                            };
                        }
                    }
                }
            }

            _.each(json_installments, function (key) {
                if (key > limit) {
                    delete json_installments[key];
                }
            });

            console.info('json_installments');
            console.info(json_installments);
            return json_installments;
        },
        /**
         *
         * @param installment
         * @returns {*}
         */
        getBestInstallment: function (installment) {
            let best = null;
            for (let i = this.options.maximum_quantity_installments; i >= 1; i--) {
                if (installment[i]) {
                    if (!best) {
                        best = installment[i];
                    }

                    if (!installment[i]['has_interest']) {
                        return installment[i];
                    }
                }
            }

            return best;
        },
        /**
         *
         * @param price
         * @returns {[]}
         */
        getDiscounts: function (price) {
            for (let i in this.options.discounts) {
                let discount = this.options.discounts[i];
                if (discount.hasOwnProperty('percentage')) {
                    discount.value = this.formatPrice(price - ((price * discount.percentage) / 100));
                    this.options.discounts[i] = discount;
                }
            }
            return this.options.discounts;

        },
        /**
         *
         * @param discounts
         * @returns {string}
         */
        renderDiscounts: function (discounts) {
            let html = '<ul>';
            for (let i in discounts) {
                html += '<li class="item">' + this.options.templates.discount_template
                    .replace('{{valueWithDiscount}}', discounts[i].value)
                    .replace('{{percentage}}', discounts[i].percentage + '%')
                    .replace('{{name}}', '<span class="name">' + discounts[i].name + '</span>') + '</li>';
            }
            html += '</ul>';
            return html;
        },
        /**
         *
         * @param installments
         */
        updateAllInstallments: function (priceElement, prices = null) {
            let price = (prices) ? prices.amount : this.getElmPrice(priceElement);
            let installments = this.getInstallments(price);
            if (installments) {
                let template = this.options.templates.all_installment_template;

                let html = '<ul class="installments-options">';
                for (let i in installments) {
                    html += '<li class="installment-option">' + template.replace('{{qty}}', installments[i]['installments_qty'])
                        .replace('{{value}}', installments[i]['installment_value'])
                        .replace('{{interest}}', (this.renderInterest(installments[i]))) + '</li>';
                }
                html += '</ul>';
                $('.backendorf-installment .all-installments-content').html(html);
            }
        },
        /**
         *
         * @returns {null}
         */
        getTemplate() {
            if ($('body.catalog-category-view').length > 0) {
                return this.options.templates.catalog_category_view;
            } else if ($('body.catalog-product-view').length > 0) {
                return this.options.templates.catalog_product_view;
            } else if ($('body.catalogsearch-result-index').length > 0) {
                return this.options.templates.catalogsearch_result_index;
            } else {
                return this.options.templates.catalog_product_view;
            }
        },
        /**
         *
         * @param priceElement
         * @param prices
         */
        renderPrices: function (priceElement, prices = null) {
            let template = this.getTemplate();
            let price = (prices) ? prices.amount : this.getElmPrice(priceElement);
            let installments = this.getInstallments(price);
            if (installments) {
                let data = {
                    'bestInstallment': this.getBestInstallment(installments),
                    'discounts': this.renderDiscounts(this.getDiscounts(price))
                };

                template = template
                    .replace('{{default}}', '<div class="default"></div>')
                    .replace('{{qty}}', '<div class="best-installment">' + data.bestInstallment.installments_qty)
                    .replace('{{value}}', data.bestInstallment.installment_value)
                    .replace('{{interest}}', (this.renderInterest(data.bestInstallment)) + '</div>')
                    .replace('{{discounts}}', '<div class="discounts">' + data.discounts + '</div>');

                let installmentDiv = ($(priceElement).closest('.backendorf-installment').length > 0) ? $(priceElement).closest('.backendorf-installment') : null;
                if (installmentDiv) {
                    $(priceElement).insertBefore($(installmentDiv));
                    $(installmentDiv).html(template);
                } else {
                    installmentDiv = $('<div class="backendorf-installment">' + template + '</div>');
                    installmentDiv.insertBefore(priceElement);
                }
                $(installmentDiv).find('.default').replaceWith(priceElement);
            }
        },
        /**
         *
         * @param elm
         * @returns {number}
         */
        getElmPrice: function (elm) {
            return parseFloat($(elm).find('.price-wrapper').attr('data-price-amount'));
        },
        /**
         *
         * @returns {number}
         */
        getSubtotal: function () {
            return parseFloat(window.checkoutConfig.quoteData.subtotal_with_discount);
        },
        /**
         * @param price
         * @returns {*}
         */
        formatPrice: function (price) {
            let format = {
                decimalSymbol: ",",
                groupLength: 3,
                groupSymbol: ".",
                integerRequired: false,
                pattern: this.options.currency_symbol + "%s",
                precision: 2,
                requiredPrecision: 2
            };

            format = (window.checkoutConfig && window.checkoutConfig.priceFormat) ? window.checkoutConfig.priceFormat : format;
            return priceUtils.formatPrice(price, format);
        },
        renderInterest: function (installment) {
            let template = (installment.has_interest) ? this.options.templates.text_with_interest : this.options.templates.text_free_interest;
            template = template.replace('{{amount}}', installment.amount)
                .replace('{{total_interest}}', installment.total_interest)
                .replace('{{rate}}', installment.rate)
            return ' ' + template;
        }
    });
    return $.mage.installment;
});
