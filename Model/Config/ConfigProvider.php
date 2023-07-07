<?php
declare(strict_types=1);

namespace Backendorf\Installment\Model\Config;

use \Magento\Config\Model\ResourceModel\Config;
use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use \Magento\Framework\Serialize\Serializer\Json;
use \Magento\Framework\Unserialize\Unserialize;
use \Magento\Store\Model\ScopeInterface;
use \Magento\Store\Model\StoreManagerInterface;

class ConfigProvider
{
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    /**
     * @var Path
     */
    protected Path $_configPath;

    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $_scopeConfig;

    /**
     * @var Config
     */
    protected Config $_resourceConfig;

    /**
     * @var Unserialize
     */
    protected Unserialize $_unserialize;

    /**
     * @var Json
     */
    private Json $_serializerJson;

    /**
     * @param StoreManagerInterface $StoreManager
     * @param ScopeConfigInterface $ScopeConfig
     * @param Path $ConfigPath
     * @param Config $ResourceConfig
     * @param Unserialize $Unserialize
     * @param Json $SerializerJson
     */
    function __construct(
        StoreManagerInterface $StoreManager,
        ScopeConfigInterface  $ScopeConfig,
        Path                  $ConfigPath,
        Config                $ResourceConfig,
        Unserialize           $Unserialize,
        Json                  $SerializerJson
    )
    {
        $this->_storeManager = $StoreManager;
        $this->_configPath = $ConfigPath;
        $this->_scopeConfig = $ScopeConfig;
        $this->_resourceConfig = $ResourceConfig;
        $this->_unserialize = $Unserialize;
        $this->_serializerJson = $SerializerJson;
    }

    /**
     * @return bool
     */
    public function isModuleEnable(): bool
    {
        return (bool)$this->getConfigValue($this->_configPath::MODULE_ENABLE);
    }

    /**
     * @return int
     */
    public function getMaximumQuantityInstallments(): int
    {
        return (int)$this->getConfigValue($this->_configPath::MAXIMUM_QUANTITY_INSTALLMENTS);
    }

    /**
     * @return float
     */
    public function getMinimumInstallmentValue(): float
    {
        return (float)$this->getConfigValue($this->_configPath::MINIMUM_INSTALLMENT_VALUE);
    }

    /**
     * @return bool
     */
    public function showAllInstallments(): bool
    {
        return (bool)$this->getConfigValue($this->_configPath::SHOW_ALL_INSTALLMENTS_ON_PRODUCT_PAGE);
    }

    /**
     * @return string
     */
    public function getInterestType(): string
    {
        return (string)$this->getConfigValue($this->_configPath::INTEREST_TYPE);
    }

    /**
     * @param int $x
     * @return float|null
     */
    public function getInterestRate(int $x): ?float
    {
        return (float)$this->getConfigValue($this->_configPath::INSTALLMENT_INTEREST_X . 'interest_' . $x);
    }

    /**
     * @return array
     */
    public function getDiscounts(): array
    {
        $value = $this->getConfigValue($this->_configPath::DISCOUNTS);

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
        return (bool)$this->getConfigValue($this->_configPath::SHOW_FIRST_INSTALLMENT);
    }

    /**
     * @return bool
     */
    public function bestInstallmentInCart(): bool
    {
        return (bool)$this->getConfigValue($this->_configPath::BEST_INSTALLMENT_IN_CART);
    }

    /**
     * @param string $page
     * @return string
     */
    public function getPriceTemplate(string $page): string
    {
        return (string)$this->getConfigValue(str_replace('{{page}}', $page, $this->_configPath::PRICE_TEMPLATE));
    }

    /**
     * @param string $configPath
     * @return mixed
     */
    private function getConfigValue(string $configPath): mixed
    {
        $storeId = $this->getStoreId();
        if (!$storeId) {
            return null;
        }

        return $this->_scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return int|null
     */
    private function getStoreId()
    {
        try {
            return $this->_storeManager->getStore()->getStoreId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
