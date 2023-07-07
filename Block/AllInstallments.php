<?php
declare(strict_types=1);

namespace Backendorf\Installment\Block;

use \Backendorf\Installment\Helper\Data as helperData;
use \Magento\Catalog\Api\ProductRepositoryInterface;
use \Magento\Catalog\Block\Product\Context;
use \Magento\Catalog\Block\Product\View;
use \Magento\Catalog\Helper\Product;
use \Magento\Catalog\Model\ProductTypes\ConfigInterface;
use \Magento\Customer\Model\Session;
use \Magento\Framework\Locale\FormatInterface;
use \Magento\Framework\Pricing\PriceCurrencyInterface;
use \Magento\Framework\Stdlib\StringUtils;
use \Magento\Framework\Url\EncoderInterface as urlEncoder;
use \Magento\Framework\Json\EncoderInterface as jsonEncoder;

class AllInstallments extends View
{
    /**
     * @var helperData
     */
    public helperData $_helperData;

    /**
     * @param helperData $HelperData
     * @param Context $context
     * @param urlEncoder $urlEncoder
     * @param jsonEncoder $jsonEncoder
     * @param StringUtils $stringUtils
     * @param Product $productHelper
     * @param ConfigInterface $productTypeConfig
     * @param FormatInterface $localeFormat
     * @param Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        helperData                 $HelperData,
        Context                    $context,
        urlEncoder                 $urlEncoder,
        jsonEncoder                $jsonEncoder,
        StringUtils                $stringUtils,
        Product                    $productHelper,
        ConfigInterface            $productTypeConfig,
        FormatInterface            $localeFormat,
        Session                    $customerSession,
        ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface     $priceCurrency,
        array                      $data = []
    )
    {
        $this->_helperData = $HelperData;
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $stringUtils,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );
    }

    /**
     * @return bool
     */
    public function renderAllInstallments(): bool
    {
        return $this->_helperData->showAllInstallments($this->getProduct());
    }
}
