<?php
declare(strict_types=1);

namespace Backendorf\Installment\Model\Config\Source;

use \Magento\Framework\Option\ArrayInterface;

class MaximumQuantityInstallments implements ArrayInterface
{

    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => '1',
                'label' => __('1')
            ],
            [
                'value' => '2',
                'label' => __('2')
            ],
            [
                'value' => '3',
                'label' => __('3')
            ],
            [
                'value' => '4',
                'label' => __('4')
            ],
            [
                'value' => '5',
                'label' => __('5')
            ],
            [
                'value' => '6',
                'label' => __('6')
            ],
            [
                'value' => '7',
                'label' => __('7')
            ],
            [
                'value' => '8',
                'label' => __('8')
            ],
            [
                'value' => '9',
                'label' => __('9')
            ],
            [
                'value' => '10',
                'label' => __('10')
            ],
            [
                'value' => '11',
                'label' => __('11')
            ],
            [
                'value' => '12',
                'label' => __('12')
            ]
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            '1' => __('1'),
            '2' => __('2'),
            '3' => __('3'),
            '4' => __('4'),
            '5' => __('5'),
            '6' => __('6'),
            '7' => __('7'),
            '8' => __('8'),
            '9' => __('9'),
            '10' => __('10'),
            '11' => __('11'),
            '12' => __('12')
        ];
    }
}
