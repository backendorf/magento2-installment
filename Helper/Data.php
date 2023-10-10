<?php
declare(strict_types=1);

namespace Backendorf\Installment\Helper;

use \Backendorf\Installment\Model\Config\ConfigProvider;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\Pricing\PriceCurrencyInterface;

class Data extends AbstractHelper
{
    /**
     * @var ConfigProvider
     */
    protected ConfigProvider $_configProvider;

    /**
     * @var PriceCurrencyInterface
     */
    protected PriceCurrencyInterface $_priceCurrency;

    /**
     * @param Context $context
     * @param ConfigProvider $ConfigProvider
     * @param PriceCurrencyInterface $PriceCurrency
     */
    public function __construct(
        Context                $context,
        ConfigProvider         $ConfigProvider,
        PriceCurrencyInterface $PriceCurrency
    )
    {
        parent::__construct($context);
        $this->_configProvider = $ConfigProvider;
        $this->_priceCurrency = $PriceCurrency;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $config = [];
        $config['enabled'] = $this->_configProvider->isModuleEnable();
        $config['interest_type'] = $this->_configProvider->getInterestType();
        $config['maximum_quantity_installments'] = $this->_configProvider->getMaximumQuantityInstallments();
        $config['minimum_installment_value'] = $this->_configProvider->getMinimumInstallmentValue();
        $config['discounts'] = $this->_configProvider->getDiscounts();
        $config['best_installment_in_cart'] = $this->_configProvider->bestInstallmentInCart();
        $config['interest'] = [];
        $config['currency_symbol'] = $this->_priceCurrency->getCurrencySymbol();
        $config['show_first_installment'] = $this->_configProvider->showFirstInstallment();
        $config['templates'] = [
            'catalog_category_view' => $this->_configProvider->getPriceTemplate('catalog_category_view'),
            'catalogsearch_result_index' => $this->_configProvider->getPriceTemplate('catalogsearch_result_index'),
            'catalog_product_view' => $this->_configProvider->getPriceTemplate('catalog_product_view'),
            'discount_template' => $this->_configProvider->getPriceTemplate('discount_template'),
            'all_installment_template' => $this->_configProvider->getPriceTemplate('all_installment_template'),
            'in_cart_template' => $this->_configProvider->getPriceTemplate('in_cart_template'),
            'text_free_interest' => $this->_configProvider->getPriceTemplate('text_free_interest'),
            'text_with_interest' => $this->_configProvider->getPriceTemplate('text_with_interest')
        ];

        for ($i = 1; $i < 13; $i++) {
            $config['interest'][$i] = (double)$this->_configProvider->getInterestRate($i);
        }

        return $config;
    }

    /**
     * @param $product
     * @return bool
     */
    public function showAllInstallments($product): bool
    {
        if (!$this->_configProvider->isModuleEnable() || !$this->_configProvider->showAllInstallments()) {
            return false;
        }

        if (!$product) {
            $this->_logger->alert(__('Missing product parameter on showAllInstallments()'));
            return false;
        }

        $productPrice = $this->getProductPrice($product);
        $minInstallment = $this->_configProvider->getMinimumInstallmentValue();

        if (($productPrice < $minInstallment)) {
            return false;
        }

        return true;
    }

    /**
     * @param $product
     * @return float
     */
    private function getProductPrice($product): float
    {
        return (float)($product->getMinimalPrice()) ? $product->getMinimalPrice() : $product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue();
    }
}
