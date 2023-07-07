<?php
declare(strict_types=1);

namespace Backendorf\Installment\Block\Adminhtml\Form\Field;

use \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Discounts extends AbstractFieldArray
{
    /**
     * @return void
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn(
            'name',
            [
                'label' => __('Name'),
                'class' => 'required-entry'
            ]
        );
        $this->addColumn(
            'percentage',
            [
                'label' => __('Percentage'),
                'class' => 'required-entry validate-currency-dollar'
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
