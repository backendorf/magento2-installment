<?php

/**
 * Script | Backendorf
 *
 * @category  Backendorf
 * @package   Script.php
 *
 * @copyright Copyright (c) 2020 Backendorf - Magento Developer.
 *
 * @author    Davi Backendorf <davijacksonb@gmail.com>
 */

namespace Backendorf\Installment\Block;

use \Backendorf\Installment\Helper\Data;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

/**
 * Class Script
 * @package Backendorf\Installment\Block
 */
class Script extends Template
{

    /**
     * @var Data
     */
    public $_helperData;

    /**
     * Script constructor.
     * @param Context $Context
     * @param Data $HelperData
     * @param array $Data
     */
    public function __construct(
        Context $Context,
        Data $HelperData,
        array $Data = []
    ) {
        $this->_helperData = $HelperData;
        parent::__construct($Context, $Data);
    }

    /**
     * @return false|string
     */
    public function getConfig()
    {
        return json_encode($this->_helperData->getConfig());
    }
}
