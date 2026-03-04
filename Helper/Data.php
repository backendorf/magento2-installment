<?php
declare(strict_types=1);

namespace Backendorf\Installment\Helper;

use \Backendorf\Installment\Model\Config\ConfigProvider;
use Magento\Catalog\Model\Product;
use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\Pricing\PriceCurrencyInterface;

class Data extends AbstractHelper
{
    /**
     * @var ConfigProvider
     */
    private ConfigProvider $configProvider;

    /**
     * @var PriceCurrencyInterface
     */
    private PriceCurrencyInterface $priceCurrency;

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        Context                $context,
        ConfigProvider         $configProvider,
        PriceCurrencyInterface $priceCurrency
    )
    {
        parent::__construct($context);
        $this->configProvider = $configProvider;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $config = [
            'enabled' => $this->configProvider->isModuleEnable(),
            'interest_type' => $this->configProvider->getInterestType(),
            'maximum_quantity_installments' => $this->configProvider->getMaximumQuantityInstallments(),
            'minimum_installment_value' => $this->configProvider->getMinimumInstallmentValue(),
            'discounts' => $this->configProvider->getDiscounts(),
            'interest' => [],
            'currency_symbol' => $this->priceCurrency->getCurrencySymbol(),
            'show_first_installment' => $this->configProvider->showFirstInstallment(),
            'templates' => [
                'catalog_category_view' => $this->configProvider->getPriceTemplate('catalog_category_view'),
                'catalogsearch_result_index' => $this->configProvider->getPriceTemplate('catalogsearch_result_index'),
                'catalog_product_view' => $this->configProvider->getPriceTemplate('catalog_product_view'),
                'discount_template' => $this->configProvider->getPriceTemplate('discount_template'),
                'all_installment_template' => $this->configProvider->getPriceTemplate('all_installment_template'),
                'text_free_interest' => $this->configProvider->getPriceTemplate('text_free_interest'),
                'text_with_interest' => $this->configProvider->getPriceTemplate('text_with_interest')
            ]
        ];

        $maxInstallments = $config['maximum_quantity_installments'];
        for ($i = 1; $i <= $maxInstallments; $i++) {
            $config['interest'][$i] = (float)$this->configProvider->getInterestRate($i);
        }

        return $config;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function showAllInstallments(Product $product): bool
    {
        if (!$this->configProvider->isModuleEnable() || !$this->configProvider->showAllInstallments()) {
            return false;
        }

        $productPrice = $this->getProductPrice($product);
        $minInstallment = $this->configProvider->getMinimumInstallmentValue();

        return $productPrice >= $minInstallment;
    }

    /**
     * @param Product $product
     * @return float
     */
    private function getProductPrice(Product $product): float
    {
        $minimalPrice = $product->getMinimalPrice();
        if ($minimalPrice > 0) {
            return $minimalPrice;
        }

        return (float)$product->getPriceInfo()->getPrice('final_price')->getAmount()->getValue();
    }

    /**
     * @return array
     */
    public function getStyles(): array
    {
        return $this->configProvider->getStyles();
    }
}
