<?php
declare(strict_types=1);

namespace Backendorf\Installment\Model\Config\Source;

use \Magento\Framework\Option\ArrayInterface;

class InterestType implements ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'simple',
                'label' => __('Simple')
            ],
            [
                'value' => 'compound',
                'label' => __('Compound')
            ]
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'simples' => __('Simple'),
            'compound' => __('Compound')
        ];
    }
}
