<?php
/**
 * Discounts | Backendorf
 *
 * @category  Backendorf
 * @package   Discounts.php
 *
 * @copyright Copyright (c) 2020 Backendorf - Magento Developer.
 *
 * @author    Davi Backendorf <davijacksonb@gmail.com>
 */

namespace Backendorf\Installment\Block\Adminhtml\Form\Field;

use \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Discounts
 * @package Backendorf\Installment\Block\Adminhtml\Form\Field
 */
class Discounts extends AbstractFieldArray
{

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('name', ['label' => __('Name'), 'class' => 'required-entry']);
        $this->addColumn('percentage', ['label' => __('Percentage'), 'class' => 'required-entry validate-currency-dollar']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
