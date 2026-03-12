<?php
declare(strict_types=1);

namespace Backendorf\Installment\Model\Config;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\Serialize\Serializer\Json;
use \Magento\Framework\Unserialize\Unserialize;

class ConfigProvider
{
    /**
     * @var Path
     */
    private Path $configPath;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var Json
     */
    private Json $serializerJson;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Path                 $configPath
     * @param Json                 $serializerJson
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Path                 $configPath,
        Json                 $serializerJson
    ) {
        $this->configPath = $configPath;
        $this->scopeConfig = $scopeConfig;
        $this->serializerJson = $serializerJson;
    }

    /**
     * @return bool
     */
    public function isModuleEnable(): bool
    {
        return $this->scopeConfig->isSetFlag($this->configPath::MODULE_ENABLE);
    }

    /**
     * @return int
     */
    public function getMaximumQuantityInstallments(): int
    {
        return (int)$this->scopeConfig->getValue($this->configPath::MAXIMUM_QUANTITY_INSTALLMENTS);
    }

    /**
     * @return float
     */
    public function getMinimumInstallmentValue(): float
    {
        return (float)$this->scopeConfig->getValue($this->configPath::MINIMUM_INSTALLMENT_VALUE);
    }

    /**
     * @return bool
     */
    public function showAllInstallments(): bool
    {
        return $this->scopeConfig->isSetFlag($this->configPath::SHOW_ALL_INSTALLMENTS_ON_PRODUCT_PAGE);
    }

    /**
     * @return string
     */
    public function getInterestType(): string
    {
        return (string)$this->scopeConfig->getValue($this->configPath::INTEREST_TYPE);
    }

    /**
     * @param  int $x
     * @return float|null
     */
    public function getInterestRate(int $x): ?float
    {
        return (float)$this->scopeConfig->getValue($this->configPath::INSTALLMENT_INTEREST_X . 'interest_' . $x);
    }

    /**
     * @return array
     */
    public function getDiscounts(): array
    {
        $value = $this->scopeConfig->getValue($this->configPath::DISCOUNTS);

        if (empty($value)) {
            return [];
        }

        try {
            return $this->serializerJson->unserialize($value);
        } catch (\Exception $e) {
            // Fallback for serialized data if needed, though Magento 2.2+ should use JSON
            if ($this->isSerialized($value)) {
                return unserialize($value);
            }
            return [];
        }
    }

    /**
     * @param  string|null $value
     * @return bool
     */
    private function isSerialized($value): bool
    {
        return $value !== null && (boolean)preg_match('/^((s|i|d|b|a|O|C):|N;)/', $value);
    }

    /**
     * @return bool
     */
    public function showFirstInstallment(): bool
    {
        return $this->scopeConfig->isSetFlag($this->configPath::SHOW_FIRST_INSTALLMENT);
    }


    /**
     * @param  string $page
     * @return string
     */
    public function getPriceTemplate(string $page): string
    {
        return (string)$this->scopeConfig->getValue(str_replace('{{page}}', $page, $this->configPath::PRICE_TEMPLATE));
    }

    /**
     * @return array
     */
    public function getStyles(): array
    {
        return [
            'primary-color' => $this->scopeConfig->getValue($this->configPath::PRIMARY_COLOR),
            'highlight-text-color' => $this->scopeConfig->getValue($this->configPath::HIGHLIGHT_TEXT_COLOR),
            'highlight-text-font-weight' => $this->scopeConfig->getValue($this->configPath::HIGLIGHT_TEXT_FONT_WEIGHT)
        ];
    }
}
