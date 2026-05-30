<?php
declare(strict_types=1);

namespace Backendorf\Installment\Plugin\Block;

use Hyva\Theme\ViewModel\HyvaCsp;
use Magento\Framework\View\Element\AbstractBlock;
use Backendorf\Installment\Block\AllInstallments;
use Magento\Framework\View\Element\Template;

class Price
{
    /**
     * @param AbstractBlock $subject
     * @param $result
     * @return mixed|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterToHtml(AbstractBlock $subject, $result)
    {
        if ($subject->getNameInLayout() !== 'product.info.price') {
            return $result;
        }

        // Only inject via Plugin if it's a Hyva theme context
        if (!class_exists(HyvaCsp::class)) {
            return $result;
        }

        $layout = $subject->getLayout();
        if (!$layout) {
            return $result;
        }

        $allInstallmentsBlock = $layout->createBlock(
                AllInstallments::class,
                'product.info.installments'
        );

        if ($allInstallmentsBlock) {
            $allInstallmentsBlock->setTemplate('Backendorf_Installment::hyva/pdp-installments.phtml');
            return $result . $allInstallmentsBlock->toHtml();
        }

        return $result;
    }
}
