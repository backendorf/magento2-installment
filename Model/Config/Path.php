<?php

/**
 * Path | Backendorf
 *
 * @category  Backendorf
 * @package   Path.php
 *
 * @copyright Copyright (c) 2020 Backendorf - Magento Developer.
 *
 * @author    Davi Backendorf <davijacksonb@gmail.com>
 */

namespace Backendorf\Installment\Model\Config;

/**
 * Class Path
 * @package Backendorf\Installment\Model\Config
 */
class Path
{
    const MODULE_ENABLE                         = 'backendorf_installment/general/is_enabled';
    const MAXIMUM_QUANTITY_INSTALLMENTS         = 'backendorf_installment/general/maximum_quantity_installments';
    const MINIMUM_INSTALLMENT_VALUE             = 'backendorf_installment/general/minimum_installment_value';
    const SHOW_ALL_INSTALLMENTS_ON_PRODUCT_PAGE = 'backendorf_installment/general/show_all_installments_on_product_page';
    const INTEREST_TYPE                         = 'backendorf_installment/interest/type';
    const INSTALLMENT_INTEREST_X                = 'backendorf_installment/interest/';
    const DISCOUNTS                             = 'backendorf_installment/discounts/discounts';
    const SHOW_FIRST_INSTALLMENT                = 'backendorf_installment/general/show_first_installment';
    const BEST_INSTALLMENT_IN_CART              = 'backendorf_installment/general/best_installment_in_cart';
    const PRICE_TEMPLATE                        = 'backendorf_installment/price_templates/{{page}}';
}
