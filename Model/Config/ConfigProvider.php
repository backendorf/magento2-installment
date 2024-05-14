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
    protected Path $_configPath;

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $_scopeConfig;

    /**
     * @var Unserialize
     */
    protected Unserialize $_unserialize;

    /**
     * @var Json
     */
    private Json $_serializerJson;

    /**
     * @param ScopeConfigInterface $ScopeConfig
     * @param Path $ConfigPath
     * @param Unserialize $Unserialize
     * @param Json $SerializerJson
     */
    function __construct(
        ScopeConfigInterface $ScopeConfig,
        Path                 $ConfigPath,
        Unserialize          $Unserialize,
        Json                 $SerializerJson
    )
    {
        $this->_configPath = $ConfigPath;
        $this->_scopeConfig = $ScopeConfig;
        $this->_unserialize = $Unserialize;
        $this->_serializerJson = $SerializerJson;
    }

    /**
     * @return bool
     */
    public function isModuleEnable(): bool
    {
        return $this->_scopeConfig->isSetFlag($this->_configPath::MODULE_ENABLE);
    }

    /**
     * @return int
     */
    public function getMaximumQuantityInstallments(): int
    {
        return (int)$this->_scopeConfig->getValue($this->_configPath::MAXIMUM_QUANTITY_INSTALLMENTS);
    }

    /**
     * @return float
     */
    public function getMinimumInstallmentValue(): float
    {
        return (float)$this->_scopeConfig->getValue($this->_configPath::MINIMUM_INSTALLMENT_VALUE);
    }

    /**
     * @return bool
     */
    public function showAllInstallments(): bool
    {
        return $this->_scopeConfig->isSetFlag($this->_configPath::SHOW_ALL_INSTALLMENTS_ON_PRODUCT_PAGE);
    }

    /**
     * @return string
     */
    public function getInterestType(): string
    {
        return (string)$this->_scopeConfig->getValue($this->_configPath::INTEREST_TYPE);
    }

    /**
     * @param int $x
     * @return float|null
     */
    public function getInterestRate(int $x): ?float
    {
        return (float)$this->_scopeConfig->getValue($this->_configPath::INSTALLMENT_INTEREST_X . 'interest_' . $x);
    }

    /**
     * @return array
     */
    public function getDiscounts(): array
    {
        $value = $this->_scopeConfig->getValue($this->_configPath::DISCOUNTS);

        if (empty($value)) {
            return [];
        }

        if ($this->isSerialized($value)) {
            $unserializer = $this->_unserialize;
        } else {
            $unserializer = $this->_serializerJson;
        }

        return $unserializer->unserialize($value);
    }

    /**
     * @param $value
     * @return bool
     */
    private function isSerialized($value): bool
    {
        return (boolean)preg_match('/^((s|i|d|b|a|O|C):|N;)/', $value);
    }

    /**
     * @return bool
     */
    public function showFirstInstallment(): bool
    {
        return $this->_scopeConfig->isSetFlag($this->_configPath::SHOW_FIRST_INSTALLMENT);
    }

    /**
     * @return bool
     */
    public function bestInstallmentInCart(): bool
    {
        return $this->_scopeConfig->isSetFlag($this->_configPath::BEST_INSTALLMENT_IN_CART);
    }

    /**
     * @param string $page
     * @return string
     */
    public function getPriceTemplate(string $page): string
    {
        return (string)$this->_scopeConfig->getValue(str_replace('{{page}}', $page, $this->_configPath::PRICE_TEMPLATE));
    }

    /**
     * @return array
     */
    public function getStyles(): array
    {
        return [
            'primary-color' => $this->_scopeConfig->getValue($this->_configPath::PRIMARY_COLOR),
            'highlight-text-color' => $this->_scopeConfig->getValue($this->_configPath::HIGHLIGHT_TEXT_COLOR),
            'highlight-text-font-weight' => $this->_scopeConfig->getValue($this->_configPath::HIGLIGHT_TEXT_FONT_WEIGHT)
        ];
    }
}
