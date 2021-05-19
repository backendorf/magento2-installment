<?php

/**
 * InterestType | Backendorf
 *
 * @category  Backendorf
 * @package   InterestType.php
 *
 * @copyright Copyright (c) 2020 Backendorf - Magento Developer.
 *
 * @author    Davi Backendorf <davijacksonb@gmail.com>
 */

namespace Backendorf\Installment\Model\Config\Source;

use \Magento\Framework\Option\ArrayInterface;

/**
 * Class InterestType
 * @package Backendorf\Installment\Model\Config\Source
 */
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
