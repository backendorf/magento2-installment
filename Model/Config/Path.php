<?php
declare(strict_types=1);

namespace Backendorf\Installment\Model\Config;

class Path
{
    const BASE_PATH = 'backendorf_installment';
    const MODULE_ENABLE = self::BASE_PATH . '/general/is_enabled';
    const MAXIMUM_QUANTITY_INSTALLMENTS = self::BASE_PATH . '/general/maximum_quantity_installments';
    const MINIMUM_INSTALLMENT_VALUE = self::BASE_PATH . '/general/minimum_installment_value';
    const SHOW_ALL_INSTALLMENTS_ON_PRODUCT_PAGE = self::BASE_PATH . '/general/show_all_installments_on_product_page';
    const INTEREST_TYPE = self::BASE_PATH . '/interest/type';
    const INSTALLMENT_INTEREST_X = self::BASE_PATH . '/interest/';
    const DISCOUNTS = self::BASE_PATH . '/discounts/discounts';
    const SHOW_FIRST_INSTALLMENT = self::BASE_PATH . '/general/show_first_installment';
    const BEST_INSTALLMENT_IN_CART = self::BASE_PATH . '/general/best_installment_in_cart';
    const PRICE_TEMPLATE = self::BASE_PATH . '/price_templates/{{page}}';
    const PRIMARY_COLOR = self::BASE_PATH . '/styles/primary_color';
    const HIGHLIGHT_TEXT_COLOR = self::BASE_PATH . '/styles/highlight_text_color';
    const HIGLIGHT_TEXT_FONT_WEIGHT = self::BASE_PATH . '/styles/highlight_text_font_weight';
}
