<?php
declare(strict_types=1);

namespace Backendorf\Installment\Plugin\Hyva\Theme\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutInterface;

class ProductListItem
{
    private LayoutInterface $layout;

    /**
     * @param LayoutInterface $layout
     */
    public function __construct(
        LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    /**
     * @param  \Hyva\Theme\ViewModel\ProductListItem $subject
     * @param  \Closure                              $proceed
     * @param  Product                               $product
     * @param  array                                 $priceRendererBlockArgs
     * @return string
     */
    public function aroundGetProductPriceHtml(
        \Hyva\Theme\ViewModel\ProductListItem $subject,
        \Closure                              $proceed,
        Product                               $product,
        array                                 $priceRendererBlockArgs = []
    ): string {
        $result = $proceed($product, $priceRendererBlockArgs);

        $customHtml = $this->layout
            ->createBlock(Template::class)
            ->setTemplate('Backendorf_Installment::hyva/list-item-price.phtml')
            ->setData('product', $product)
            ->toHtml();

        return $result . $customHtml;
    }
}
